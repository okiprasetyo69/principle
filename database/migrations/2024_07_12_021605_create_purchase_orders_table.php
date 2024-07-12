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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_order_number')->nullable();
            $table->bigInteger('distributor_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->integer('qty')->nullable();
            $table->bigInteger('total_price')->nullable();
            $table->date('purchase_order_date')->nullable();
            $table->date('verified_date')->nullable();
            $table->bigInteger('verified_by')->nullable();
            $table->integer('status')->nullable(); // 0 : In Order , 1 : Verified by principal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
