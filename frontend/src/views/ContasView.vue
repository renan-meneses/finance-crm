<template>
  <div class="contas-view">
    <h1>Contas</h1>
    <form @submit.prevent="handleCreate">
      <input v-model="novaConta.nome" placeholder="Nome" required />
      <select v-model="novaConta.tipo" required>
        <option value="corrente">Corrente</option>
        <option value="poupanca">Poupança</option>
        <option value="investimento">Investimento</option>
      </select>
      <input v-model.number="novaConta.saldo" type="number" step="0.01" placeholder="Saldo" />
      <button type="submit">Adicionar</button>
    </form>

    <ul>
      <li v-for="conta in contas" :key="conta.id">
        {{ conta.nome }} - {{ conta.tipo }} - R$ {{ conta.saldo }}
        <button @click="handleDelete(conta.id)">Excluir</button>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useQuery, useMutation } from '@vue/apollo-composable'
import { GET_CONTAS, CREATE_CONTA, DELETE_CONTA } from '@/graphql/conta'
import type { Conta, ContaInput } from '@/types/conta'

const contas = ref<Conta[]>([])
const novaConta = ref<ContaInput>({ nome: '', tipo: 'corrente', saldo: 0 })

const { onResult } = useQuery(GET_CONTAS)
onResult((result) => {
  if (result.data?.contas) {
    contas.value = result.data.contas
  }
})

const { mutate: createConta } = useMutation(CREATE_CONTA)
const { mutate: deleteConta } = useMutation(DELETE_CONTA)

const handleCreate = async () => {
  await createConta({ input: novaConta.value })
  novaConta.value = { nome: '', tipo: 'corrente', saldo: 0 }
}

const handleDelete = async (id: string) => {
  await deleteConta({ id })
}
</script>
