<?php

namespace App\GraphQL\Queries;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ResumoFinanceiro
{
    public function resolve($root, array $args)
    {
        $user = Auth::guard('sanctum')->user();
        
        $transactions = Transaction::where('user_id', $user->id)->get();
        
        $totalReceitas = $transactions->where('tipo', 'receita')->sum('valor');
        $totalDespesas = $transactions->where('tipo', 'despesa')->sum('valor');
        
        $coresDespesas = [
            'habitacao' => '#FF6384',
            'alimentacao' => '#36A2EB',
            'transporte' => '#FFCE56',
            'saude' => '#4BC0C0',
            'educacao' => '#9966FF',
            'lazer' => '#FF9F40',
            'contas_consumo' => '#FF6384',
            'assinaturas_servicos' => '#C9CBCF',
            'compras_vestuario' => '#7BC67B',
            'cuidados_pessoais' => '#FFB6C1',
            'pets' => '#DEB887',
            'impostos_taxas' => '#DC143C',
            'manutencao_residencial' => '#8B4513',
            'investimentos' => '#2E8B57',
            'reserva_emergencia' => '#4682B4',
            'diversos_outros' => '#708090',
        ];
        
        $coresReceitas = [
            'salario' => '#4CAF50',
            'pro_labore' => '#2196F3',
            'renda_extra_freelance' => '#FF9800',
            'investimentos_rendimentos' => '#9C27B0',
            'venda_ativos' => '#00BCD4',
            'reembolsos' => '#8BC34A',
            'presentes_doacoes' => '#E91E63',
            'bonificacoes_comissoes' => '#FF5722',
            'restituicao_imposto' => '#607D8B',
            'alugueis_recebidos' => '#795548',
            'outras_receitas' => '#9E9E9E',
        ];
        
        $despesasPorCategoria = $transactions->where('tipo', 'despesa')
            ->groupBy('categoria')
            ->map(function ($items, $categoria) use ($coresDespesas) {
                return [
                    'categoria' => $categoria,
                    'label' => \App\Models\Transaction::categoriasDespesas()[$categoria] ?? $categoria,
                    'valor' => $items->sum('valor'),
                    'cor' => $coresDespesas[$categoria] ?? '#000000',
                ];
            })->values()->toArray();
        
        $receitasPorCategoria = $transactions->where('tipo', 'receita')
            ->groupBy('categoria')
            ->map(function ($items, $categoria) use ($coresReceitas) {
                return [
                    'categoria' => $categoria,
                    'label' => \App\Models\Transaction::categoriasReceitas()[$categoria] ?? $categoria,
                    'valor' => $items->sum('valor'),
                    'cor' => $coresReceitas[$categoria] ?? '#000000',
                ];
            })->values()->toArray();
        
        return [
            'total_receitas' => $totalReceitas,
            'total_despesas' => $totalDespesas,
            'saldo' => $totalReceitas - $totalDespesas,
            'despesas_por_categoria' => $despesasPorCategoria,
            'receitas_por_categoria' => $receitasPorCategoria,
        ];
    }
}
