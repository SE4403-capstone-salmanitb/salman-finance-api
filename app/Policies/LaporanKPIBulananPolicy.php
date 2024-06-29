<?php

namespace App\Policies;

use App\Models\LaporanBulanan;
use App\Models\LaporanKPIBulanan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LaporanKPIBulananPolicy
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
    public function view(User $user, LaporanKPIBulanan $laporanKPIBulanan): bool
    {
        //
        return true;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // WARNING implemet more strict policies on controller
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LaporanKPIBulanan $laporanKPIBulanan): bool
    {
        return LaporanBulanan::find($laporanKPIBulanan->id_laporan_bulanan)
            ->checkIfAuthorizedToEdit($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LaporanKPIBulanan $laporanKPIBulanan): bool
    {
        //
        return $laporanKPIBulanan->laporanBulanan->checkIfAuthorizedToEdit($user);

    }
}
