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
        Schema::table('disposisi_penerima', function (Blueprint $table) {
            $table->string('tujuan_manual')->nullable()->after('user_id');

            // Ubah kolom user_id agar boleh kosong
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposisi_penerima', function (Blueprint $table) {
            $table->dropColumn('tujuan_manual');
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
