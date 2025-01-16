<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('delivery_option'); // pickup or delivery
            $table->string('address')->nullable(); // Required only for delivery
            $table->decimal('total', 10, 2); // Total order amount
            $table->string('status')->default('pending'); // e.g., pending, completed, canceled
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
