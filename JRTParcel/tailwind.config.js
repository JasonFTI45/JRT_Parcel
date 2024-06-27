import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            maxHeight: {
                '500': '500px',
                // add as many as you need
            },
            backgroundImage: theme => ({
                'custom-image': "url('/public/assets/logo.png')",
                'custom-image-2': "url('/public/assets/logo2.png')",
              })
        },
    },

    plugins: [forms],
};
