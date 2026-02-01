import { ref } from 'vue'
import type { AxiosError, AxiosRequestConfig, AxiosProgressEvent } from 'axios'
import apiClient from '@/utils/http'

export async function useApi<T = any>(
  url: string,
  options: {
    method?: 'GET' | 'POST'
    body?: any // data to send (FormData, files, json, etc)
    trackUpload?: boolean // should we track upload progress
  } = {}
) {
  const data = ref<T | null>(null)
  const error = ref<AxiosError | null>(null)
  const isLoading = ref(false)
  const progress = ref<number>(0) // upload progress %

  isLoading.value = true

  try {
    const config: AxiosRequestConfig = {
      url,
      method: options.method ?? (options.body ? 'POST' : 'GET'),
      data: options.body,
    }

    // if tracking upload progress is requested
    if (options.trackUpload && options.body instanceof FormData) {
      config.onUploadProgress = (event: AxiosProgressEvent) => {
        if (event.total) {
          const percentCompleted = Math.round((event.loaded * 100) / event.total)
          progress.value = percentCompleted
        }
      }
    }

    const response = await apiClient.request<T>(config)
    data.value = response.data
  } catch (err: any) {
    error.value = err
  } finally {
    isLoading.value = false
  }

  return {
    data,
    error,
    isLoading,
    progress, // upload progress ref
  }
}
