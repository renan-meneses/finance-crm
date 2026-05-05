<?php

namespace App\Providers;

use App\Models\Conta;
use App\Models\ContaBancaria;
use App\Models\User;
use App\Policies\ContaBancariaPolicy;
use App\Policies\ContaPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Conta::class => ContaPolicy::class,
        ContaBancaria::class => ContaBancariaPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
