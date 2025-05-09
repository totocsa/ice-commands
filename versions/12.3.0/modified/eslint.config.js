import vue from "eslint-plugin-vue"
import vueParser from "vue-eslint-parser"

export default [
    {
        files: ["**/*.vue", "**/*.js"],
        languageOptions: {
            parser: vueParser,
            parserOptions: {
                ecmaVersion: "latest",
                sourceType: "module",
                parser: "@babel/eslint-parser", // Ha szükséges a modern JS támogatás
                requireConfigFile: false, // Ha nincs külön Babel config
            },
        },
        plugins: {
            vue,
        },
        rules: {
            "vue/require-valid-default-prop": "error", // Érvénytelen prop-alapértékek ellenőrzése
            "vue/require-prop-types": "error", // Kötelező prop típusmegadás
            "vue/no-unused-vars": "warn", // Nem használt változók figyelmeztetés
        },
    },
]
