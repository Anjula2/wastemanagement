<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->string('category'); // Complaint category
            $table->text('details'); // Complaint details
            $table->date('date')->nullable(); // Date of complaint
            $table->string('address')->nullable()->default('Kandy');
            $table->string('file_path')->nullable(); // For uploaded files
            $table->enum('status', ['Pending', 'In Progress', 'Resolved'])->default('Pending'); // Complaint status
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key constraint
        });
    }

    public function down()
    {
        Schema::dropIfExists('complaints');
    }
}

