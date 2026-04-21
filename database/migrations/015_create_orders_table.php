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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('order_id')->unique();

            $table->string('customer_id')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');

            $table->integer('items')->default(0); // total qty
            $table->decimal('total', 10, 2);

            $table->string('payment_type');
            // $table->string('installement_plan');
            $table->string('status')->default('pending');

            $table->date('created_at_date'); // custom date
            $table->text('shipping_address')->nullable();

            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->string('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->string('business_id');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
