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
            colors: {
                primary: {
                    DEFAULT: '#1E3A5F', // azul marino - marca, botones principales, enlaces activos
                    dark: '#14283F',    // hover del azul marino
                },
                danger: {
                    DEFAULT: '#DC2626', // rojo - SOLO alertas, errores, acciones destructivas
                    dark: '#991B1B',    // hover de botones destructivos
                },
                ink: {
                    DEFAULT: '#1A1A1A', // texto principal, encabezados
                    label: '#374151',   // labels de formularios
                    muted: '#6B7280',   // texto secundario, placeholders, bordes de inputs
                },
                surface: {
                    DEFAULT: '#FFFFFF', // fondo de tarjetas, formularios
                    soft: '#F3F4F6',    // fondo general de la página, rayas de tablas
                },
            },
        },
    },

    plugins: [forms],
};