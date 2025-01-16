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
        Schema::create('waste_orders', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('company_name'); 
            $table->string('address'); 
            $table->string('contact_number'); 
            $table->unsignedBigInteger('waste_type_id');
            $table->string('waste_type'); 
            $table->integer('quantity');
            $table->decimal('price_per_ton', 10, 2);
            $table->decimal('total_price', 10, 2); 
            $table->string('status')->default('pending');
            $table->boolean('is_completed')->default(true);
            $table->timestamps(); 

            // Foreign key constraint
            $table->foreign('waste_type_id')->references('waste_type_id')->on('sellable_wastes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_orders');
    }
};
