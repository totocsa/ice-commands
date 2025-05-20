import { defineConfig, loadEnv } from 'vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import path from 'path'

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
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/js'),
                '@IceAuthorizationGui': path.resolve(__dirname, 'vendor/totocsa/ice-authorization-gui/resources/js'),
                '@IceDatabaseTranslationLocally': path.resolve(__dirname, '/vendor/totocsa/ice-database-translation-locally/resources/js'),
                '@IceIcseusd': path.resolve(__dirname, 'vendor/totocsa/ice-icseusd/resources/js'),
                '@IceModalLiFo': path.resolve(__dirname, 'vendor/totocsa/ice-modal-li-fo/resources/js'),
                '@IceTranslationsGui': path.resolve(__dirname, '/vendor/totocsa/ice-translations-gui/resources/js'),
                '@IceUsersGui': path.resolve(__dirname, '/vendor/totocsa/ice-users-gui/resources/js'),
            },
        },
    }
})
