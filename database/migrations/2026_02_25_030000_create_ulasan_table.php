<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned()->default(5); // 1-5 bintang
            $table->text('komentar')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'book_id']); // 1 ulasan per user per buku
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
