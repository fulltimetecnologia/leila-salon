import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/robsontenorio/mary/src/View/Components/**/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'salon': {
                    50: '#fdf4f8',
                    100: '#fbe8f3',
                    200: '#f9d1e9',
                    300: '#f5aad5',
                    400: '#ee79ba',
                    500: '#e3499f',
                    600: '#d0297e',
                    700: '#b41d63',
                    800: '#951a52',
                    900: '#7d1b46',
                    950: '#4c0a27',
                },
                'lavender': {
                    50: '#f8f7ff',
                    100: '#efedff',
                    200: '#e1ddff',
                    300: '#cbc2ff',
                    400: '#b09dff',
                    500: '#9675ff',
                    600: '#8750f7',
                    700: '#773ee3',
                    800: '#6535bf',
                    900: '#532e9c',
                    950: '#341b6a',
                },
            },
        },
    },

    plugins: [forms],

    daisyui: {
        themes: [
            {
                lailasalon: {
                    'primary': '#e3499f',
                    'primary-content': '#ffffff',
                    'secondary': '#9675ff',
                    'secondary-content': '#ffffff',
                    'accent': '#f5aad5',
                    'accent-content': '#4c0a27',
                    'neutral': '#2a2a2a',
                    'neutral-content': '#ffffff',
                    'base-100': '#ffffff',
                    'base-200': '#f8f7ff',
                    'base-300': '#efedff',
                    'base-content': '#1f2937',
                    'info': '#3abff8',
                    'success': '#36d399',
                    'warning': '#fbbd23',
                    'error': '#f87272',
                },
            },
        ],
    },
};
