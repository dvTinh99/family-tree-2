import { createRouter, createWebHistory } from 'vue-router'

import Home from '@/pages/Home.vue'
import Login from '@/pages/Login.vue'
import Sample from '@/pages/Sample.vue'
import Demo from '@/pages/Demo.vue'

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

router.beforeEach((to, from, next) => {
  const hasAccess = !!to.query.access_token
  const hasRefresh = !!to.query.refresh_token

  if (hasAccess && hasRefresh) {
    // optionally persist tokens here (localStorage/session) before redirecting
    next({ name: 'home' })
    return
  }

  next()
})

export default router
