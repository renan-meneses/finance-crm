import { gql } from '@apollo/client/core'

export const GET_CONTAS_BANCARIAS = gql`
  query GetContasBancarias {
    contasBancarias {
      id
      banco
      agencia
      conta
      tipo
      saldo
      created_at
      updated_at
    }
  }
`

export const CREATE_CONTA_BANCARIA = gql`
  mutation CreateContaBancaria($input: CreateContaBancariaInput!) {
    createContaBancaria(input: $input) {
      id
      banco
      agencia
      conta
      tipo
      saldo
    }
  }
`

export const UPDATE_CONTA_BANCARIA = gql`
  mutation UpdateContaBancaria($id: ID!, $input: UpdateContaBancariaInput!) {
    updateContaBancaria(id: $id, input: $input) {
      id
      banco
      agencia
      conta
      tipo
      saldo
    }
  }
`

export const DELETE_CONTA_BANCARIA = gql`
  mutation DeleteContaBancaria($id: ID!) {
    deleteContaBancaria(id: $id) {
      id
    }
  }
`
