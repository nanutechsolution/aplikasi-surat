<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DisposisiPenerima extends Pivot
{
    protected $table = 'disposisi_penerima';

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk mendapatkan nama, baik dari user atau manual
    public function getNamaPenerimaAttribute(): string
    {
        return $this->user->name ?? $this->tujuan_manual;
    }
}
