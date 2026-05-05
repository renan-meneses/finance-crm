<?php

namespace App\GraphQL\Mutations;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreateTransaction
{
    public function resolve($root, array $args)
    {
        $user = Auth::guard('sanctum')->user();
        
        $input = $args['input'];
        $input['user_id'] = $user->id;
        
        // Upload do comprovante se existir
        if (isset($input['comprovante'])) {
            $path = $input['comprovante']->store('comprovantes', 'public');
            $input['comprovante_path'] = $path;
            
            // Aqui você pode integrar OCR (Tesseract ou API externa)
            // Por enquanto, salvamos o texto vazio
            $input['ocr_text'] = null;
            
            unset($input['comprovante']);
        }
        
        return Transaction::create($input);
    }
}
