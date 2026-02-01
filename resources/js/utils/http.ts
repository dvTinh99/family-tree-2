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
    const token = localStorage.getItem('accessToken')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => Promise.reject(error)
)

let isRefreshing = false
let failedQueue = [] as any[]

const processQueue = (error, token = null) => {
  failedQueue.forEach((prom) => {
    if (error) {
      prom.reject(error)
    } else {
      prom.resolve(token)
    }
  })
  failedQueue = []
}

apiClient.interceptors.response.use(
  (response) => response,
  async (error) => {
    const originalRequest = error.config

    // nếu không có response → network error
    if (!error.response) {
      return Promise.reject(error)
    }

    // chỉ handle 401, và tránh retry vô hạn
    if (error.response.status === 401 && !originalRequest._retry) {
      // nếu đang refresh → chờ
      if (isRefreshing) {
        return new Promise((resolve, reject) => {
          failedQueue.push({
            resolve: (token) => {
              originalRequest.headers.Authorization = `Bearer ${token}`
              resolve(apiClient(originalRequest))
            },
            reject,
          })
        })
      }

      originalRequest._retry = true
      isRefreshing = true

      try {
        const refreshResponse = await axios.post(
          '/api/auth/refresh',
          { refresh_token: localStorage.getItem('refreshToken') },
          { withCredentials: true } // nếu refresh dùng cookie
        )
        const newToken = refreshResponse.data.data.access_token
        localStorage.setItem('accessToken', newToken)

        apiClient.defaults.headers.Authorization = `Bearer ${newToken}`

        processQueue(null, newToken)

        return apiClient(originalRequest)
      } catch (refreshError) {
        processQueue(refreshError, null)

        // logout tại đây
        localStorage.removeItem('authToken')
        // router.push('/login')

        return Promise.reject(refreshError)
      } finally {
        isRefreshing = false
      }
    }

    return Promise.reject(error)
  }
)

export default apiClient
