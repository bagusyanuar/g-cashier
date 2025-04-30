<?php


namespace App\Services;


use App\Commons\FileUpload\FileUpload;
use App\Commons\Pagination\Pagination;
use App\Commons\Response\ServiceResponse;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Schemas\Product\ProductQuery;
use App\Schemas\Product\ProductSchema;
use App\UseCase\ProductUseCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProductService implements ProductUseCase
{
    public function create(ProductSchema $schema): ServiceResponse
    {
        // TODO: Implement create() method.
        try {
            DB::beginTransaction();
            $validator = $schema->validate();
            if ($validator->fails()) {
                return ServiceResponse::unprocessableEntity($validator->errors()->toArray());
            }
            $schema->hydrateBody();
            $fileImage = $schema->getImage();
            $image = null;
            if ($fileImage) {
                $fileUploadService = new FileUpload($fileImage, 'products');
                $fileUploadResponse = $fileUploadService->upload();
                if (!$fileUploadResponse->isSuccess()) {
                    return ServiceResponse::internalServerError('failed to upload file');
                }
                $image = $fileUploadResponse->getData();
            }

            $dataProduct = [
                'category_id' => $schema->getCategoryId(),
                'name' => $schema->getName(),
                'image' => $image,
                'description' => $schema->getName()
            ];
            $product = Product::create($dataProduct);
            $dataPrice = [
                'product_id' => $product->id,
                'price' => $schema->getPrice()
            ];
            ProductPrice::create($dataPrice);
            DB::commit();
            return ServiceResponse::statusCreated("successfully create product");
        } catch (\Throwable $e) {
            DB::rollBack();
            return ServiceResponse::internalServerError($e->getMessage());
        }
    }

    public function findAll(ProductQuery $queryParams): ServiceResponse
    {
        // TODO: Implement findAll() method.
        try {
            $queryParams->hydrateQuery();
            $query = Product::with(['price:id,product_id,price', 'category:id,name'])
                ->when($queryParams->getCategoryId(), function ($q) use ($queryParams) {
                    /** @var Builder $q */
                    return $q->where('category_id', '=', $queryParams->getCategoryId());
                })
                ->when($queryParams->getParam(), function ($q) use ($queryParams) {
                    /** @var Builder $q */
                    return $q->where('name', 'LIKE', "%{$queryParams->getParam()}%");
                });
            $pagination = new Pagination();
            $pagination->setQuery($query)
                ->setPage($queryParams->getPage())
                ->setPerPage($queryParams->getPerPage())
                ->paginate();
            $data = $pagination->getData();
            $metaPagination = $pagination->getJsonMeta();
            return ServiceResponse::statusOK("successfully get products", $data, ['pagination' => $metaPagination]);
        } catch (\Throwable $e) {
            return ServiceResponse::internalServerError($e->getMessage());
        }
    }

    public function findByID($id): ServiceResponse
    {
        // TODO: Implement findByID() method.
        try {
            $data = Product::with(['price:id,product_id,price', 'category:id,name'])
                ->where('id', '=', $id)
                ->first();
            if (!$data) {
                return ServiceResponse::notFound('product not found');
            }
            return ServiceResponse::statusOK("successfully get product", $data);
        } catch (\Throwable $e) {
            return ServiceResponse::internalServerError($e->getMessage());
        }
    }

    public function patch($id, ProductSchema $schema): ServiceResponse
    {
        // TODO: Implement patch() method.
        try {
            DB::beginTransaction();
            $validator = $schema->validate();
            if ($validator->fails()) {
                return ServiceResponse::unprocessableEntity($validator->errors()->toArray());
            }
            $schema->hydrateBody();
            $product = Product::with(['price'])
                ->where('id', '=', $id)
                ->first();
            if (!$product) {
                return ServiceResponse::notFound('product not found');
            }
            $fileImage = $schema->getImage();
            $image = null;
            if ($fileImage) {
                $fileUploadService = new FileUpload($fileImage, 'products');
                $fileUploadResponse = $fileUploadService->upload();
                if (!$fileUploadResponse->isSuccess()) {
                    return ServiceResponse::internalServerError('failed to upload file');
                }
                $image = $fileUploadResponse->getData();
            }
            $dataProduct = [
                'category_id' => $schema->getCategoryId(),
                'name' => $schema->getName(),
                'description' => $schema->getDescription()
            ];
            if ($image) {
                $dataProduct['image'] = $image;
            }
            $product->update($dataProduct);
            $product->price()->update([
                'price' => $schema->getPrice()
            ]);
            DB::commit();
            return ServiceResponse::statusOK("successfully update product");
        } catch (\Throwable $e) {
            DB::rollBack();
            return ServiceResponse::internalServerError($e->getMessage());
        }
    }

    public function delete($id): ServiceResponse
    {
        // TODO: Implement delete() method.
        try {
            DB::beginTransaction();
            $product = Product::with(['price'])
                ->where('id', '=', $id)
                ->first();
            if (!$product) {
                return ServiceResponse::notFound('product not found');
            }
            $product->price()->delete();
            $product->delete();
            DB::commit();
            return ServiceResponse::statusOK("successfully delete product");
        } catch (\Throwable $e) {
            DB::rollBack();
            return ServiceResponse::internalServerError($e->getMessage());
        }
    }
}
