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
        primary: {
          50: '#f0f4ff',
          100: '#dce6ff',
          200: '#bfd0ff',
          300: '#93aeff',
          400: '#6080ff',
          500: '#3d56f5',
          600: '#2b3fe8',
          700: '#2230ce',
          800: '#2129a7',
          900: '#1e2685',
          950: '#161a52',
        },
        gold: {
          400: '#f0c14b',
          500: '#d4a017',
          600: '#b8860b',
        }
      },
      fontFamily: {
        serif: ['Georgia', 'Cambria', '"Times New Roman"', 'Times', 'serif'],
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}
