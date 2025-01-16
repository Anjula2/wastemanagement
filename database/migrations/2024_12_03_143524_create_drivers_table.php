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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('driver_id')->unique()->nullable(); 
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('licence_no')->nullable();
            $table->text('address')->nullable();
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->string('status')->default('Available');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
