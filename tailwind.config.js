/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    theme: {
        extend: {
            colors: {
                cabai: "#C0392B",
                turmeric: "#E5A817",
                banana: "#2D6A4F",
            },
            fontFamily: {
                display: ["Poppins", "sans-serif"],
            },
        },
    },
    plugins: [],
};
