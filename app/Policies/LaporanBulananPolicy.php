<?php

namespace App\Policies;

use App\Models\LaporanBulanan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LaporanBulananPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LaporanBulanan $laporanBulanan): bool
    {
        return true;
        
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return true;

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LaporanBulanan $laporanBulanan): bool
    {
        //
        return $user->id === $laporanBulanan->disusun_oleh 
        && $laporanBulanan->diperiksa_oleh === null;
    }

    /**
     * Determine whether the user can update the model on the verify field.
     */
    public function verify(User $user, LaporanBulanan $laporanBulanan): bool
    {
        //
        return $laporanBulanan->diperiksa_oleh === null;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LaporanBulanan $laporanBulanan): bool
    {
        //
        return true;

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LaporanBulanan $laporanBulanan): bool
    {
        //
        return true;

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LaporanBulanan $laporanBulanan): bool
    {
        //
        return true;

    }
}
