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
        Schema::create('work_shifts', function (Blueprint $table) {
            $table->id();
            $table->json('worker_ids')->nullable();  
            $table->unsignedBigInteger('driver_id')->nullable(); 
            $table->unsignedBigInteger('supervisor_id')->nullable(); 
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('waste_collection_zone_id')->nullable(); 
            $table->string('shift_type'); 
            $table->timestamp('shift_start')->nullable(); 
            $table->timestamp('shift_end')->nullable();
            $table->timestamps();


            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->foreign('supervisor_id')->references('id')->on('supervisors')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');
            $table->foreign('waste_collection_zone_id')->references('id')->on('waste_collection_zones')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_shifts');
    }
};
