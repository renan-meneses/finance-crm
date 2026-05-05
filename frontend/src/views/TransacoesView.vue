<template>
  <div class="transacoes-view">
    <h1>Transações</h1>
    
    <ResumoCards :resumo="resumo" />
    
    <GraficosPie 
      :despesas="resumo?.despesas_por_categoria || []" 
      :receitas="resumo?.receitas_por_categoria || []" 
    />
    
    <form @submit.prevent="handleSubmit" class="transaction-form">
      <div class="form-row">
        <select v-model="novaTransacao.tipo" required>
          <option value="receita">Receita</option>
          <option value="despesa">Despesa</option>
        </select>
        
        <select v-model="novaTransacao.conta_id" required>
          <option value="">Selecione a Conta</option>
          <option v-for="conta in contas" :key="conta.id" :value="conta.id">
            {{ conta.nome }}
          </option>
        </select>
        
        <select v-model="novaTransacao.categoria" required>
          <option value="">Categoria</option>
          <optgroup label="Despesas" v-if="novaTransacao.tipo === 'despesa'">
            <option v-for="(label, key) in categoriasDespesas" :key="key" :value="key">
              {{ label }}
            </option>
          </optgroup>
          <optgroup label="Receitas" v-else>
            <option v-for="(label, key) in categoriasReceitas" :key="key" :value="key">
              {{ label }}
            </option>
          </optgroup>
        </select>
        
        <input v-model.number="novaTransacao.valor" type="number" step="0.01" placeholder="Valor" required />
        <input v-model="novaTransacao.data" type="date" required />
      </div>
      
      <div class="form-row">
        <input v-model="novaTransacao.descricao" placeholder="Descrição" />
        <div class="file-upload">
          <label>Comprovante PIX:</label>
          <input type="file" @change="handleFileUpload" accept="image/*,.pdf" />
          <small v-if="ocrText">Texto detectado: {{ ocrText.substring(0, 100) }}...</small>
        </div>
        <button type="submit">Adicionar</button>
      </div>
    </form>
    
    <table>
      <thead>
        <tr>
          <th>Data</th>
          <th>Tipo</th>
          <th>Categoria</th>
          <th>Conta</th>
          <th>Valor</th>
          <th>Descrição</th>
          <th>Comprovante</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="trans in transacoes" :key="trans.id">
          <td>{{ formatarData(trans.data) }}</td>
          <td :class="trans.tipo">{{ trans.tipo === 'receita' ? 'Receita' : 'Despesa' }}</td>
          <td>{{ trans.categoria_label }}</td>
          <td>{{ trans.conta?.nome }}</td>
          <td>R$ {{ formatarValor(trans.valor) }}</td>
          <td>{{ trans.descricao }}</td>
          <td>
            <a v-if="trans.comprovante_url" :href="trans.comprovante_url" target="_blank">Ver</a>
            <span v-else>-</span>
          </td>
          <td>
            <button @click="handleDelete(trans.id)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useQuery, useMutation } from '@vue/apollo-composable'
import { GET_RESUMO, GET_TRANSACTIONS, CREATE_TRANSACTION, DELETE_TRANSACTION } from '@/graphql/transaction'
import { GET_CONTAS } from '@/graphql/conta'
import ResumoCards from '@/components/ResumoCards.vue'
import GraficosPie from '@/components/GraficosPie.vue'
import type { Transaction, TransactionInput, ResumoFinanceiro } from '@/types/transaction'
import type { Conta } from '@/types/conta'
import { Transaction as TransactionModel } from '@/models/transaction'

const transacoes = ref<Transaction[]>([])
const contas = ref<Conta[]>([])
const resumo = ref<ResumoFinanceiro | null>(null)
const ocrText = ref('')
const selectedFile = ref<File | null>(null)

const novaTransacao = ref<TransactionInput>({
  conta_id: '',
  tipo: 'despesa',
  categoria: '',
  valor: 0,
  descricao: '',
  data: new Date().toISOString().split('T')[0]
})

const categoriasDespesas = TransactionModel.categoriasDespesas()
const categoriasReceitas = TransactionModel.categoriasReceitas()

const { onResult: onResumo } = useQuery(GET_RESUMO)
onResumo((result) => {
  if (result.data?.resumoFinanceiro) {
    resumo.value = result.data.resumoFinanceiro
  }
})

const { onResult: onTransacoes } = useQuery(GET_TRANSACTIONS)
onTransacoes((result) => {
  if (result.data?.transactions) {
    transacoes.value = result.data.transactions
  }
})

const { onResult: onContas } = useQuery(GET_CONTAS)
onContas((result) => {
  if (result.data?.contas) {
    contas.value = result.data.contas
  }
})

const { mutate: createTransaction } = useMutation(CREATE_TRANSACTION)
const { mutate: deleteTransaction } = useMutation(DELETE_TRANSACTION)

const handleFileUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files?.length) {
    selectedFile.value = target.files[0]
    // Simular OCR (em produção, use Tesseract.js ou API)
    ocrText.value = 'Texto extraído do comprovante (OCR simulado)'
  }
}

const handleSubmit = async () => {
  const input = { ...novaTransacao.value }
  if (selectedFile.value) {
    // @ts-ignore - Upload de arquivo
    input.comprovante = selectedFile.value
  }
  await createTransaction({ input })
  novaTransacao.value = {
    conta_id: '',
    tipo: 'despesa',
    categoria: '',
    valor: 0,
    descricao: '',
    data: new Date().toISOString().split('T')[0]
  }
  selectedFile.value = null
  ocrText.value = ''
}

const handleDelete = async (id: string) => {
  await deleteTransaction({ id })
}

const formatarValor = (valor: number) => valor.toFixed(2).replace('.', ',')
const formatarData = (data: string) => new Date(data).toLocaleDateString('pt-BR')
</script>

<script lang="ts">
export default {
  computed: {
    categoriasDespesas() {
      return {
        'habitacao': 'Habitação',
        'alimentacao': 'Alimentação',
        'transporte': 'Transporte',
        'saude': 'Saúde',
        'educacao': 'Educação',
        'lazer': 'Lazer',
        'contas_consumo': 'Contas de Consumo',
        'assinaturas_servicos': 'Assinaturas e Serviços',
        'compras_vestuario': 'Compras e Vestuário',
        'cuidados_pessoais': 'Cuidados Pessoais',
        'pets': 'Pets',
        'impostos_taxas': 'Impostos e Taxas',
        'manutencao_residencial': 'Manutenção Residencial',
        'investimentos': 'Investimentos',
        'reserva_emergencia': 'Reserva de Emergência',
        'diversos_outros': 'Diversos / Outros',
      }
    },
    categoriasReceitas() {
      return {
        'salario': 'Salário',
        'pro_labore': 'Pró-labore',
        'renda_extra_freelance': 'Renda Extra / Freelance',
        'investimentos_rendimentos': 'Investimentos (Dividendos/Juros)',
        'venda_ativos': 'Venda de Ativos (Bens/Usados)',
        'reembolsos': 'Reembolsos',
        'presentes_doacoes': 'Presentes / Doações',
        'bonificacoes_comissoes': 'Bonificações / Comissões',
        'restituicao_imposto': 'Restituição de Imposto',
        'alugueis_recebidos': 'Aluguéis Recebidos',
        'outras_receitas': 'Outras Receitas',
      }
    }
  }
}
</script>

<style scoped>
.transaction-form {
  background: var(--card-bg);
  padding: 1.5rem;
  border-radius: 8px;
  margin-bottom: 2rem;
}

.form-row {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
  flex-wrap: wrap;
}

.form-row select, .form-row input {
  flex: 1;
  min-width: 150px;
}

.file-upload {
  flex: 1;
  min-width: 200px;
}

.file-upload small {
  display: block;
  margin-top: 0.5rem;
  opacity: 0.7;
}

.receita { color: #4CAF50; font-weight: bold; }
.despesa { color: #F44336; font-weight: bold; }

table {
  width: 100%;
  background: var(--card-bg);
}

@media (max-width: 768px) {
  .form-row {
    flex-direction: column;
  }
}
</style>
