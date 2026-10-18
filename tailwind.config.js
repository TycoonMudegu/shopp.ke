/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./public/**/*.php",
    "./site/**/*.php",
    "./site/**/*.md"
  ],
  theme: {
    extend: {
      colors: {
        brandGreen: "#93BD57",
        brandBlue: "#67B2D8",
        brandDark: "#1a1a1a",
        brandLight: "#f8f9fa",
      },
      fontFamily: {
        sans: ['Lato', 'sans-serif'],
        serif: ['"GFS Didot"', 'serif'],
        display: ['Pacifico', 'cursive'],
      },
      backgroundImage: {
        'noise': "url('/assets/images/ui/noise.png')",
      }
    },
  },
  plugins: [],
}
