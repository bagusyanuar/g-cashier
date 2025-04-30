<?php


namespace App\Http\Controllers;


use App\Schemas\Product\ProductQuery;
use App\Schemas\Product\ProductSchema;
use App\Services\ProductService;

class ProductController extends CustomController
{
    /** @var ProductService $service */
    private $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new ProductService();
    }

    public function create()
    {
        $body = $this->formBody();
        $schema = new ProductSchema();
        $schema->hydrateSchemaBody($body);
        $response = $this->service->create($schema);
        return $this->toJSON($response);
    }

    public function findAll()
    {
        $query = $this->queryParams();
        $queryParams = new ProductQuery();
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
        $body = $this->formBody();
        $schema = new ProductSchema();
        $schema->hydrateSchemaBody($body);
        $response = $this->service->patch($id, $schema);
        return $this->toJSON($response);
    }

    public function delete($id)
    {
        $response = $this->service->delete($id);
        return $this->toJSON($response);
    }
}
