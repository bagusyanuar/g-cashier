<?php


namespace App\UseCase;


use App\Commons\Response\ServiceResponse;
use App\Schemas\Product\ProductQuery;
use App\Schemas\Product\ProductSchema;

interface ProductUseCase
{
    public function create(ProductSchema $schema): ServiceResponse;
    public function findAll(ProductQuery $queryParams): ServiceResponse;
    public function findByID($id): ServiceResponse;
    public function patch($id, ProductSchema $schema): ServiceResponse;
    public function delete($id): ServiceResponse;
}
