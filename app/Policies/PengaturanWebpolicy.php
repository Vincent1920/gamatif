<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PengaturanWeb;

class PengaturanWebPolicy
{
    /**
     * Tentukan apakah user bisa melihat daftar pengaturan.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa melihat detail pengaturan.
     */
    public function view(User $user, PengaturanWeb $pengaturanWeb): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa membuat pengaturan baru.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa update pengaturan.
     */
    public function update(User $user, PengaturanWeb $pengaturanWeb): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa hapus pengaturan.
     */
    public function delete(User $user, PengaturanWeb $pengaturanWeb): bool
    {
        return $user->role === 'admin';
    }
}
