import "./bootstrap"
import "../css/app.css"
import "../../vendor/totocsa/ice-icseusd/resources/js/Components/Icseusd/js/axiosInterceptors.js"
import { createApp, h } from "vue"
import { createPinia } from "pinia"
import { createInertiaApp } from "@inertiajs/vue3"
import { ZiggyVue } from "../../vendor/tightenco/ziggy"

const appName = import.meta.env.VITE_APP_NAME || "Laravel"

const nameResolve = name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let res = pages[`./Pages/${name}.vue`]

    if (res === undefined) {
        const allModules = import.meta.glob([
            '/vendor/totocsa/ice-authorization-gui/resources/js/**/*.vue',
            '/vendor/totocsa/ice-database-translation-locally/resources/js/**/*.vue',
            '/vendor/totocsa/ice-icseusd/resources/js/**/*.vue',
            '/vendor/totocsa/ice-modal-li-fo/resources/js/**/*.vue',
            '/vendor/totocsa/ice-translations-gui/resources/js/**/*.vue',
            '/vendor/totocsa/ice-users-gui/resources/js/**/*.vue',
        ], { eager: true })

        const index = name.substring(name.indexOf("/vendor/")) + '.vue'
        res = allModules[index]
    }

    return res
}

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: name => nameResolve(name),
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
