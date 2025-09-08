<?php

namespace App\Policies;

use App\Models\User;
use App\Models\kelompok;
use Illuminate\Auth\Access\Response;

class KelompokPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
         return $user->email === 'admin@gmail.com';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, kelompok $kelompok): bool
    {
         return $user->email === 'admin@gmail.com';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
         return $user->email === 'admin@gmail.com';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, kelompok $kelompok): bool
    {
         return $user->email === 'admin@gmail.com';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, kelompok $kelompok): bool
    {
         return $user->email === 'admin@gmail.com';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, kelompok $kelompok): bool
    {
        return $user->email === 'admin@gmail.com';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, kelompok $kelompok): bool
    {
          return $user->email === 'admin@gmail.com';
    }
}
