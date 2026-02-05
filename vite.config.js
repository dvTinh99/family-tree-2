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
    host: '0.0.0.0',
    port: 5174,
    strictPort: true,
    watch: {
      ignored: ['**/storage/framework/views/**'],
    },
    cors: {
        origin: true,      // dynamically allow any origin
        credentials: true, // support cookies/sessions
    },
    hmr: {
        protocol: 'ws',     // default WebSocket protocol
        // host: undefined   // let Vite auto-detect
    },

    // origin: 'http://app.family.test:5174',
    // hmr: {
    //   protocol: 'ws',
    //   clientPort: 5174,
    //   host: '',
    // },
    // cors: {
    //   origin: true,
    //   credentials: true,
    // },

  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js'),
    }
  }
})
