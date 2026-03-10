<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('koleksi_pribadi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['user_id', 'book_id']); // Prevent duplicates
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koleksi_pribadi');
    }
};
