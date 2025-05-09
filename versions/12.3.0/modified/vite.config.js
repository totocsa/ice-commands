import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig(({ mode }) => {

    const env = loadEnv(mode, process.cwd(), '')

    return {
        base: env.VITE_BASE_PATH || '/',
        server: {
            host: env.VITE_HOST,
            port: env.VITE_PORT,
            strictPort: true,
            hmr: {
                host: env.VITE_HOST,
                protocol: env.VITE_PROTOCOL,
            },
            origin: env.VITE_PROTOCOL + '://' + env.VITE_HOST + ':' + env.VITE_PORT,
            cors: {
                origin: env.VITE_PROTOCOL + '://' + env.VITE_HOST,
                credentials: true,
            },
        },
        plugins: [
            laravel({
                input: 'resources/js/app.js',
                refresh: true,
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
    }
})
