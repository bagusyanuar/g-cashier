<?php


namespace App\UseCase;


use App\Commons\Response\ServiceResponse;
use App\Schemas\Category\CategoryQuery;
use App\Schemas\Category\CategorySchema;

interface CategoryUseCase
{
    public function create(CategorySchema $schema): ServiceResponse;
    public function findAll(CategoryQuery $queryParams): ServiceResponse;
    public function findByID($id): ServiceResponse;
    public function patch($id, CategorySchema $schema): ServiceResponse;
    public function delete($id): ServiceResponse;
}
