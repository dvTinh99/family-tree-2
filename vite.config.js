import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import vueDevTools from 'vite-plugin-vue-devtools'
import svgLoader from 'vite-svg-loader'

export default defineConfig({
  plugins: [
    vueDevTools({
      appendTo: 'resources/js/app.ts'
    }),
    laravel({
      input: ['resources/css/app.css', 'resources/css/flow.css', 'resources/js/app.ts'],
      refresh: true,
    }),
    tailwindcss(),
    vue(),
    svgLoader(),
  ],
  server: {
    watch: {
      ignored: ['**/storage/framework/views/**'],
    },
    host: '0.0.0.0',
    port: 5174,
    strictPort: true,
    origin: 'http://app.family.test:5174',
    hmr: {
      host: 'app.family.test',
    },
    cors: {
      origin: '*',
      credentials: true,
    },

  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js'),
    }
  }
})
