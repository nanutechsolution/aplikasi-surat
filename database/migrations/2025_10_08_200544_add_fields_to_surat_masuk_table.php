<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->date('tanggal_diterima')->after('tanggal_surat');
            $table->string('sifat_surat')->after('perihal')->default('Biasa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropColumn('tanggal_diterima');
            $table->dropColumn('sifat_surat');
        });
    }
};
