<template>
  <div class="dashboard">
    <h1>Dashboard</h1>
    <p>Bem-vindo, {{ authStore.user?.name }}</p>
    <p>Role: {{ authStore.user?.role }}</p>
  </div>
</template>

<script setup lang="ts">
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
</script>
