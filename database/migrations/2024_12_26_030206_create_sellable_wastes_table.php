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
        Schema::create('sellable_wastes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('waste_type_id')->unique();
            $table->string('waste_type');
            $table->integer('stock_level')->comment('Stock level in tons');
            $table->decimal('price', 10, 2)->comment('Price per ton');
            $table->text('description')->nullable()->comment('Optional description for waste');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellable_wastes');
    }
};
