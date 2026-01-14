import Aura from "@primeuix/themes/aura";
export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  devtools: { enabled: true },
  modules: ["@primevue/nuxt-module"],
  primevue: {
    options: {
      // ripple: true,

      theme: {
        preset: Aura,
        options: {
          darkModeSelector: false || "none",
        },
      },
    },
  },
  app: {
    head: {
      htmlAttrs: {
        lang: "en",
      },
    },
  },
  css: ["primeicons/primeicons.css", "@/assets/css/main.css"],
});
