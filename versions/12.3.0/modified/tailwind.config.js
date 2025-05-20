import defaultTheme from "tailwindcss/defaultTheme"
import forms from "@tailwindcss/forms"
import typography from "@tailwindcss/typography"

/** @type {import('tailwindcss').Config} */
export default {
    presets: [
        require("./vendor/totocsa/ice-icseusd/resources/js/Components/totocsa/Icseusd/js/animate-success-form.js"),
    ],
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./vendor/totocsa/laravel-tailwindcss-helper/TailwindcssHelper.php",
        "./vendor/totocsa/ice-authorization-gui/resources/js/**/*.vue",
        "./vendor/totocsa/ice-database-translation-locally/resources/js/**/*.vue",
        "./vendor/totocsa/ice-icseusd/resources/js/**/*.vue",
        "./vendor/totocsa/ice-modal-li-fo/resources/js/**/*.vue",
        "./vendor/totocsa/ice-translations-gui/resources/js/**/*.vue",
        "./vendor/totocsa/ice-users-gui/resources/js/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ice: {
                    50: 'oklch(0.98 0.012 235)',
                    100: 'oklch(0.95 0.02 235)',
                    200: 'oklch(0.90 0.04 236)',
                    300: 'oklch(0.85 0.06 236)',
                    400: 'oklch(0.80 0.08 238)',
                    500: 'oklch(0.75 0.11 240)',
                    600: 'oklch(0.68 0.13 242)',
                    700: 'oklch(0.60 0.14 245)',
                    800: 'oklch(0.50 0.12 247)',
                    900: 'oklch(0.40 0.10 250)',
                    950: 'oklch(0.30 0.08 252)',
                },
            },
        },
    },

    plugins: [forms, typography],
}
