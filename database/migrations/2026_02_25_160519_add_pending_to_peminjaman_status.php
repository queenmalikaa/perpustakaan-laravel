<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration 
{
    public function up(): void
    {
        // MySQL requires re-declaring the full ENUM to add a new value
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('pending','dipinjam','dikembalikan','terlambat') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('dipinjam','dikembalikan','terlambat') NOT NULL DEFAULT 'dipinjam'");
    }
};
