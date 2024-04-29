/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: ["class"],
  content: [
    "./pages/**/*.{ts,tsx}",
    "./components/**/*.{ts,tsx}",
    "./app/**/*.{ts,tsx}",
    "./src/**/*.{ts,tsx}",
  ],
  prefix: "",
  theme: {
    container: {
      center: true,
      padding: "2rem",
      screens: {
        "2xl": "1400px",
      },
    },
    extend: {
      fontFamily: {
        main: ["Inter", "sans-serif"],
        headline: ["Glory", "serif"],
      },
      backgroundImage: {
        g_base_gradient_0: "var(--g_base_gradient_0)",
        g_base_gradient_1: "var(--g_base_gradient_1)",
        g_grey_gradient: "var(--g_grey_gradient)",
        g_red_gradient: "var(--g_red_gradient)",
        g_green_gradient: "var(--g_green_gradient)",
        g_light_gradient: "var(--g_light_gradient)",
        g_light_gradient_inactive: "var(--g_white_gradient_inactive)",
        g_dark_gradient: "var(--g_dark_gradient)",
        g_planet_gradient: "var(--g_planet_gradient)",
      },
      colors: {
        border: "var(--border)",
        input: "var(--input)",
        ring: "var(--ring)",
        background: "var(--background)",
        foreground: "var(--foreground)",
        // Our colors
        g_background: "var(--g_background)",
        g_yellow: "var(--g_yellow)",
        g_light: "var(--g_light)",
        g_light_translucent: "var(--g_light_translucent)",
        g_dark: "var(--g_dark)",
        g_dark_translucent: "var(--g_dark_translucent)",
        g_cyan: "var(--g_cyan)",
        g_purple: "var(--g_purple)",
        g_brown: "var(--g_brown)",
        g_border: "var(--g_border)",

        primary: {
          DEFAULT: "var(--primary)",
          foreground: "var(--primary-foreground)",
        },
        secondary: {
          DEFAULT: "var(--secondary)",
          foreground: "var(--secondary-foreground)",
        },
        destructive: {
          DEFAULT: "var(--destructive)",
          foreground: "var(--destructive-foreground)",
        },
        muted: {
          DEFAULT: "var(--muted)",
          foreground: "var(--muted-foreground)",
        },
        accent: {
          DEFAULT: "var(--accent)",
          foreground: "var(--accent-foreground)",
        },
        popover: {
          DEFAULT: "var(--popover)",
          foreground: "var(--popover-foreground)",
        },
        card: {
          DEFAULT: "var(--card)",
          foreground: "var(--card-foreground)",
        },
      },
      borderRadius: {
        lg: "var(--radius)",
        md: "calc(var(--radius) - 2px)",
        sm: "calc(var(--radius) - 4px)",
      },
      keyframes: {
        "accordion-down": {
          from: { height: "0" },
          to: { height: "var(--radix-accordion-content-height)" },
        },
        "accordion-up": {
          from: { height: "var(--radix-accordion-content-height)" },
          to: { height: "0" },
        },
        "blur-in": {
          from: { filter: "brightness(0%) blur(15px)" },
          to: { filter: "brightness(100%) blur(0px)" },
        },
      },
      animation: {
        "accordion-down": "accordion-down 0.2s ease-out",
        "accordion-up": "accordion-up 0.2s ease-out",
        "blur-in": "blur-in .8s ease-in-out forwards",
      },
    },
  },
  plugins: [require("tailwindcss-animate")],
};
