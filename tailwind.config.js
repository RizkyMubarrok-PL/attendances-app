import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        "./node_modules/flowbite/**/*.js",
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            zIndex: {
                "-1": "-1",
            },
            transformOrigin: {
                "0": "0%",
            },
        },
    },
    plugins: [],
    variants: {
        borderColor: ['responsive', 'hover', 'focus', 'focus-within'],
    },

};
