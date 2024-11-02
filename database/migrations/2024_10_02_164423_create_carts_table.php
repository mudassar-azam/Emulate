<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->foreignId('product_owner_id')->nullable()->constrained('users');
            $table->string('lease_term')->nullable();
            $table->string('start_date')->nullable(); 
            $table->string('end_date')->nullable();   
            $table->string('type')->nullable();
            $table->string('total_payment')->nullable();
            $table->string('payment_status')->nullable();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
