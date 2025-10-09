<?php

namespace App\Policies;

use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SuratMasukPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SuratMasuk $suratMasuk): bool
    {
        // 1. Izinkan jika user adalah admin atau pimpinan
        if ($user->hasAnyRole(['admin', 'pimpinan'])) {
            return true;
        }

        // 2. Izinkan jika surat ini pernah didisposisikan kepada user tersebut
        return $suratMasuk->disposisi()->where('kepada_user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SuratMasuk $suratMasuk): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SuratMasuk $suratMasuk): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SuratMasuk $suratMasuk): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SuratMasuk $suratMasuk): bool
    {
        return false;
    }
}
