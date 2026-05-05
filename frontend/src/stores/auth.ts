import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useMutation } from '@vue/apollo-composable'
import { UPDATE_USER } from '@/graphql/user'
import type { User, AuthPayload } from '@/types/user'

const applyTheme = (theme: 'light' | 'dark') => {
  document.documentElement.classList.toggle('dark', theme === 'dark')
  localStorage.setItem('theme', theme)
}

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null)
  const token = ref<string | null>(localStorage.getItem('token'))

  const setAuth = (payload: AuthPayload) => {
    user.value = payload.user
    token.value = payload.token
    localStorage.setItem('token', payload.token)
    applyTheme(payload.user.theme)
  }

  const logout = () => {
    user.value = null
    token.value = null
    localStorage.removeItem('token')
  }

  const isAuthenticated = () => !!token.value

  const toggleTheme = async () => {
    if (user.value) {
      const newTheme = user.value.theme === 'light' ? 'dark' : 'light'
      user.value.theme = newTheme
      applyTheme(newTheme)
      
      const { mutate: updateUser } = useMutation(UPDATE_USER)
      await updateUser({ id: user.value.id, input: { theme: newTheme } })
    }
  }

  return { user, token, setAuth, logout, isAuthenticated, toggleTheme }
})
