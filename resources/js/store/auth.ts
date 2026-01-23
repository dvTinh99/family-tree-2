import router from '@/router/router'
import { defineStore } from 'pinia'
import { reactive } from 'vue'

export interface IUser {
  email: string
  role: number
  updated_at: string
  created_at: string
  id: number
}
export const useAuthStore = defineStore(
  'auth',
  () => {
    // State
    const state = reactive({
      user: {} as IUser,
      access_token: '',
      refresh_token: '',
      isLoggedIn: false,
    })

    async function init(accessToken: string, refreshToken: string) {
      console.log('vao init')

      login(accessToken, refreshToken)
    }

    // Actions
    function login(access_token: string, refresh_token: string) {
      state.access_token = access_token
      state.refresh_token = refresh_token
      state.isLoggedIn = true
    }

    function logout() {
      state.user = {} as IUser
      state.access_token = ''
      state.refresh_token = ''
      state.isLoggedIn = false
      const { protocol, hostname, port, host, origin } = window.location
      window.location.href = `${protocol}//${host.replaceAll('app.', '')}`
    }

    // Return state and actions together
    return { state, login, logout, init }
  },
  {
    persist: {
      storage: sessionStorage,
      pick: ['state'],
    },
  }
)
