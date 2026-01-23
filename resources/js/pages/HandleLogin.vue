<script setup lang="ts">
import { useAuthStore } from '@/store/auth'
import { onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
const authStore = useAuthStore()
const router = useRouter()
const route = useRoute()
onMounted(() => {
  // This page is just a placeholder to handle login redirects.
  // You can add any additional logic here if needed.
  const accessToken = route.query.access_token
  const refreshToken = route.query.refresh_token

  if (typeof accessToken === 'string' && typeof refreshToken === 'string') {
    authStore.init(accessToken, refreshToken).then(() => {
      // After successful login, redirect to the home page or any other page
      router.replace({ name: 'home' })
    })
  } else {
    // If tokens are missing, redirect to the login page
    authStore.logout()
  }
})
</script>
