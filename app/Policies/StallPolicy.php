<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Stall;

class StallPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Stall $stall): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'manager']);
    }

    public function update(User $user, Stall $stall): bool
    {
        return in_array($user->role, ['admin', 'manager']);
    }

    public function delete(User $user, Stall $stall): bool
    {
        return $user->role === 'admin';
    }
}
