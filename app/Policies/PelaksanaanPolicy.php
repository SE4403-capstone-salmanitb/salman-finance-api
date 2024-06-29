<?php

namespace App\Policies;

use App\Models\LaporanBulanan;
use App\Models\Pelaksanaan;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class PelaksanaanPolicy
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
    public function view(User $user, Pelaksanaan $pelaksanaan): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
        //return $laporanBulanan->disusunOleh->id === $user->id;
    }
 
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pelaksanaan $pelaksanaan): bool
    {
        return LaporanBulanan::find($pelaksanaan->id_laporan_bulanan)
            ->checkIfAuthorizedToEdit($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pelaksanaan $pelaksanaan): bool
    {
        return $pelaksanaan->laporanBulanan->checkIfAuthorizedToEdit($user);

    }
}
