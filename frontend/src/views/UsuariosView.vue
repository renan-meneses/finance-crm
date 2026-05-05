<template>
  <div class="usuarios-view">
    <h1>Gerenciar Usuários</h1>
    
    <form @submit.prevent="handleCreate">
      <input v-model="novoUsuario.name" placeholder="Nome" required />
      <input v-model="novoUsuario.email" type="email" placeholder="Email" required />
      <input v-model="novoUsuario.password" type="password" placeholder="Senha" required />
      <select v-model="novoUsuario.role" required>
        <option value="usuario">Usuário</option>
        <option value="gestor">Gestor</option>
        <option value="admin">Admin</option>
      </select>
      <button type="submit">Criar Usuário</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>Email</th>
          <th>Role</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.role }}</td>
          <td>
            <button @click="handleDelete(user.id)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useQuery, useMutation } from '@vue/apollo-composable'
import { GET_USERS, CREATE_USER, DELETE_USER } from '@/graphql/user'
import type { User } from '@/types/user'

const users = ref<User[]>([])
const novoUsuario = ref({
  name: '',
  email: '',
  password: '',
  role: 'usuario'
})

const { onResult } = useQuery(GET_USERS)
onResult((result) => {
  if (result.data?.users) {
    users.value = result.data.users
  }
})

const { mutate: createUser } = useMutation(CREATE_USER)
const { mutate: deleteUser } = useMutation(DELETE_USER)

const handleCreate = async () => {
  await createUser({ input: novoUsuario.value })
  novoUsuario.value = { name: '', email: '', password: '', role: 'usuario' }
}

const handleDelete = async (id: string) => {
  await deleteUser({ id })
}
</script>

<style scoped>
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
th { background-color: #f2f2f2; }
</style>
