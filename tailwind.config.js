import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import aspectRatio from '@tailwindcss/aspect-ratio';
import animate from 'tailwindcss-animate';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'hgw-ink': '#0f172a',
                'hgw-emerald': '#0ea5e9',
                'hgw-forest': '#047857',
                'hgw-amber': '#facc15',
                'hgw-rose': '#f87171',
            },
            backgroundImage: {
                'hgw-texture': "url('https://images.unsplash.com/photo-1485808191679-5f86510681a2?auto=format&fit=crop&w=2000&q=80')",
                'hgw-beans': "url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?auto=format&fit=crop&w=2000&q=80')",
            },
            boxShadow: {
                'glow-sm': '0 10px 30px -15px rgba(16, 185, 129, 0.35)',
                'glow': '0 25px 50px -20px rgba(16, 185, 129, 0.45)',
            },
            blur: {
                xs: '2px',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography, aspectRatio, animate],
};
