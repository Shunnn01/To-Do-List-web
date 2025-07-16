/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  safelist: [
    'bg-white',
    'bg-gray-100',
    'bg-gray-900',
    'text-gray-800',
    'text-black',
    'text-gray-100',
    'dark:bg-gray-900',
    'dark:text-gray-100',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
