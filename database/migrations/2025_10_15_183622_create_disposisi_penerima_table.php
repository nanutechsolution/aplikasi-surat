<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('disposisi_penerima', function (Blueprint $table) {
            $table->id();
            // BENAR
            $table->foreignId('disposisi_id')->constrained('disposisi')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('Terkirim');
            $table->dateTime('tanggal_baca')->nullable();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('disposisi_penerima');
    }
};
