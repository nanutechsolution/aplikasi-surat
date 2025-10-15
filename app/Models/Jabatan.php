<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'nama_jabatan',
        'deskripsi',
    ];

    /**
     * Mendefinisikan relasi one-to-many ke model User.
     * Satu jabatan bisa dimiliki oleh banyak user.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
