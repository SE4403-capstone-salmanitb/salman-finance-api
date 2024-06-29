<?php

namespace App\Policies;

use App\Models\PenerimaManfaat;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PenerimaManfaatPolicy
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
    public function view(User $user, PenerimaManfaat $penerimaManfaat): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Implement the comlicated rule on controller
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PenerimaManfaat $penerimaManfaat): bool
    {
        
        return $penerimaManfaat->laporanBulanan->checkIfAuthorizedToEdit($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PenerimaManfaat $penerimaManfaat): bool
    {
        //
        return $penerimaManfaat->laporanBulanan->checkIfAuthorizedToEdit($user);

    }

}
