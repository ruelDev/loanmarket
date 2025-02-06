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
                },
                yellow: {
                    DEFAULT: "#DFE377",
                    raywhite: "#FFE512",
                    card: "#F6C000",
                },
                white: {
                    DEFAULT: "#fff",
                    1: "#FEFEFE",
                    2: "#E5F7FD",
                    3: "#f7f7f7",
                },
                darkGreen: {
                    DEFAULT: "#1A2C32",
                    1: "#1E3239",
                },
                black: {
                    DEFAULT: "#2B2B2B",
                    1: "#2B2B2Baa",
                },
                red: {
                    card: "#F8285A",
                },
                green: {
                    card: "#17C653",
                },
            },
        },
    },
    plugins: [
        require('flowbite/plugin'),
    ],
};
