import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { fileURLToPath, URL } from 'node:url'
import { resolve } from 'node:path'

export default defineConfig({
    server: {
        host: '0.0.0.0',
        disableHostCheck: true,
        usePolling: true,
        hmr: {
            host: 'localhost'
        },
        ignored: [
            '/.github/',
            '/app/',
            '/bootstrap/',
            '/config/',
            '/database/',
            '/node_modules/',
            '/routes/',
            '/scripts/',
            '/storage/',
            '/tests/',
            '/vendor/',
        ]
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false
                }
            }
        }),
    ],
    resolve: {
        alias: [
            {
                find: "~bootstrap",
                replacement: resolve(__dirname, "'/node_modules/bootstrap'")
            },
            {
                find: "~vue",
                replacement: resolve(__dirname, "./resources/vue")
            },
            {
                find: "~vue-component",
                replacement: resolve(__dirname, "./resources/vue/components")
            },
            {
                find: "~js",
                replacement: resolve(__dirname, "./resources/js")
            }
        ]
    },
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: {
                app: '/resources/js/app.js',
                'app.scss': '/resources/sass/app.scss',
                'app.css': '/resources/css/app.css',
            }
        }
    },
    test: {
        environment: 'happy-dom',
        coverage: {
            all: true,
            include: ['resources/js', 'resources/vue'],
            exclude: [
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/router',
                'resources/vue/store',
                'resources/vue/App.vue',
            ],
            reportsDirectory: './spec/coverage',
        }
    }
});
