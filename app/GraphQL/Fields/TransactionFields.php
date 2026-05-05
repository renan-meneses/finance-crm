<?php

namespace App\GraphQL\Fields;

use App\Models\Transaction;

class TransactionFields
{
    public function categoriaLabel($root)
    {
        return Transaction::getCategoriaLabel($root->categoria);
    }

    public function comprovanteUrl($root)
    {
        if ($root->comprovante_path) {
            return url('storage/' . $root->comprovante_path);
        }
        return null;
    }
}
