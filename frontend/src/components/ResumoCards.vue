<template>
  <div class="resumo-cards">
    <div class="card receitas">
      <h3>Total Recebido</h3>
      <p class="valor">R$ {{ formatarValor(resumo?.total_receitas || 0) }}</p>
    </div>
    <div class="card despesas">
      <h3>Total Gasto</h3>
      <p class="valor">R$ {{ formatarValor(resumo?.total_despesas || 0) }}</p>
    </div>
    <div class="card saldo">
      <h3>Saldo</h3>
      <p class="valor" :class="{ negativo: (resumo?.saldo || 0) < 0 }">
        R$ {{ formatarValor(resumo?.saldo || 0) }}
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { ResumoFinanceiro } from '@/types/transaction'

defineProps<{
  resumo: ResumoFinanceiro | null
}>()

const formatarValor = (valor: number) => {
  return valor.toFixed(2).replace('.', ',')
}
</script>

<style scoped>
.resumo-cards {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
  margin-bottom: 2rem;
}

.card {
  background: var(--card-bg);
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card h3 {
  margin: 0 0 0.5rem 0;
  font-size: 0.9rem;
  opacity: 0.8;
}

.card .valor {
  font-size: 1.8rem;
  font-weight: bold;
  margin: 0;
}

.receitas { border-left: 4px solid #4CAF50; }
.despesas { border-left: 4px solid #F44336; }
.saldo { border-left: 4px solid #2196F3; }
.negativo { color: #F44336; }

@media (max-width: 768px) {
  .resumo-cards {
    grid-template-columns: 1fr;
  }
}
</style>
