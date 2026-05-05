import { defineStore } from 'pinia'
import { ref } from 'vue'
import type { User, AuthPayload } from '@/types/user'

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null)
  const token = ref<string | null>(localStorage.getItem('token'))

  const setAuth = (payload: AuthPayload) => {
    user.value = payload.user
    token.value = payload.token
    localStorage.setItem('token', payload.token)
  }

  const logout = () => {
    user.value = null
    token.value = null
    localStorage.removeItem('token')
  }

  const isAuthenticated = () => !!token.value

  return { user, token, setAuth, logout, isAuthenticated }
})
