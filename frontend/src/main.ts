import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { DefaultApolloClient, provide } from '@vue/apollo-composable'

import App from './App.vue'
import router from './router'
import { apolloClient } from './apollo-client'
import { useAuthStore } from './stores/auth'
import { ME } from './graphql/auth'
import { useQuery } from '@vue/apollo-composable'

const app = createApp(App)

app.use(createPinia())
app.use(router)

const authStore = useAuthStore()

if (authStore.isAuthenticated()) {
  const { onResult } = useQuery(ME)
  onResult((result) => {
    if (result.data?.me) {
      authStore.setAuth({ token: authStore.token!, user: result.data.me })
    }
  })
}

app.provide(DefaultApolloClient, apolloClient)

app.mount('#app')
