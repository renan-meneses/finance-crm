export interface User {
  id: string
  name: string
  email: string
  role: 'usuario' | 'gestor' | 'admin'
  created_at: string
  updated_at: string
}

export interface AuthPayload {
  token: string
  user: User
}

export interface LoginInput {
  email: string
  password: string
}
