<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use Uuid, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'product_id',
        'price',
    ];

    protected $casts = [
        'price' => 'double'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
