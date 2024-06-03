/** @type {import("tailwindcss").Config} */
module.exports = {
  content: ["views/**/*.php", "js/**/*.js"],
  theme: {
    fontSize: {
      "xs": ["clamp(0.64rem, 0.05vw + 0.63rem, 0.67rem)"],
      "sm": ["clamp(0.8rem, 0.17vw + 0.76rem, 0.89rem)"],
      "base": ["clamp(1rem, 0.34vw + 0.91rem, 1.19rem)"],
      "lg": ["clamp(1.25rem, 0.61vw + 1.1rem, 1.58rem)"],
      "xl": ["clamp(1.95rem, 1.56vw + 1.56rem, 2.81rem)"],
      "2xl": ["clamp(2.44rem, 2.38vw + 1.85rem, 3.75rem)"],
      "3xl": ["clamp(3.05rem, 3.54vw + 2.17rem, 5rem"],
      "4xl": ["clamp(3.81rem, 5.18vw + 2.52rem, 6.66rem)"],
      "5xl": ["clamp(4.77rem, 7.48vw + 2.9rem, 8.88rem)"],
      "6xl": ["clamp(5.96rem, 10.69vw + 3.29rem, 11.84rem)"],
      "7xl": ["clamp(7.45rem, 15.14vw + 3.66rem, 15.78rem)"],
    },
    
    extend: {
      
      fontFamily: {
        "poppins": ["Poppins", "sans-serif"]
      },
      colors: {
        "primary": {
          50: "#fff4eb",
          100: "#ffead6",
          200: "#ffcea8",
          300: "#ffac70",
          400: "#ff8c4e", // figma: light orange
          500: "#fe5f33", // figma: dark orange
          600: "#df3d07",
          700: "#bf2a08",
          800: "#91210d",
          900: "#631a0d",
          950: "#420d06",
        },
        "secondary": "#eeeef6",
        "off-white": "#f9f9f9",
        "off-black": "#5b5b5b",
        "light-blue": "#d4f0f1",
        "darker-blue": "#55cbcd",
        "light-grey": "#c6c6ce",
        "yellow": "#fccb46",
        "error": "#ff0000",
        "rgba-grey": "rgba(91, 91, 91, 0.7)",
      },
      dropShadow: {
        "card": "0px 8px 24px rgba(0, 0, 0, 0.04)",
      },
      maxWidth: {
        "8xl": "1440px",
      },
      backgroundSize: {
        "x-full": "100% auto",
        "y-full": "auto 100%",
        "x-200": "200% auto",
        "y-200": "auto 200%",
        "stretch": "100% 100%"
      },
      backgroundImage: {
        "wave-pattern": "url('/img/bg-vector-wave.svg')",
        "ad-frontpage": "url('/img/front-page-add.svg')",
      },
      gridTemplateColumns: {
        "orders-grid": "1fr 4fr 4fr 4fr 4fr",
        "orders-grid-mobile": "1fr 4fr 4fr 4fr",
        "users-grid": "2rem 2rem 5fr 1fr 6rem",
      },
    },
  },
  plugins: [],
}

