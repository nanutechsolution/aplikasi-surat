<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('disposisi_instruksi', function (Blueprint $table) {
            $table->primary(['disposisi_id', 'kategori_disposisi_id']);
            $table->foreignId('disposisi_id')->constrained('disposisi')->onDelete('cascade');
            $table->foreignId('kategori_disposisi_id')->constrained('kategori_disposisi')->onDelete('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('disposisi_instruksi');
    }
};
