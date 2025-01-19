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
        Schema::create('supervisors', function (Blueprint $table) {
            $table->id(); 
            $table->string('supervisor_id')->unique();
            $table->unsignedBigInteger('zone_id');
            $table->string('name'); 
            $table->string('phone'); 
            $table->string('nic_no'); 
            $table->string('address'); 
            $table->date('date');
            $table->string('status')->default('Available'); 
            $table->boolean('is_available')->default(true);
            $table->timestamps(); 

            $table->foreign('zone_id')->references('id')->on('waste_collection_zones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisors');
    }
};
