<?php


namespace App\UseCase;


use App\Commons\Response\ServiceResponse;
use App\Schemas\Transaction\TransactionSchema;

interface TransactionUseCase
{
    public function create(TransactionSchema $schema): ServiceResponse;
}
