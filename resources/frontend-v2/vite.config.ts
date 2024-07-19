/// <reference types="vitest" />
import legacy from '@vitejs/plugin-legacy'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import {defineConfig, loadEnv} from 'vite'
import {VitePWA} from "vite-plugin-pwa"

export default defineConfig((): any => {
    const env = loadEnv('', process.cwd())
    return {
        plugins: [
            vue(),
            legacy(),
            VitePWA({
                registerType: 'autoUpdate'
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
            environment: 'jsdom',
            coverage: {
                reportsDirectory: './tests/coverage',
                include: ['src/**/*'],
                exclude: [''],
                all: true
            }
        }
    }
})
