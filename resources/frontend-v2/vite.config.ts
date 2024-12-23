/// <reference types="vitest" />
import vue from '@vitejs/plugin-vue'
import path from 'path'
import {defineConfig, loadEnv} from 'vite'
import {VitePWA} from "vite-plugin-pwa"

export default defineConfig((): any => {
    const env = loadEnv('', process.cwd())
    return {
        plugins: [
            vue(),
            VitePWA({
                registerType: 'autoUpdate',
                manifest: {
                    name: "Finanças na Mão",
                    short_name: "Finanças na Mão",
                    start_url: "/v2/dashboard",
                    icons: [
                        {
                            src: "/public/android-chrome-192x192.png",
                            sizes: "192x192",
                            type: "image/png"
                        },
                        {
                            src: "/public/android-chrome-512x512.png",
                            sizes: "512x512",
                            type: "image/png"
                        }
                    ],
                    theme_color: "#ffffff",
                    background_color: "#ffffff",
                    display: "standalone"
                }
            })
        ],
        define: {
            'process.env': env
        },
        resolve: {
            alias: {
                '@': path.resolve(__dirname, './src'),
            },
        },
        build: {
            manifest: true,
            outDir: '../../public/build-ionic',
            emptyOutDir: true,
            chunkSizeWarningLimit: 1024
        },
        base: env.VITE_ENV === 'production' ? '/public/build-ionic/' : '/',
        test: {
            globals: true,
            environment: 'happy-dom',
            coverage: {
                reportsDirectory: './tests/coverage',
                include: ['src/**/*'],
                exclude: [
                    'src/App.vue',
                    'src/main.ts',
                    'src/vite-env.d.ts',
                    'src/router/index.ts',
                    'src/directives/mask/money/*',
                ],
                all: true
            }
        }
    }
})
