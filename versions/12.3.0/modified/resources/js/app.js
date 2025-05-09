import "./bootstrap"
import "../css/app.css"
import "./Components/totocsa/axiosInterceptors.js"

import { createApp, h } from "vue"
import { createPinia } from "pinia"
import { createInertiaApp } from "@inertiajs/vue3"
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers"
import { ZiggyVue } from "../../vendor/tightenco/ziggy"

const appName = import.meta.env.VITE_APP_NAME || "Laravel"

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const pinia = createPinia()

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue)
            .mount(el)
    },
    progress: {
        color: "#4B5563",
    },
})
