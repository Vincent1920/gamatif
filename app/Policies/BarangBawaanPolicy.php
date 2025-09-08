<?php

namespace App\Policies;

use App\Models\User;

class BarangBawaanPolicy
{
        public function viewAny(User $user): bool
    {
        return $user->email === 'admin@gmail.com';
    }
    
    public function view(User $user, BarangBawaanPolicy $barang_bawaan): bool
    {
        return $user->email === 'admin@gmail.com';
    }

}
