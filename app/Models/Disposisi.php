<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi';

    protected $fillable = [
        'surat_masuk_id',
        'dari_user_id',
        'kepada_user_id',
        'isi_disposisi',
        'status',
    ];

    // Relasi: Satu disposisi dimiliki oleh satu surat
    public function suratMasuk(): BelongsTo
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    // Relasi: Satu disposisi dikirim oleh satu user (pengirim)
    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dari_user_id');
    }

    // Relasi: Satu disposisi ditujukan ke satu user (penerima)
    public function penerima(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kepada_user_id');
    }
}
