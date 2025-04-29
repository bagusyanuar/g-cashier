<?php


namespace App\Http\Controllers;


use App\Schemas\Login\LoginSchema;
use App\Services\LoginService;

class LoginController extends CustomController
{
    /** @var LoginService $service */
    private $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new LoginService();
    }

    public function login()
    {
        $body = $this->jsonBody();
        $schema = new LoginSchema();
        $schema->hydrateSchemaBody($body);
        $response = $this->service->login($schema);
        return $this->toJSON($response);
    }
}
