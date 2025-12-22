export default {
  content: [
    "./index.php",
    "./*.php",
    "./inc/**/*.php",
    "./acf-blocks/**/*.php",
    "./template-parts/**/*.php",
    "./templates/**/*.php",
    "./src/**/*.{js,css}",
  ],

  theme: {
    extend: {},
  },
  plugins: [],
};

module.exports = {
  theme: {
    extend: {
      fontFamily: {
        ibm: ['"IBM Plex Sans"', "sans-serif"],
      },
    },
  },
};
