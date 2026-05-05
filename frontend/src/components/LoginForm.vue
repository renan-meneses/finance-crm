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
    
    <SocialLogin />
    
    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useMutation } from '@vue/apollo-composable'
import { LOGIN } from '@/graphql/auth'
import { useAuthStore } from '@/stores/auth'
import type { LoginInput } from '@/types/user'
import SocialLogin from '@/components/SocialLogin.vue'

const email = ref('')
const password = ref('')
const error = ref('')
const router = useRouter()
const route = useRoute()
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

onMounted(() => {
  if (route.query.token && route.query.user) {
    try {
      const userData = JSON.parse(atob(route.query.user as string))
      authStore.setAuth({
        token: route.query.token as string,
        user: userData
      })
      router.push('/dashboard')
    } catch (e) {
      error.value = 'Erro ao processar login social'
    }
  }
})
</script>

<style scoped>
.error { color: red; }
</style>
