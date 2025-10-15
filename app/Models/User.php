<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'jabatan_id', // Pastikan ini ada
        'manager_id', // Kolom baru untuk hierarki
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELASI JABATAN & HIERARKI ---

    /**
     * Mendapatkan data jabatan dari user ini.
     */
    public function jabatan(): BelongsTo
    {
        // Pastikan nama model 'Jabatan' sudah benar
        return $this->belongsTo(Jabatan::class);
    }

    /**
     * Mendapatkan data atasan dari user ini.
     */
    public function atasan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Mendapatkan semua bawahan langsung dari user ini.
     */
    public function bawahan(): HasMany
    {
        return $this->hasMany(User::class, 'manager_id');
    }


    // --- RELASI DISPOSISI (STRUKTUR BARU) ---

    /**
     * Mendapatkan semua disposisi yang DIKIRIMKAN oleh user ini.
     */
    public function disposisiKeluar(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'dari_user_id');
    }

    /**
     * Mendapatkan semua disposisi yang DITERIMA oleh user ini.
     * Menggunakan BelongsToMany karena melalui pivot table 'disposisi_penerima'.
     */
    public function disposisiMasuk(): BelongsToMany
    {
        return $this->belongsToMany(Disposisi::class, 'disposisi_penerima')
            ->withPivot('status', 'tanggal_baca') // Untuk akses kolom tambahan di pivot
            ->withTimestamps(); // Jika pivot table memiliki timestamps
    }
}
