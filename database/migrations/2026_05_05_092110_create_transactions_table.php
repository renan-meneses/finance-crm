<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('conta_id')->constrained('contas')->onDelete('cascade');
            $table->enum('tipo', ['receita', 'despesa']);
            $table->enum('categoria', [
                // Despesas
                'habitacao',
                'alimentacao',
                'transporte',
                'saude',
                'educacao',
                'lazer',
                'contas_consumo',
                'assinaturas_servicos',
                'compras_vestuario',
                'cuidados_pessoais',
                'pets',
                'impostos_taxas',
                'manutencao_residencial',
                'investimentos',
                'reserva_emergencia',
                'diversos_outros',
                // Receitas
                'salario',
                'pro_labore',
                'renda_extra_freelance',
                'investimentos_rendimentos',
                'venda_ativos',
                'reembolsos',
                'presentes_doacoes',
                'bonificacoes_comissoes',
                'restituicao_imposto',
                'alugueis_recebidos',
                'outras_receitas'
            ]);
            $table->decimal('valor', 15, 2);
            $table->string('descricao')->nullable();
            $table->date('data');
            $table->string('comprovante_path')->nullable();
            $table->text('ocr_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
