module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './node_modules/flowbite/**/*.js'
  ],
  theme: {
    extend: {
      colors: {
        'light-blue': '#0094C6',
      }
    }
  },
  plugins: [require('flowbite/plugin')]
};
