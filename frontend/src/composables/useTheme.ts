import { onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'

export const useTheme = () => {
  const authStore = useAuthStore()

  onMounted(() => {
    const savedTheme = localStorage.getItem('theme') as 'light' | 'dark' | null
    if (savedTheme) {
      document.documentElement.classList.toggle('dark', savedTheme === 'dark')
    } else if (authStore.user?.theme) {
      document.documentElement.classList.toggle('dark', authStore.user.theme === 'dark')
    }
  })

  return {
    toggleTheme: authStore.toggleTheme,
    currentTheme: authStore.user?.theme || 'light'
  }
}
