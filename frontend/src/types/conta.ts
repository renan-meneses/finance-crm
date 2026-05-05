export interface Conta {
  id: string
  user_id: string
  nome: string
  saldo: number
  tipo: 'corrente' | 'poupanca' | 'investimento'
  descricao?: string
  created_at: string
  updated_at: string
}

export interface ContaInput {
  user_id?: string
  nome: string
  saldo?: number
  tipo: 'corrente' | 'poupanca' | 'investimento'
  descricao?: string
}
