<?php

namespace App\Policies;

use App\Models\ContaBancaria;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContaBancariaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $authUser): bool
    {
        return in_array($authUser->role, ['usuario', 'gestor', 'admin']);
    }

    public function view(User $authUser, ContaBancaria $contaBancaria): bool
    {
        return $authUser->id === $contaBancaria->user_id || 
               in_array($authUser->role, ['gestor', 'admin']);
    }

    public function create(User $authUser): bool
    {
        return in_array($authUser->role, ['usuario', 'gestor', 'admin']);
    }

    public function update(User $authUser, ContaBancaria $contaBancaria): bool
    {
        return $authUser->id === $contaBancaria->user_id || 
               in_array($authUser->role, ['gestor', 'admin']);
    }

    public function delete(User $authUser, ContaBancaria $contaBancaria): bool
    {
        return $authUser->id === $contaBancaria->user_id || 
               in_array($authUser->role, ['gestor', 'admin']);
    }
}
