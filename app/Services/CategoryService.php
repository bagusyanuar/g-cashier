<?php


namespace App\Services;


use App\Commons\Pagination\Pagination;
use App\Commons\Response\ServiceResponse;
use App\Models\Category;
use App\Schemas\Category\CategoryQuery;
use App\Schemas\Category\CategorySchema;
use App\UseCase\CategoryUseCase;
use Illuminate\Database\Eloquent\Builder;

class CategoryService implements CategoryUseCase
{
    public function create(CategorySchema $schema): ServiceResponse
    {
        try {
            $validator = $schema->validate();
            if ($validator->fails()) {
                return ServiceResponse::unprocessableEntity($validator->errors()->toArray());
            }
            $schema->hydrateBody();

            $data = [
                'name' => $schema->getName()
            ];
            Category::create($data);
            return ServiceResponse::statusCreated("successfully create category");
        } catch (\Throwable $e) {
            return ServiceResponse::internalServerError($e->getMessage());
        }
    }

    public function findAll(CategoryQuery $queryParams): ServiceResponse
    {
        try {
            $queryParams->hydrateQuery();
            $query = Category::with([])
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
            return ServiceResponse::statusOK("successfully get categories", $data, ['pagination' => $metaPagination]);
        } catch (\Throwable $e) {
            return ServiceResponse::internalServerError($e->getMessage());
        }
    }

    public function findByID($id): ServiceResponse
    {
        try {
            $data = Category::with([])
                ->where('id', '=', $id)
                ->first();

            if (!$data) {
                return ServiceResponse::notFound("category not found");
            }
            return ServiceResponse::statusOK("successfully get category", $data);
        } catch (\Throwable $e) {
            return ServiceResponse::internalServerError($e->getMessage());
        }
    }

    public function patch($id, CategorySchema $schema): ServiceResponse
    {
        try {
            $validator = $schema->validate();
            if ($validator->fails()) {
                return ServiceResponse::unprocessableEntity($validator->errors()->toArray());
            }
            $schema->hydrateBody();

            $category = Category::with([])
                ->where('id', '=', $id)
                ->first();
            if (!$category) {
                return ServiceResponse::notFound("category not found");
            }
            $data = [
                'name' => $schema->getName()
            ];
            $category->update($data);
            return ServiceResponse::statusOK("successfully update category");
        } catch (\Throwable $e) {
            return ServiceResponse::internalServerError($e->getMessage());
        }
    }
}
