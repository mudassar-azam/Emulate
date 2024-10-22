<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('product_id')->constrained('items');
            $table->foreignId('product_owner_id')->constrained('users');
            $table->string('lease_term')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('start_date')->nullable(); 
            $table->string('end_date')->nullable();   
            $table->string('type');
            $table->string('total_payment');
            $table->string('payment_status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
