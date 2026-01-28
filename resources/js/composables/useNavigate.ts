// composables/useNavigate.ts
import { useRouter, RouteLocationRaw } from 'vue-router'

export function useNavigate() {
  const router = useRouter()

  const navigateTo = (to: RouteLocationRaw) => {
    router.push(to)
  }

  return { navigateTo }
}
