<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    protected $fillable = [
        'user_id',
        'nome',
        'saldo',
        'tipo',
        'descricao',
    ];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
