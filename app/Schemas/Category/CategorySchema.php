<?php


namespace App\Schemas\Category;


use App\Commons\Schema\BaseSchema;

class CategorySchema extends BaseSchema
{
    private $name;

    protected function rules()
    {
        return [
            'name' => 'required'
        ];
    }

    public function hydrateBody()
    {
        $name = $this->body['name'];
        $this->setName($name);
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
     * @return CategorySchema
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
