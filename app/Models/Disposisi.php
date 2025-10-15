<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Disposisi extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi secara massal
    protected $table = "disposisi";
    protected $guarded = ['id'];

    /**
     * Mendapatkan surat masuk yang memiliki disposisi ini.
     */
    public function suratMasuk(): BelongsTo
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    /**
     * Mendapatkan user yang mengirim disposisi.
     */
    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dari_user_id');
    }

    /**
     * Mendapatkan semua user penerima disposisi.
     */
    public function penerima(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'disposisi_penerima')
            ->using(DisposisiPenerima::class) // TAMBAHKAN INI
            ->withPivot('status', 'tanggal_baca', 'tujuan_manual');
    }

    /**
     * Mendapatkan semua instruksi untuk disposisi ini.
     */
    public function instruksi(): BelongsToMany
    {
        // Terhubung ke model KategoriDisposisi melalui tabel pivot 'disposisi_instruksi'
        return $this->belongsToMany(KategoriDisposisi::class, 'disposisi_instruksi');
    }
}
