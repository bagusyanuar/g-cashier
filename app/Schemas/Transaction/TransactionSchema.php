<?php


namespace App\Schemas\Transaction;


use App\Commons\Schema\BaseSchema;

class TransactionSchema extends BaseSchema
{
    private $customerName;
    /** @var array $carts */
    private $carts;

    protected function rules()
    {
        return [
            'carts' => 'required|array|min:1',
            'carts.*.product_id' => 'required',
            'carts.*.qty' => 'required|numeric',
            'carts.*.price' => 'required|numeric',
        ];
    }

    public function hydrateBody()
    {
        /** @var array $carts */
        $carts = $this->body['carts'];
        $customerName = $this->body['customer_name'] ?? null;
        $this->setCarts($carts)
            ->setCustomerName($customerName);
    }

    /**
     * @return array
     */
    public function getCarts()
    {
        return $this->carts;
    }

    /**
     * @param array $carts
     * @return TransactionSchema
     */
    public function setCarts($carts)
    {
        $this->carts = $carts;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @param mixed $customerName
     * @return TransactionSchema
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
        return $this;
    }
}
