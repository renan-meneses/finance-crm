import { gql } from '@apollo/client/core'

export const GET_CONTAS = gql`
  query GetContas {
    contas {
      id
      nome
      saldo
      tipo
      descricao
      created_at
      updated_at
    }
  }
`

export const CREATE_CONTA = gql`
  mutation CreateConta($input: CreateContaInput!) {
    createConta(input: $input) {
      id
      nome
      saldo
      tipo
      descricao
    }
  }
`

export const UPDATE_CONTA = gql`
  mutation UpdateConta($id: ID!, $input: UpdateContaInput!) {
    updateConta(id: $id, input: $input) {
      id
      nome
      saldo
      tipo
      descricao
    }
  }
`

export const DELETE_CONTA = gql`
  mutation DeleteConta($id: ID!) {
    deleteConta(id: $id) {
      id
    }
  }
`
