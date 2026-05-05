<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $authUser): bool
    {
        return in_array($authUser->role, ['gestor', 'admin']);
    }

    public function view(User $authUser, User $user): bool
    {
        return $authUser->role === 'admin' || 
               ($authUser->role === 'gestor' && $user->role === 'usuario') ||
               $authUser->id === $user->id;
    }

    public function create(User $authUser): bool
    {
        return in_array($authUser->role, ['gestor', 'admin']);
    }

    public function update(User $authUser, User $user): bool
    {
        return $authUser->role === 'admin' || 
               ($authUser->role === 'gestor' && $user->role === 'usuario') ||
               $authUser->id === $user->id;
    }

    public function delete(User $authUser, User $user): bool
    {
        return $authUser->role === 'admin' || 
               ($authUser->role === 'gestor' && $user->role === 'usuario');
    }
}
