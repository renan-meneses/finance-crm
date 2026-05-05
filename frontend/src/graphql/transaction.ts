import { gql } from '@apollo/client/core'

export const GET_RESUMO = gql`
  query GetResumo {
    resumoFinanceiro {
      total_receitas
      total_despesas
      saldo
      despesas_por_categoria {
        categoria
        label
        valor
        cor
      }
      receitas_por_categoria {
        categoria
        label
        valor
        cor
      }
    }
  }
`

export const GET_TRANSACTIONS = gql`
  query GetTransactions {
    transactions {
      id
      tipo
      categoria
      categoria_label
      valor
      descricao
      data
      comprovante_url
      conta {
        nome
      }
    }
  }
`

export const CREATE_TRANSACTION = gql`
  mutation CreateTransaction($input: CreateTransactionInput!) {
    createTransaction(input: $input) {
      id
      tipo
      categoria
      valor
      descricao
    }
  }
`

export const DELETE_TRANSACTION = gql`
  mutation DeleteTransaction($id: ID!) {
    deleteTransaction(id: $id) {
      id
    }
  }
`
