import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        disableHostCheck: true,
        hmr: {
            host: 'localhost'
        },
        watch: {
            ignored: [
                '/.github/',
                '/app/',
                '/bootstrap/',
                '/config/',
                '/database/',
                '/node_modules/',
                '/routes/',
                '/storage/',
                '/tests/',
                '/vendor/',
            ]
        },
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
        alias: {
            '~bootstrap': '/node_modules/bootstrap'
        }
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
    }
});