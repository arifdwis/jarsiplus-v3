/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    50: '#E9F6F2',
                    100: '#C6EBE2',
                    500: '#0E8F79',
                    600: '#0A6E5D',
                    800: '#094E43',
                    900: '#08302A',
                },
                accent: {
                    100: '#FEF3D6',
                    400: '#F2B441',
                    600: '#C8871B',
                },
                ink: {
                    900: '#14202B',
                    700: '#293745',
                    600: '#3E4C57',
                    400: '#71808A',
                    200: '#CBD5E1',
                },
                paper: '#F7F5F0',
                surface: '#FFFFFF',
                line: '#E5E1D8',
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                heading: ['"Plus Jakarta Sans"', 'sans-serif'],
                body: ['Inter', 'sans-serif'],
            },
        },
    },
    plugins: [],
};
