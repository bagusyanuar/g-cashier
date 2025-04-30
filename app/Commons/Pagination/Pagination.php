<?php


namespace App\Commons\Pagination;


class Pagination
{
    private $query;
    private $page;
    private $perPage;
    /** @var array $data */
    private $data;
    /** @var MetaPagination $meta */
    private $meta;
    /** @var mixed|null $jsonMeta */
    private $jsonMeta;

    public function paginate()
    {
        $totalRows = $this->query->count();
        $totalPages = ceil($totalRows / $this->perPage);
        $offset = ($this->page - 1) * $this->perPage;
        $data = $this->query->limit($this->perPage)
            ->offset($offset)
            ->get();
        $this->setData($data);
        $this->setMeta(new MetaPagination($this->page, $this->perPage, $totalRows, $totalPages));
        $jsonMeta = MetaPagination::toJSON($this->page, $this->perPage, $totalRows, $totalPages);
        $this->setJsonMeta($jsonMeta);
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     * @return Pagination
     */
    public function setQuery($query)
    {
        $this->query = $query;
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
     * @return Pagination
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
     * @return Pagination
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return Pagination
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return MetaPagination
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param MetaPagination $meta
     * @return Pagination
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getJsonMeta()
    {
        return $this->jsonMeta;
    }

    /**
     * @param mixed|null $jsonMeta
     * @return Pagination
     */
    public function setJsonMeta($jsonMeta)
    {
        $this->jsonMeta = $jsonMeta;
        return $this;
    }
}
