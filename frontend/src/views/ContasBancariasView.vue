<template>
  <div class="contas-bancarias-view">
    <h1>Contas Bancárias</h1>
    <form @submit.prevent="handleCreate">
      <input v-model="novaConta.banco" placeholder="Banco" required />
      <input v-model="novaConta.agencia" placeholder="Agência" required />
      <input v-model="novaConta.conta" placeholder="Conta" required />
      <select v-model="novaConta.tipo" required>
        <option value="corrente">Corrente</option>
        <option value="poupanca">Poupança</option>
        <option value="salario">Salário</option>
      </select>
      <input v-model.number="novaConta.saldo" type="number" step="0.01" placeholder="Saldo" />
      <button type="submit">Adicionar</button>
    </form>

    <ul>
      <li v-for="conta in contasBancarias" :key="conta.id">
        {{ conta.banco }} - Ag: {{ conta.agencia }} - CC: {{ conta.conta }} - R$ {{ conta.saldo }}
        <button @click="handleDelete(conta.id)">Excluir</button>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useQuery, useMutation } from '@vue/apollo-composable'
import { GET_CONTAS_BANCARIAS, CREATE_CONTA_BANCARIA, DELETE_CONTA_BANCARIA } from '@/graphql/conta-bancaria'
import type { ContaBancaria, ContaBancariaInput } from '@/types/conta-bancaria'

const contasBancarias = ref<ContaBancaria[]>([])
const novaConta = ref<ContaBancariaInput>({
  banco: '',
  agencia: '',
  conta: '',
  tipo: 'corrente',
  saldo: 0
})

const { onResult } = useQuery(GET_CONTAS_BANCARIAS)
onResult((result) => {
  if (result.data?.contasBancarias) {
    contasBancarias.value = result.data.contasBancarias
  }
})

const { mutate: createContaBancaria } = useMutation(CREATE_CONTA_BANCARIA)
const { mutate: deleteContaBancaria } = useMutation(DELETE_CONTA_BANCARIA)

const handleCreate = async () => {
  await createContaBancaria({ input: novaConta.value })
  novaConta.value = { banco: '', agencia: '', conta: '', tipo: 'corrente', saldo: 0 }
}

const handleDelete = async (id: string) => {
  await deleteContaBancaria({ id })
}
</script>
