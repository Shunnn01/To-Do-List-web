/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  safelist: [
    'bg-gray-100',
    'bg-white',
    'text-gray-800',
    'text-black',
    'text-gray-100',
    'bg-gray-900',
    'dark:bg-gray-900',
    'dark:text-gray-100',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
