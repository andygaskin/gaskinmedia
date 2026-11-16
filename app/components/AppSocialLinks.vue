<script setup lang="ts">
const socialLinks = [
  {
    label: "Video Production",
    href: "https://vimeo.com/263925614",
    icon: "pi-video",
  },
  {
    label: "Photography",
    href: "https://www.instagram.com/andygaskin/",
    icon: "pi-instagram",
  },
  {
    label: "Music Production",
    href: "https://soundcloud.com/after-space",
    icon: "pi-volume-up",
  },
  { label: "GitHub", href: "https://github.com/andygaskin", icon: "pi-github" },
];
</script>

<template>
  <ul class="socials">
    <li v-for="link in socialLinks" :key="link.href">
      <a :href="link.href" target="_blank" rel="noopener noreferrer">
        <i :class="['pi', link.icon]" aria-hidden="true" />
        <span>{{ link.label }}<span class="sr-only"> (opens in a new tab)</span></span>
      </a>
    </li>
  </ul>
</template>

<style scoped>
.socials {
  list-style: none;
  display: flex;
  margin: 0;
  padding: 0;

  /* margin-bottom: 30px; */
  align-content: center;
  justify-content: center;
  gap: 10px;
  font-size: 0.8rem;
  transition: all 0.2s;
  text-align: center;

  margin-top: 21px;

  @media (width<600px) {
    width: 80%;
    margin: 0 auto;
    margin-top: 20px;
  }

  @media (width<370px) {
    flex-direction: column;
    gap: 0;
  }
  /* & li {
    display: block;
    opacity: 0;
    transform: translateY(10px);
    animation: rise_up 1000ms ease forwards;
    animation-delay: calc(sibling-index() * 0.2s);
  } */
  & a {
    color: #993199;
    padding: 7px;
    border-radius: 5px;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    flex-direction: row;

    gap: 9px;
    border: 1px solid #e7e7e7;
    border-top: 1px solid #f8f8f8;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    transition: all 0.3s;
    height: 100%;
    &:hover {
      color: purple;
      border: rgb(224, 220, 233) 1px solid;
    }

    &:hover span {
      text-decoration: underline;
    }

    &:active {
      opacity: 0.8;
    }

    @media (width<600px) {
      gap: 5px;
      justify-content: center;
    }
  }
}

.socials a:focus-visible {
  outline: 3px solid #1b2a67;
  outline-offset: 4px;
}
</style>