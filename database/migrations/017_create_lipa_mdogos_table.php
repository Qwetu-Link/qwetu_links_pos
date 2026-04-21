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
        Schema::create('lipa_mdogos', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('plan_id')->unique(); // generatePlanId()
            $table->string('order_id')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('remaining_amount', 10, 2);
            $table->integer('installments');
            $table->decimal('installment_amount', 10, 2);
            $table->string('frequency')->default('monthly');
            $table->date('next_payment_date');
            $table->string('status')->default('active');
            $table->string('payment_method');
            $table->date('start_date');
            $table->integer('days_overdue')->default(0);
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lipa_mdogos');
    }
};
