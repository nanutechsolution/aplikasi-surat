<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriDisposisi extends Model
{
    use HasFactory;
    protected $table = 'kategori_disposisi';

    protected $fillable = ['nama', 'keterangan'];


    public function disposisis()
    {
        return $this->hasMany(\App\Models\Disposisi::class, 'kategori_disposisi_id');
    }

}
