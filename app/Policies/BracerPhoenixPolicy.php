<?php

namespace App\Policies;

use App\Models\DataMahasiswa;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BracerPhoenixPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->email === 'Bracer_Phoenix@gmail.com' || $user->email === 'admin@gmail.com';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DataMahasiswa $dataMahasiswa): bool
    {
        return $user->email === 'Bracer_Phoenix@gmail.com';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->email === 'Bracer_Phoenix@gmail.com';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DataMahasiswa $dataMahasiswa): bool
    {
        return $user->email === 'Bracer_Phoenix@gmail.com';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DataMahasiswa $dataMahasiswa): bool
    {
        return $user->email === 'Bracer_Phoenix@gmail.com';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DataMahasiswa $dataMahasiswa): bool
    {
        return $user->email === 'Bracer_Phoenix@gmail.com';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DataMahasiswa $dataMahasiswa): bool
    {
        return $user->email === 'Bracer_Phoenix@gmail.com';
    }
    public function deleteAny(User $user): bool
    {
        return $user->email === 'Bracer_Phoenix@gmail.com';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restoreAny(User $user): bool
    {
        return $user->email('Bracer_Phoenix@gmail.com');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->email('Bracer_Phoenix@gmail.com');
    }
}
