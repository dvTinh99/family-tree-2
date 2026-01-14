import { createRouter, createWebHistory } from 'vue-router'

import Home from '@/pages/Home.vue'
import Login from '@/pages/Login.vue'
import Sample from '@/pages/Sample.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/sample',
    name: 'sample',
    component: Sample,
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
