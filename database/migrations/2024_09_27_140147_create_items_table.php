<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('sale_price', 8, 2)->nullable();
            $table->decimal('rental_price', 8, 2)->nullable();
            $table->string('item_type');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description');
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
