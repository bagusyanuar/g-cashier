<?php


namespace App\Schemas\Category;


use App\Commons\Schema\BaseSchema;

class CategoryQuery extends BaseSchema
{
    private $param;
    private $page;
    private $perPage;

    public function hydrateQuery()
    {
        $param = $this->query['param'] ?? '';
        $page = $this->query['page'] ?? 1;
        $perPage = $this->query['per_page'] ?? 10;

        $this->setParam($param)
            ->setPage((int) $page)
            ->setPerPage((int) $perPage);
    }

    /**
     * @return mixed
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * @param mixed $param
     * @return CategoryQuery
     */
    public function setParam($param)
    {
        $this->param = $param;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     * @return CategoryQuery
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @param mixed $perPage
     * @return CategoryQuery
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }
}
