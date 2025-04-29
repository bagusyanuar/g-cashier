<?php


namespace App\Http\Controllers;


use App\Schemas\Category\CategoryQuery;
use App\Schemas\Category\CategorySchema;
use App\Services\CategoryService;

class CategoryController extends CustomController
{
    /** @var CategoryService $service */
    private $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new CategoryService();
    }

    public function create()
    {
        $body = $this->jsonBody();
        $schema = new CategorySchema();
        $schema->hydrateSchemaBody($body);
        $response = $this->service->create($schema);
        return $this->toJSON($response);
    }

    public function findAll()
    {
        $query = $this->queryParams();
        $queryParams = new CategoryQuery();
        $queryParams->hydrateSchemaQuery($query);
        $response = $this->service->findAll($queryParams);
        return $this->toJSON($response);
    }

    public function findByID($id)
    {
        $response = $this->service->findByID($id);
        return $this->toJSON($response);
    }

    public function patch($id)
    {
        $body = $this->jsonBody();
        $schema = new CategorySchema();
        $schema->hydrateSchemaBody($body);
        $response = $this->service->patch($id, $schema);
        return $this->toJSON($response);
    }
}
