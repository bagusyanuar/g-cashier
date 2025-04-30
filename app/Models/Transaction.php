<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use Uuid, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'date',
        'invoice_id',
        'customer_name',
        'sub_total',
        'discount',
        'total',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'transaction_id');
    }
}
