<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kategori_disposisi_role', function (Blueprint $table) {
            // Primary key gabungan untuk mencegah duplikasi
            $table->primary(['kategori_disposisi_id', 'role_id']);
            // KODE BENAR
            $table->foreignId('kategori_disposisi_id')->constrained('kategori_disposisi')->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_disposisi_role');
    }
};
