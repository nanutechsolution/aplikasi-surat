<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class SuratKeluar extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'tujuan',
        'perihal',
        'file_path',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    /**
     * Relasi: Satu surat keluar dibuat oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nomor_surat', 'perihal', 'tujuan'])
            ->setDescriptionForEvent(fn(string $eventName) => "Surat Keluar telah di-{$eventName}")
            ->useLogName('Surat Keluar');
    }
}
