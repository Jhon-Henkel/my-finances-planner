/// <reference types="vitest" />
import vue from '@vitejs/plugin-vue'
import path from 'path'
import {defineConfig, loadEnv} from 'vite'
import {VitePWA} from "vite-plugin-pwa"
import { codecovVitePlugin } from "@codecov/vite-plugin";

export default defineConfig((): any => {
    const env = loadEnv('', process.cwd())
    return {
        plugins: [
            vue(),
            VitePWA({
                registerType: 'autoUpdate'
            }),
            codecovVitePlugin({
                enableBundleAnalysis: process.env.VITE_CODECOV_TOKEN !== undefined,
                bundleName: "my-finances-planner",
                uploadToken: process.env.VITE_CODECOV_TOKEN,
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
