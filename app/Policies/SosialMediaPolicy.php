<?php

namespace App\Policies;

use App\Models\User;

class SosialMediaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
          public function viewAny(User $user): bool
    {
        return $user->email === 'admin@gmail.com';
    }
    
       public function view(User $user): bool
    {
        return $user->email === 'admin@gmail.com';
    }
}
