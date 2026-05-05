import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: () => import('@/components/LoginForm.vue')
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('@/components/AppLayout.vue'),
      meta: { requiresAuth: true },
      children: [
        {
          path: '',
          name: 'dashboard-home',
          component: () => import('@/views/Dashboard.vue'),
        },
        {
          path: '/contas',
          name: 'contas',
          component: () => import('@/views/ContasView.vue'),
        },
        {
          path: '/contas-bancarias',
          name: 'contas-bancarias',
          component: () => import('@/views/ContasBancariasView.vue'),
        },
        {
          path: '/usuarios',
          name: 'usuarios',
          component: () => import('@/views/UsuariosView.vue'),
          meta: { requiresRole: ['gestor', 'admin'] }
        }
      ]
    },
    {
      path: '/',
      redirect: '/dashboard'
    }
  ]
})

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  
  if (to.meta.requiresAuth && !authStore.isAuthenticated()) {
    next('/login')
  } else if (to.meta.requiresRole && to.meta.requiresRole.length > 0) {
    if (!to.meta.requiresRole.includes(authStore.user?.role || '')) {
      next('/dashboard')
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router
