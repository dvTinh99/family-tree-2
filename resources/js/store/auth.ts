import type { ApiResponse } from '~/entities/Response'

type TAuth = {
  user: IUser
  access_token: string
  refresh_token: string
  token_type: string
}

export interface IUser {
  email: string
  role: number
  updated_at: string
  created_at: string
  id: number
}

export const ROLE_ADMIN = 1
export const ROLE_CANDIDATE = 2
export const ROLE_COMPANY = 3

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: {} as IUser,
    access_token: '',
    refresh_token: '',
    isLoggedIn: false,
  }),
  getters: {
    getUser: (state) => state.user,
    getAccessToken: (state) => state.access_token,
    isAuthenticated: (state) => state.isLoggedIn,
    isAdmin: (state) => state.user.role == ROLE_ADMIN,
    isCandidate: (state) => state.user.role == ROLE_CANDIDATE,
    isCompany: (state) => state.user.role == ROLE_COMPANY,
  },
  actions: {
    async loginWithEmail(email: string, password: string) {
      // const rs = await authApi.loginWithEmail(email, password)
      const { data, error } = await useApi<ApiResponse<TAuth>>('/api/login', {
        method: 'POST',
        body: {
          email,
          password,
        },
      })
      this.user = data.value.data.user
      this.access_token = data.value.data.access_token
      this.refresh_token = data.value.data.refresh_token
      this.isLoggedIn = true

      if (this.isAdmin) {
        navigateTo('/admin')
      } else if (this.isCandidate) {
        navigateTo('/candidate')
      }

      return data.value.status
    },
    async login(access_token: string, refresh_token: string) {
      this.access_token = access_token
      this.refresh_token = refresh_token
      this.isLoggedIn = true
    },
    async register(name: string, email: string, password: string, password_confirmation: string) {
      // this.user = user
      const result = await useApi<ApiResponse<TAuth>>('/api/register', {
        method: 'POST',
        body: {
          name,
          email,
          password,
          password_confirmation,
        },
      })

      const { data, success, message } = result.data.value
      this.user = data.user
      this.access_token = data.access_token
      this.refresh_token = data.refresh_token
      this.isLoggedIn = true

      if (this.isAdmin) {
        navigateTo('/admin')
      } else if (this.isCandidate) {
        navigateTo('/candidate')
      }
    },
    async logout() {
      this.user = {} as IUser
      this.access_token = ''
      this.refresh_token = ''
      this.isLoggedIn = false

      navigateTo('/login')
    },
  },
  persist: ['access_token', 'refresh_token'],
})
