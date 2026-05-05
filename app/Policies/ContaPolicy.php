<?php

namespace App\Policies;

use App\Models\Conta;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $authUser): bool
    {
        return in_array($authUser->role, ['usuario', 'gestor', 'admin']);
    }

    public function view(User $authUser, Conta $conta): bool
    {
        return $authUser->id === $conta->user_id || 
               in_array($authUser->role, ['gestor', 'admin']);
    }

    public function create(User $authUser): bool
    {
        return in_array($authUser->role, ['usuario', 'gestor', 'admin']);
    }

    public function update(User $authUser, Conta $conta): bool
    {
        return $authUser->id === $conta->user_id || 
               in_array($authUser->role, ['gestor', 'admin']);
    }

    public function delete(User $authUser, Conta $conta): bool
    {
        return $authUser->id === $conta->user_id || 
               in_array($authUser->role, ['gestor', 'admin']);
    }
}
