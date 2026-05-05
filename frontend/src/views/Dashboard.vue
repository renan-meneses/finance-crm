<template>
  <div class="dashboard">
    <h1>Dashboard</h1>
    <p>Bem-vindo, {{ authStore.user?.name }}</p>
    <p>Role: {{ authStore.user?.role }}</p>
    
    <nav>
      <router-link to="/contas">Contas</router-link>
      <router-link to="/contas-bancarias">Contas Bancárias</router-link>
      <router-link to="/usuarios" v-if="authStore.user?.role !== 'usuario'">Usuários</router-link>
      <button @click="handleLogout">Sair</button>
    </nav>
  </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useMutation } from '@vue/apollo-composable'
import { LOGOUT } from '@/graphql/auth'

const router = useRouter()
const authStore = useAuthStore()
const { mutate: logoutMutation } = useMutation(LOGOUT)

const handleLogout = async () => {
  await logoutMutation()
  authStore.logout()
  router.push('/login')
}
</script>
