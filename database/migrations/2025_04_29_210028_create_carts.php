<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transaction_id')->nullable();
            $table->uuid('product_id');
            $table->float('price')->default(0);
            $table->integer('qty')->default(0);
            $table->float('total')->default(0);
            $table->timestamps();
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
