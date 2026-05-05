<template>
  <div class="graficos">
    <div class="grafico">
      <h3>Despesas por Categoria</h3>
      <Pie :data="dadosDespesas" :options="opcoesDespesas" />
    </div>
    <div class="grafico">
      <h3>Receitas por Categoria</h3>
      <Pie :data="dadosReceitas" :options="opcoesReceitas" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { Pie } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale
} from 'chart.js'
import type { CategoriaValor } from '@/types/transaction'

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale)

const props = defineProps<{
  despesas: CategoriaValor[]
  receitas: CategoriaValor[]
}>()

const dadosDespesas = computed(() => ({
  labels: props.despesas.map(d => d.label),
  datasets: [{
    data: props.despesas.map(d => d.valor),
    backgroundColor: props.despesas.map(d => d.cor),
    borderWidth: 1
  }]
}))

const dadosReceitas = computed(() => ({
  labels: props.receitas.map(r => r.label),
  datasets: [{
    data: props.receitas.map(r => r.valor),
    backgroundColor: props.receitas.map(r => r.cor),
    borderWidth: 1
  }]
}))

const opcoesDespesas = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: { position: 'right' as const }
  }
}

const opcoesReceitas = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: { position: 'right' as const }
  }
}
</script>

<style scoped>
.graficos {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2rem;
  margin-bottom: 2rem;
}

.grafico {
  background: var(--card-bg);
  padding: 1.5rem;
  border-radius: 8px;
  height: 400px;
}

.grafico h3 {
  margin-top: 0;
  text-align: center;
}

@media (max-width: 768px) {
  .graficos {
    grid-template-columns: 1fr;
  }
}
</style>
