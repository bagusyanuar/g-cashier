<?php


namespace App\Http\Controllers;


use App\Schemas\Transaction\TransactionSchema;
use App\Services\TransactionService;

class TransactionController extends CustomController
{
    /** @var TransactionService $service */
    private $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new TransactionService();
    }

    public function create()
    {
        $body = $this->jsonBody();
        $schema = new TransactionSchema();
        $schema->hydrateSchemaBody($body);
        $response = $this->service->create($schema);
        return $this->toJSON($response);
    }
}
