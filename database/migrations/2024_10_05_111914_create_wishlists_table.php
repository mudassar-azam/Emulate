<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('image'); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key for user ID
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
