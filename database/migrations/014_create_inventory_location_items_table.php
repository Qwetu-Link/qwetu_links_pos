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
        Schema::create('inventory_location_items', function (Blueprint $table) {

            $table->id();

            // STRING foreign keys
            $table->string('inventory_id');
            $table->string('inventory_location_id');

            $table->integer('quantity')->default(0);

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('inventory_id')
                ->references('id')
                ->on('inventories')
                ->cascadeOnDelete();

            $table->foreign('inventory_location_id')
                ->references('id')
                ->on('inventory_locations')
                ->cascadeOnDelete();

            // Prevent duplicate pairs
            $table->unique(['inventory_id', 'inventory_location_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_location_items');
    }
};
