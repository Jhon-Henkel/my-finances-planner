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
                workbox: {
                    cleanupOutdatedCaches: true,
                    clientsClaim: true,
                    skipWaiting: true,
                    runtimeCaching: [
                        {
                            urlPattern: /\/api\//,
                            handler: 'NetworkOnly'
                        },
                        { // cache para assets
                            urlPattern: /\.(?:png|jpg|jpeg|svg|gif|ico|woff2|woff|ttf|css)$/,
                            handler: 'CacheFirst',
                            options: {
                                cacheName: 'assets-cache',
                                expiration: {
                                    maxEntries: 100,
                                    maxAgeSeconds: 30 * 24 * 60 * 60, // 30 dias
                                },
                            },
                        }
                    ]
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
