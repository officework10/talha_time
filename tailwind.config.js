/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php', // Blade files in resources
    './resources/**/*.js', // JavaScript files in resources
    './resources/**/*.vue', // Vue components (if you use Vue)
    './node_modules/flowbite/**/*.js', // Flowbite JS components
  ],
  theme: {
    extend: {}, // You can add custom themes here
  },
  plugins: [
    require('flowbite/plugin'), // Flowbite plugin for Tailwind
  ],
};
