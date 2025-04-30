<?php


namespace App\Services;


use App\Commons\Response\ServiceResponse;
use App\Models\Transaction;
use App\Schemas\Transaction\TransactionSchema;
use App\UseCase\TransactionUseCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionUseCase
{
    public function create(TransactionSchema $schema): ServiceResponse
    {
        // TODO: Implement create() method.
        try {
            DB::beginTransaction();
            $validator = $schema->validate();
            if ($validator->fails()) {
                return ServiceResponse::unprocessableEntity($validator->errors()->toArray());
            }
            $schema->hydrateBody();

            $carts = collect($schema->getCarts());
            $subTotal = $carts->sum(function ($cart) {
                return $cart['qty'] * $cart['price'];
            });
            $discount = 0;
            $total = $subTotal - $discount;
            $dataTransaction = [
                'date' => Carbon::now(),
                'invoice_id' => date('YmdHis'),
                'customer_name' => $schema->getCustomerName(),
                'sub_total' => $subTotal,
                'discount' => $discount,
                'total' => $total,
            ];
            $transaction = Transaction::create($dataTransaction);
            $dataCarts = [];
            foreach ($carts as $cart) {
                $tmp['transaction_id'] = $transaction->id;
                $tmp['product_id'] = $cart['product_id'];
                $tmp['price'] = $cart['price'];
                $tmp['qty'] = $cart['qty'];
                $tmp['total'] = ($cart['price'] * $cart['qty']);
                array_push($dataCarts, $tmp);
            }
            $transaction->carts()->createMany($dataCarts);
            DB::commit();
            return ServiceResponse::statusCreated("successfully create transaction");
        } catch (\Throwable $e) {
            DB::rollBack();
            return ServiceResponse::internalServerError($e->getMessage());
        }
    }
}
