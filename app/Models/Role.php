<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends SpatieRole
{
    /**
     * Sebuah Role bisa memiliki banyak Kategori Disposisi.
     */
    public function kategoriDisposisi(): BelongsToMany
    {
        // Terhubung ke model KategoriDisposisi melalui pivot table 'kategori_disposisi_role'
        return $this->belongsToMany(KategoriDisposisi::class, 'kategori_disposisi_role');
    }
}
