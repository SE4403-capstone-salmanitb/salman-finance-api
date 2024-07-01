<?php

namespace App\Policies;

use App\Models\Dana;
use App\Models\LaporanBulanan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DanaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Dana $dana): bool
    {
        //
        return true;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // implement complicated rule on controller
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Dana $dana): bool
    {
        //
        return LaporanBulanan::find($dana->id_laporan_bulanan)
            ->checkIfAuthorizedToEdit($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Dana $dana): bool
    {
        //
        return $dana->laporanBulanan->checkIfAuthorizedToEdit($user);
    }
}
