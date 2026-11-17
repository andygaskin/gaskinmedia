<script setup lang="ts">
const year = new Date().getFullYear();
</script>

<template>
  <div class="separator footer-separator"></div>
  <footer class="site-footer search-layout-background">
    <div class="page_wrapper">
      <h3 class="footer-thanks">
        Thanks!
        <i class="pi pi-star-fill pi-spin" aria-hidden="true" />
      </h3>
      <a class="footer-email" href="mailto:andy@andygaskin.com">
        andy@andygaskin.com
      </a>
      <nav aria-label="Footer social links">
        <AppSocialLinks />
      </nav>
      <p class="footer-copyright">&copy; {{ year }} Andy Gaskin</p>
    </div>
  </footer>
</template>

<style scoped>
.footer-separator {
  transform: scaleY(-1);
}

.site-footer {
  background-color: rgb(27 42 103 / 3%);
  padding-top: 20px;
  padding-bottom: 50px;
  text-align: center;
  color: var(--general-text-color);
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

.site-footer h2 {
  font-size: clamp(1.4rem, 2.5vw, 2rem);
  text-wrap: balance;
}

.footer-thanks {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  font-size: 2rem;
  color: #1b2a67;
}

.footer-thanks .pi {
  color: #f5a623;
}

.site-footer a {
  color: #993199;
  text-underline-offset: 4px;
}

.site-footer a:hover {
  color: purple;
}

.site-footer a:focus-visible {
  outline: 3px solid #1b2a67;
  outline-offset: 4px;
  border-radius: 3px;
}

.footer-email {
  display: inline-block;
  margin-top: 12px;
  /* padding: 10px 0; */
  font-size: 1rem;
  /* font-weight: 600; */
  overflow-wrap: anywhere;
}

.footer-copyright {
  margin: 24px 0 0;
  font-size: 0.875rem;
}
</style>
