<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'conta_id',
        'tipo',
        'categoria',
        'valor',
        'descricao',
        'data',
        'comprovante_path',
        'ocr_text',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function conta(): BelongsTo
    {
        return $this->belongsTo(Conta::class);
    }

    public static function categoriasDespesas(): array
    {
        return [
            'habitacao' => 'Habitação',
            'alimentacao' => 'Alimentação',
            'transporte' => 'Transporte',
            'saude' => 'Saúde',
            'educacao' => 'Educação',
            'lazer' => 'Lazer',
            'contas_consumo' => 'Contas de Consumo',
            'assinaturas_servicos' => 'Assinaturas e Serviços',
            'compras_vestuario' => 'Compras e Vestuário',
            'cuidados_pessoais' => 'Cuidados Pessoais',
            'pets' => 'Pets',
            'impostos_taxas' => 'Impostos e Taxas',
            'manutencao_residencial' => 'Manutenção Residencial',
            'investimentos' => 'Investimentos',
            'reserva_emergencia' => 'Reserva de Emergência',
            'diversos_outros' => 'Diversos / Outros',
        ];
    }

    public static function categoriasReceitas(): array
    {
        return [
            'salario' => 'Salário',
            'pro_labore' => 'Pró-labore',
            'renda_extra_freelance' => 'Renda Extra / Freelance',
            'investimentos_rendimentos' => 'Investimentos (Dividendos/Juros)',
            'venda_ativos' => 'Venda de Ativos (Bens/Usados)',
            'reembolsos' => 'Reembolsos',
            'presentes_doacoes' => 'Presentes / Doações',
            'bonificacoes_comissoes' => 'Bonificações / Comissões',
            'restituicao_imposto' => 'Restituição de Imposto',
            'alugueis_recebidos' => 'Aluguéis Recebidos',
            'outras_receitas' => 'Outras Receitas',
        ];
    }

    public static function getCategoriaLabel(string $categoria): string
    {
        $todas = array_merge(self::categoriasDespesas(), self::categoriasReceitas());
        return $todas[$categoria] ?? $categoria;
    }
}
