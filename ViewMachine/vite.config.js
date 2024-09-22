import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [
        vue(),
    ],
    resolve: {
        alias: {
        '@': fileURLToPath(new URL('./src', import.meta.url))
        }
    },
    // vite 代理服务器
    // 用于开发环境
    // 打包vue项目时注释此处 无需代理
    server: {
        proxy: {
            '/api': {
                target: 'http://localpc3gallery',
                changeOrigin: true,
                rewrite: (path)=>path.replace(/^\/api/,''),
            }
        }
    },
})
