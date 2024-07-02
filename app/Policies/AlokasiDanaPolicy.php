<?php

namespace App\Policies;

use App\Models\AlokasiDana;
use App\Models\LaporanBulanan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AlokasiDanaPolicy
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
    public function view(User $user, AlokasiDana $alokasiDana): bool
    {
        //
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
    public function update(User $user, AlokasiDana $alokasiDana): bool
    {
        //
        return LaporanBulanan::find($alokasiDana->id_laporan_bulanan)
        ->checkIfAuthorizedToEdit($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AlokasiDana $alokasiDana): bool
    {
        return $alokasiDana->laporanBulanan->checkIfAuthorizedToEdit($user);
    }

}
