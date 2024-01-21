/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["*"],
  theme: {
    container: {
      center: true,
      padding: "24px",
    },
    extend: {
      colors: {
        bluecstm: "#2563EB",
        light: "#FFFFFF",
        greencstm: "#16A34A",
        black: "#334155",
      },
      screens: {
        "2xl": "1320px",
      },
    },
  },
  plugins: [],
};
