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
        Schema::create('inventories', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('variant_id')->nullable();
            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->integer('total_stock')->default(0);
            $table->integer('reorder_point')->default(0);
            $table->string('status')->default('healthy'); // low, out_of_stock

            $table->date('last_restocked')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
