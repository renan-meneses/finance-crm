export interface ContaBancaria {
  id: string
  user_id: string
  banco: string
  agencia: string
  conta: string
  tipo: 'corrente' | 'poupanca' | 'salario'
  saldo: number
  created_at: string
  updated_at: string
}

export interface ContaBancariaInput {
  user_id?: string
  banco: string
  agencia: string
  conta: string
  tipo: 'corrente' | 'poupanca' | 'salario'
  saldo?: number
}
