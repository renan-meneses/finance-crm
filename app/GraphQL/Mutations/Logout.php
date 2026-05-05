<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;

class Logout
{
    public function logout($root, array $args): bool
    {
        $user = Auth::guard('sanctum')->user();
        
        if ($user) {
            $user->currentAccessToken()->delete();
            return true;
        }

        return false;
    }
}
