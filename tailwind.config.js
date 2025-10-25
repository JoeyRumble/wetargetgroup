/** @type {import('tailwindcss').Config} */
module.exports = {
    content: {
        relative: true,
        transform: (content) => content.replace(/taos:/g, ''),
        files: [
            './templates/**/*.twig',   // alle twig templates in templates/
            './assets/**/*.{js,ts}',   // alle JS/TS bestanden in assets/
        ],
    },
    theme: {
        extend: {
            keyframes: {
                'bg-move': {
                    '0%':   { transform: 'scale(1.22) translate(0px, 0px) rotate(0deg)' },
                    '10%':  { transform: 'scale(1.32) translate(-80px, 60px) rotate(1deg)' },
                    '20%':  { transform: 'scale(1.4) translate(120px, -90px) rotate(-1deg)' },
                    '30%':  { transform: 'scale(1.38) translate(-160px, 100px) rotate(2deg)' },
                    '40%':  { transform: 'scale(1.45) translate(180px, -120px) rotate(-2deg)' },
                    '50%':  { transform: 'scale(1.5) translate(-200px, 140px) rotate(3deg)' },
                    '60%':  { transform: 'scale(1.44) translate(220px, -160px) rotate(-3deg)' },
                    '70%':  { transform: 'scale(1.38) translate(-240px, 180px) rotate(2deg)' },
                    '80%':  { transform: 'scale(1.32) translate(260px, -200px) rotate(-1deg)' },
                    '90%':  { transform: 'scale(1.25) translate(-280px, 220px) rotate(0deg)' },
                    '100%': { transform: 'scale(1.35) translate(0px, 0px) rotate(0deg)' },
                },
            },
            animation: {
                'bg-move': 'bg-move 60s linear infinite alternate',
            },
        },
    },
    plugins: [
        require('taos/plugin')
    ],
    safelist: [
        '!duration-[0ms]',
        '!delay-[0ms]',
        'html.js :where([class*="taos:"]:not(.taos-init))',
        // TAOS dynamic classes
        'translate-x-0',
        'translate-x-[10%]',
        'translate-x-[20%]',
        'translate-x-[30%]',
        'translate-x-[100%]',
        'opacity-0',
        'opacity-100',
        // add more if needed
    ],
}
// Tailwind CSS configuratiebestand