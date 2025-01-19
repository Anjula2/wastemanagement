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
        Schema::create('waste_collecting_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('schedule_id')->unique()->nullable();
            $table->enum('date', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']); // Days of the week
            $table->time('start_time');
            $table->time('end_time');
            $table->foreignId('waste_collection_zone_id') 
                  ->constrained('waste_collection_zones')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->string('waste_type'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_collecting_schedules');
    }
};
