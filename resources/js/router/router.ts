import { createRouter, createWebHistory } from 'vue-router'

import Home from '@/pages/Home.vue'
import Login from '@/pages/Login.vue'
import Sample from '@/pages/Sample.vue'
import Demo from '@/pages/Demo.vue'
import HandleLogin from '@/pages/handleLogin.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
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

export default router
