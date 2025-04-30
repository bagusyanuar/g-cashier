<?php


namespace App\Commons\Pagination;


class MetaPagination
{
    private $page;
    private $perPage;
    private $totalRows;
    private $totalPages;

    /**
     * MetaPagination constructor.
     * @param $page
     * @param $perPage
     * @param $totalRows
     * @param $totalPages
     */
    public function __construct($page, $perPage, $totalRows, $totalPages)
    {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->totalRows = $totalRows;
        $this->totalPages = $totalPages;
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
     * @return MetaPagination
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
     * @return MetaPagination
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalRows()
    {
        return $this->totalRows;
    }

    /**
     * @param mixed $totalRows
     * @return MetaPagination
     */
    public function setTotalRows($totalRows)
    {
        $this->totalRows = $totalRows;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * @param mixed $totalPages
     * @return MetaPagination
     */
    public function setTotalPages($totalPages)
    {
        $this->totalPages = $totalPages;
        return $this;
    }

    public static function toJSON($page, $perPage, $totalRows, $totalPages)
    {
        return [
            'page' => $page,
            'per_page' => $perPage,
            'total_rows' => $totalRows,
            'total_pages' => $totalPages
        ];
    }
}
