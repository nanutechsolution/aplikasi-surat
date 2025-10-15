<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan foreign key ke tabel users itu sendiri
            $table->foreignId('manager_id')
                ->nullable()
                ->after('id') // Posisikan setelah kolom ID
                ->constrained('users') // Merujuk ke tabel users
                ->onDelete('set null'); // Jika atasan dihapus, bawahan tidak ikut terhapus
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn('manager_id');
        });
    }
};
