<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Str;
class SuratMasuk extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surat_masuk'; // Opsional, tapi baik untuk kejelasan

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'nomor_surat',
        'tanggal_surat',
        'tanggal_diterima',
        'pengirim',
        'perihal',
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
            // Generate UUID saat data baru akan dibuat
            $suratMasuk->uuid = Str::uuid()->toString();
        });
    }

    /**
     * Mendefinisikan relasi ke model User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function disposisi(): HasMany
    {
        return $this->hasMany(Disposisi::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nomor_surat', 'perihal', 'pengirim']) // Catat hanya perubahan pada kolom ini
            ->setDescriptionForEvent(fn(string $eventName) => "Surat Masuk telah di-{$eventName}")
            ->useLogName('Surat Masuk');
    }
}
