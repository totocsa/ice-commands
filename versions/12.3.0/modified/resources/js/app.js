import "./bootstrap"
import "../css/app.css"
import "./Components/totocsa/axiosInterceptors.js"

import { createApp, h } from "vue"
import { createPinia } from "pinia"
import { createInertiaApp } from "@inertiajs/vue3"
import { ZiggyVue } from "../../vendor/tightenco/ziggy"

const appName = import.meta.env.VITE_APP_NAME || "Laravel"

const nameToPath = name => {
    const vendorStart = name.indexOf("vendor/")
    let path = name.substring(vendorStart - 1)
    path = path.replace(/Pages\/.*$/, "")

    return path
}

const nameResolve = name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let res = pages[`./Pages/${name}.vue`]

    if (res === undefined) {
        let path = nameToPath(name)
        console.log('PATH: ', path)
        if (path === '/vendor/totocsa/ice-authorization-gui/resources/js/') {
            const users = import.meta.glob('/vendor/totocsa/ice-authorization-gui/resources/js/**/*.vue', { eager: true })
            const index = name.substring(name.indexOf("/vendor/")) + '.vue'
            res = users[index]
        }

        if (path === '/vendor/totocsa/ice-database-translation-locally/resources/js/') {
            const users = import.meta.glob('/vendor/totocsa/ice-database-translation-locally/resources/js/**/*.vue', { eager: true })
            const index = name.substring(name.indexOf("/vendor/")) + '.vue'
            res = users[index]
        }

        if (path === '/vendor/totocsa/ice-icseusd/resources/js/') {
            const users = import.meta.glob('/vendor/totocsa/ice-icseusd/resources/js/**/*.vue', { eager: true })
            const index = name.substring(name.indexOf("/vendor/")) + '.vue'
            res = users[index]
        }

        if (path === '/vendor/totocsa/ice-modal-li-fo/resources/js/') {
            const users = import.meta.glob('/vendor/totocsa/ice-modal-li-fo/resources/js/**/*.vue', { eager: true })
            const index = name.substring(name.indexOf("/vendor/")) + '.vue'
            res = users[index]
        }

        if (path === '/vendor/totocsa/ice-translations-gui/resources/js/') {
            const users = import.meta.glob('/vendor/totocsa/ice-translations-gui/resources/js/**/*.vue', { eager: true })
            const index = name.substring(name.indexOf("/vendor/")) + '.vue'
            res = users[index]
        }

        if (path === '/vendor/totocsa/ice-users-gui/resources/js/') {
            const users = import.meta.glob('/vendor/totocsa/ice-users-gui/resources/js/**/*.vue', { eager: true })
            const index = name.substring(name.indexOf("/vendor/")) + '.vue'
            res = users[index]
        }
    }

    console.log('NAME: ', name)
    console.log('RES: ', res)
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
