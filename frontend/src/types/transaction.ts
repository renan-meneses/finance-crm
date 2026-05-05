export interface Transaction {
  id: string
  tipo: 'receita' | 'despesa'
  categoria: string
  categoria_label: string
  valor: number
  descricao?: string
  data: string
  comprovante_url?: string
  conta?: {
    nome: string
  }
}

export interface ResumoFinanceiro {
  total_receitas: number
  total_despesas: number
  saldo: number
  despesas_por_categoria: CategoriaValor[]
  receitas_por_categoria: CategoriaValor[]
}

export interface CategoriaValor {
  categoria: string
  label: string
  valor: number
  cor: string
}

export interface TransactionInput {
  conta_id: string
  tipo: 'receita' | 'despesa'
  categoria: string
  valor: number
  descricao?: string
  data: string
  comprovante?: File
}
