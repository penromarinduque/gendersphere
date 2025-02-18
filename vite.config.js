import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    // base: 'https://gendersphere.penromarinduque.gov.ph',
    base: '',
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
            // publicDirectory: "public_html",
        }),
        vue({ 
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    // build: {
    //     outDir: 'public_html/build',
    // },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    // server: {
    //     // for production build only remove this for local
    //     // origin: 'localhost:9001',
    //     // origin: 'https://gendersphere.penromarinduque.gov.ph',
    // },
});
