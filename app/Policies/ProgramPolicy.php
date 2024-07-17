<?php

namespace App\Policies;

use App\Models\User;
use App\Models\program;
use Illuminate\Auth\Access\Response;

class ProgramPolicy
{
    /**
     * Determine whether the user can view any models.
     * Allow the user to be null (guest)
     */
    public function viewAny(User $user = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, program $program): bool
    {
        return true;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, program $program): bool
    {
        return true;
        
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, program $program): bool
    {
        return true;
    }
}
