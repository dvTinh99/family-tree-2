import { defineStore } from "pinia"
import { reactive } from "vue"


export interface IUser {
  email: string
  role: number
  updated_at: string
  created_at: string
  id: number
}
export const useAuthStore = defineStore('auth', () => {
  // State
  const state = reactive({
    user: {} as IUser,
    access_token: '',
    refresh_token: '',
    isLoggedIn: false,
  });

  function init(accessToken: string, refreshToken: string) {
    login(accessToken, refreshToken);
  }

  // Actions
  function login(access_token: string, refresh_token: string) {
    state.access_token = access_token;
    state.refresh_token = refresh_token;
    state.isLoggedIn = true;
  }

  function logout() {
    state.user = {} as IUser;
    state.access_token = '';
    state.refresh_token = '';
    state.isLoggedIn = false;
  }

  // Return state and actions together
  return { ...state, login, logout, init };
}, {
    persist: {
      storage: sessionStorage,
      pick: ['user', 'access_token', 'refresh_token', 'isLoggedIn'],
    },
  })
