<?php


namespace App\Schemas\Product;


use App\Commons\Schema\BaseSchema;
use Illuminate\Http\UploadedFile;

class ProductSchema extends BaseSchema
{
    private $categoryId;
    private $name;
    private $description;
    private $price;
    /** @var UploadedFile $image */
    private $image;

    protected function rules()
    {
        return [
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048'
        ];
    }

    public function hydrateBody()
    {
        $name = $this->body['name'];
        $categoryId = $this->body['category_id'];
        $price = (double) $this->body['price'];
        $description = $this->body['description'] ?? null;
        $image = $this->body['image'] ?? null;
        $this->setName($name)
            ->setCategoryId($categoryId)
            ->setPrice($price)
            ->setDescription($description)
            ->setImage($image);
    }

    /**
     * @return UploadedFile
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param UploadedFile $image
     * @return ProductSchema
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param mixed $categoryId
     * @return ProductSchema
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return ProductSchema
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return ProductSchema
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return ProductSchema
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }
}
