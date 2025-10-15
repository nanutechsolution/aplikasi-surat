<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
// UBAH INI
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Str;

class SuratMasuk extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'uuid',
        'nomor_surat',
        'tanggal_surat',
        'tanggal_diterima',
        'pengirim',
        'perihal',
        // TAMBAHKAN DUA BARIS INI
        'klasifikasi',
        'derajat',
        'sifat_surat',
        'file_path',
        'user_id',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_diterima' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function ($suratMasuk) {
            $suratMasuk->uuid = Str::uuid()->toString();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendapatkan data disposisi untuk surat ini.
     * Menggunakan HasOne karena satu surat hanya punya satu 'induk' disposisi.
     */
    public function disposisi(): HasMany
    {
        return $this->hasMany(Disposisi::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nomor_surat', 'perihal', 'pengirim'])
            ->setDescriptionForEvent(fn(string $eventName) => "Surat Masuk telah di-{$eventName}")
            ->useLogName('Surat Masuk');
    }
}
