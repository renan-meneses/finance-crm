import { gql } from '@apollo/client/core'

export const LOGIN = gql`
  mutation Login($email: String!, $password: String!) {
    login(email: $email, password: $password) {
      token
      user {
        id
        name
        email
        role
      }
    }
  }
`

export const LOGOUT = gql`
  mutation Logout {
    logout
  }
`

export const ME = gql`
  query Me {
    me {
      id
      name
      email
      role
    }
  }
`
