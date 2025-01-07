import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/pages/RBAC/users/index.js',
                'resources/js/pages/risk/assessment/index.js',
                'resources/js/pages/risk/assessment/worksheet/index.js',
                'resources/js/pages/dashboard/index.js',
            ],
            refresh: true,
        }),
    ],

    resolve: {
        alias: {
            '@': '/node_modules',
            'css': '/resources/css',
            'js': '/resources/js',
            '~fonts': path.resolve(__dirname, 'resources/css/fonts')
        },
    },

    server: {
        fs: {
            strict: false
        }
    },

    build: {
        assetsDir: 'assets',
        rollupOptions: {
            input: {
                app: 'resources/js/app.js',
                css: 'resources/css/app.css',
            },
            output: {
                assetFileNames: (assetInfo) => {
                    let extType = assetInfo.name.split('.')[1];
                    if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
                        extType = 'img';
                    } else if (/woff|woff2|eot|ttf|otf/i.test(extType)) {
                        extType = 'fonts';
                    }
                    return `assets/${extType}/[name][extname]`;
                },
                chunkFileNames: 'assets/js/[name]-[hash].js',
                entryFileNames: 'assets/js/[name]-[hash].js',
            },
        },
    },

    publicDir: 'public',
    base: '/',
});