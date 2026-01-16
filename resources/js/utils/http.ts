import axios from 'axios'

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || '/api',
  headers: {
    'Content-Type': 'application/json',
  },
  withCredentials: false, // nếu bạn dùng cookie auth
})

apiClient.interceptors.request.use(
  (config) => {
    // auto attach token
    const token = localStorage.getItem('authToken')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => Promise.reject(error)
)

apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    // handle errors globally
    if (error.response?.status === 401) {
      // redirect logout / login
    }
    return Promise.reject(error)
  }
)

export default apiClient
