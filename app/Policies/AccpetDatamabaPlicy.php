<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AccpetDatamaba;

class AccpetDatamabaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any data maba.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view a specific data maba.
     */
    public function view(User $user, AccpetDatamaba $dataMahasiswa): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create new data maba.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the data maba.
     */
    public function update(User $user, AccpetDatamaba $dataMahasiswa): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the data maba.
     */
    public function delete(User $user, AccpetDatamaba $dataMahasiswa): bool
    {
        return $user->role === 'admin';
    }
}
