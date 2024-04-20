/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#f29492", // Replace with your primary color
                secondary: "#114357", // Replace with your secondary color
            },
        },
    },
    plugins: [],
};
