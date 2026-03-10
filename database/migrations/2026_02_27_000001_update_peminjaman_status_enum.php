<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration 
{
    public function up(): void
    {
        // MySQL: modify enum to add 'pengajuan_kembali' and 'ditolak'
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('pending','dipinjam','pengajuan_kembali','dikembalikan','terlambat','ditolak') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('pending','dipinjam','dikembalikan','terlambat') NOT NULL DEFAULT 'pending'");
    }
};
