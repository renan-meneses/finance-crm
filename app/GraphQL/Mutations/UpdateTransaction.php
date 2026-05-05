<?php

namespace App\GraphQL\Mutations;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class UpdateTransaction
{
    public function resolve($root, array $args)
    {
        $user = Auth::guard('sanctum')->user();
        
        $transaction = Transaction::findOrFail($args['id']);
        
        if ($transaction->user_id !== $user->id && $user->role !== 'admin') {
            throw new \Exception('Não autorizado');
        }
        
        $input = $args['input'];
        $transaction->update($input);
        
        return $transaction;
    }
}
