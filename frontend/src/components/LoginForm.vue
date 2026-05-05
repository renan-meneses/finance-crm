<template>
  <div class="login-form">
    <h2>Login</h2>
    <form @submit.prevent="handleLogin">
      <div>
        <label>Email:</label>
        <input v-model="email" type="email" required />
      </div>
      <div>
        <label>Senha:</label>
        <input v-model="password" type="password" required />
      </div>
      <button type="submit">Entrar</button>
    </form>
    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useMutation } from '@vue/apollo-composable'
import { LOGIN } from '@/graphql/auth'
import { useAuthStore } from '@/stores/auth'
import type { LoginInput } from '@/types/user'

const email = ref('')
const password = ref('')
const error = ref('')
const router = useRouter()
const authStore = useAuthStore()

const { mutate: loginMutation } = useMutation(LOGIN)

const handleLogin = async () => {
  try {
    const input: LoginInput = {
      email: email.value,
      password: password.value
    }
    const result = await loginMutation({ email: input.email, password: input.password })
    if (result?.data?.login) {
      authStore.setAuth(result.data.login)
      router.push('/dashboard')
    }
  } catch (err: any) {
    error.value = err.message || 'Erro ao fazer login'
  }
}
</script>

<style scoped>
.error { color: red; }
</style>
