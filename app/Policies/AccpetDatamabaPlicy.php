<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AccpetDatamaba;

class AccpetDatamabaPlicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        
    }
    public function viewAny(User $user): bool
    {
        return $user->email === 'admin@gmail.com';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AccpetDatamaba $dataMahasiswa): bool
    {
        return $user->email === 'admin@gmail.com';
    }
}
