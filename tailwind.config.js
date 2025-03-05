/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        container: {
            center: true,
            padding: {
                DEFAULT: "1rem",
                sm: "2rem",
                lg: "4rem",
                xl: "5rem",
                "2xl": "6rem",
            },
        },
        extend: {
            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
                geomanist: ["Geomanist", "sans-serif"],
                ttramillas: ["ttRamillas", "sans-serif"],
            },
            colors: {
                blue: {
                    DEFAULT: "#00ABE6",
                    hover: "#00ABE612",
                    1: "#01355C",
                    2: "#01355C66",
                    3: "#E5F7FD",
                    card: "#1B84FF",
                    anz: "#004165",
                },
                yellow: {
                    DEFAULT: "#DFE377",
                    raywhite: "#FFE512",
                    card: "#F6C000",
                    bankaustralia: "#F4F1ED",
                    peopleschoice: "#EDEADF",
                },
                white: {
                    DEFAULT: "#fff",
                    1: "#FEFEFE",
                    2: "#E5F7FD",
                    3: "#f7f7f7",
                    bendigo: "#F6F2F5",
                    nab: "#E6E6E6",
                },
                darkGreen: {
                    DEFAULT: "#1A2C32",
                    1: "#1E3239",
                },
                black: {
                    DEFAULT: "#2B2B2B",
                    1: "#2B2B2Baa",
                    combank: "#231F20",
                },
                red: {
                    card: "#F8285A",
                },
                green: {
                    card: "#17C653",
                    bankfirst: "#47D7AC",
                    stgeorge: "#78BE20",
                },
                purple: {
                    ubank: "#E3C1FF",
                    beyondbankaus: "#522058"
                },
            },
            animation: {
                'hero-title': 'fadeInUp 0.8s ease-out forwards',
                'slide-left': 'slideInLeft 1s ease-out forwards',
                'slide-right': 'slideInRight 1s ease-out forwards',
                'card': 'fadeIn 0.8s ease-out forwards',
            },
            keyframes: {
                fadeInUp: {
                    '0%': { opacity: 0, transform: 'translateY(30px)' },
                    '100%': { opacity: 1, transform: 'translateY(0)' },
                },
                slideInLeft: {
                    '0%': { transform: '-translate-x-1/2' },
                    '100%': { transform: 'translateX(0)' },
                },
                slideInRight: {
                    '0%': { transform: 'translate-x-1/2' },
                    '100%': { transform: 'translateX(0)' },
                },
                fadeIn: {
                    '0%': { opacity: 0 },
                    '100%': { opacity: 1 },
                },
            },
        },
    },
    plugins: [
        require('flowbite/plugin'),
    ],
};
