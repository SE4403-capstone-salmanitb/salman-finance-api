<?php

namespace App\Policies;

use App\Models\Bidang;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BidangPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user = null): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Bidang $bidang): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_admin == 1;
        
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Bidang $bidang): bool
    {
        return $user->is_admin == 1;
        
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bidang $bidang): bool
    {
        return $user->is_admin == 1;   
    }
}
