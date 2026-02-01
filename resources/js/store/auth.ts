import router from '@/router/router'
import { defineStore } from 'pinia'
import { reactive } from 'vue'
import { useFamilyStore } from './family'

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
      login(accessToken, refreshToken)
      // fetch family
      // const familyStore = useFamilyStore()
      // await familyStore.initStore()
    }

    // Actions
    function login(access_token: string, refresh_token: string) {
      state.access_token = access_token
      state.refresh_token = refresh_token
      state.isLoggedIn = true

      localStorage.setItem('accessToken', access_token)
      localStorage.setItem('refreshToken', refresh_token)
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
