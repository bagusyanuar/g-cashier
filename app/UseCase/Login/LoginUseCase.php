<?php


namespace App\UseCase\Login;


use App\Commons\Response\ServiceResponse;
use App\Schemas\Login\LoginSchema;

interface LoginUseCase
{
    public function login(LoginSchema $schema): ServiceResponse;
}
