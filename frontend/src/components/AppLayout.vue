<template>
  <div :class="{ dark: isDark }">
    <header class="app-header">
      <nav>
        <router-link to="/dashboard">Dashboard</router-link>
        <router-link to="/contas">Contas</router-link>
        <router-link to="/contas-bancarias">Contas Bancárias</router-link>
        <router-link to="/transacoes">Transações</router-link>
        <router-link to="/usuarios" v-if="authStore.user?.role !== 'usuario'">Usuários</router-link>
        <button @click="toggleTheme" class="theme-btn">
          {{ isDark ? '☀️ Light' : '🌙 Dark' }}
        </button>
        <button @click="handleLogout" class="logout-btn">Sair</button>
      </nav>
    </header>
    <main class="app-main">
      <router-view />
    </main>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useTheme } from '@/composables/useTheme'
import { useMutation } from '@vue/apollo-composable'
import { LOGOUT } from '@/graphql/auth'

const router = useRouter()
const authStore = useAuthStore()
const { toggleTheme, currentTheme } = useTheme()

const isDark = computed(() => currentTheme === 'dark')

const { mutate: logoutMutation } = useMutation(LOGOUT)

const handleLogout = async () => {
  await logoutMutation()
  authStore.logout()
  router.push('/login')
}
</script>

<style scoped>
.app-header {
  background: var(--card-bg);
  padding: 1rem;
  margin-bottom: 2rem;
  border-radius: 8px;
}

.app-header nav {
  display: flex;
  gap: 1rem;
  align-items: center;
  flex-wrap: wrap;
}

.app-header a {
  color: var(--text-color);
  text-decoration: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
}

.app-header a:hover {
  background: rgba(100, 108, 255, 0.1);
}

.theme-btn, .logout-btn {
  background: transparent;
  border: 1px solid var(--text-color);
  color: var(--text-color);
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  margin-left: auto;
}

.logout-btn {
  margin-left: 0;
  background: #ff4444;
  color: white;
  border-color: #ff4444;
}

.app-main {
  max-width: 1200px;
  margin: 0 auto;
}
</style>
