<?php


namespace App\Http\Controllers;


use App\Commons\Response\APIResponse;
use App\Commons\Response\ServiceResponse;
use Illuminate\Http\Request;

class CustomController
{
    /** @var Request $request */
    protected $request;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
    }

    public function jsonBody()
    {
        return $this->request->json()->all();
    }

    public function queryParams()
    {
        return $this->request->query();
    }

    public function toJSON(ServiceResponse $serviceResponse)
    {
        return APIResponse::toJSONResponse(
            $serviceResponse->getStatus(),
            $serviceResponse->getMessage(),
            $serviceResponse->getData(),
            $serviceResponse->getMeta()
        );
    }
}
