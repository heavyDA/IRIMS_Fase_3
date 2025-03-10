import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/icons.css',
                'resources/js/app.js',
                'resources/js/pages/dashboard/index.js',
                'resources/js/pages/dashboard/_monitoring_progress.js',
                'resources/js/pages/dashboard/_top_risk.js',
                'resources/js/pages/RBAC/users/index.js',

                'resources/js/pages/risk/assessment/index.js',
                'resources/js/pages/risk/top_risk/index.js',
                'resources/js/pages/risk/worksheet/index.js',
                'resources/js/pages/risk/worksheet/edit.js',
                'resources/js/pages/risk/worksheet/table_view.js',

                'resources/js/pages/report/risk_profile/index.js',
                'resources/js/pages/report/risk_monitoring/index.js',

                'resources/js/pages/risk/monitoring/index.js',
                'resources/js/pages/risk/monitoring/create.js',
                'resources/js/pages/risk/monitoring/edit.js',
                'resources/js/pages/risk/monitoring/detail.js',

                'resources/js/pages/master/bumn_scale/index.js',
                'resources/js/pages/master/existing_control_type/index.js',
                'resources/js/pages/master/risk_category/index.js',
                'resources/js/pages/master/risk_treatment_type/index.js',
                'resources/js/pages/master/risk_treatment_option/index.js',
                'resources/js/pages/setting/risk_metric/index.js',
                'resources/js/pages/setting/risk_metric/form.js',
                'resources/js/pages/setting/position/index.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/node_modules',
            '~css': '/resources/css',
            '~js': '/resources/js',
            '~fonts': path.resolve(__dirname, 'resources/fonts'),
        },
    },
    build: {
        target: 'esnext',
        assetsInlineLimit: 0,
        outDir: 'public/build',
        emptyOutDir: true,
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    let extType = assetInfo.name.split('.')[1];
                    if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
                        extType = 'img';
                    } else if (/woff|woff2|eot|ttf|otf/i.test(extType)) {
                        extType = 'fonts';
                    }
                    return `assets/${extType}/[name]-[hash][extname]`;
                },
                chunkFileNames: 'assets/js/[name]-[hash].js',
                entryFileNames: 'assets/js/[name]-[hash].js',
            },
        },
    },
});
