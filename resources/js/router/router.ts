import { createRouter, createWebHistory } from 'vue-router'

import Home from '@/pages/Home.vue'
import Login from '@/pages/Login.vue'
import Sample from '@/pages/Sample.vue'
import Demo from '@/pages/Demo.vue'
import HandleLogin from '@/pages/HandleLogin.vue'
import OpenCodeFamily from '@/pages/OpenCodeFamily.vue'
import { useAuthStore } from '@/store/auth'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/opencode',
    name: 'opencode',
    component: OpenCodeFamily,
  },
  {
    path: '/handle-auth',
    name: 'handle-auth',
    component: HandleLogin,
  },
  {
    path: '/home',
    name: 'home2',
    component: Home,
  },
  {
    path: '/sample',
    name: 'sample',
    component: Sample,
  },
  {
    path: '/demo',
    name: 'demo',
    component: Demo,
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

const unAuthRoutes = ['handle-auth', 'demo']

// Navigation guard to check authentication
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  const isAuthenticated = authStore.state.isLoggedIn

  // Allow access to login and handle-auth without authentication
  if (unAuthRoutes.includes(to.name as string)) {
    next()
  } else if (!isAuthenticated) {
    // Redirect to login if not authenticated
    authStore.logout()
  } else {
    // Proceed if authenticated
    next()
  }
})

export default router
