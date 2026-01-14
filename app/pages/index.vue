<script setup lang="ts">
import type { ProjectItem } from "@/services/projectsApi";
import { fetchProjects } from "@/services/projectsApi";

useHead({
  title: "Gaskin Media - Andy Gaskin",
  meta: [
    {
      name: "description",
      content:
        "Portfolio of Andy Gaskin, Software Engineer - frontend UI/UX focus, specializing in Vue / Nuxt.",
    },
  ],
  //   link: [
  //     {
  //       rel: "preload",
  //       as: "image",
  //       href: "/project-images/ae.webp",
  //       fetchpriority: "high",
  //     },
  //     {
  //       rel: "preload",
  //       as: "image",
  //       href: "/project-images/ae2.webp",
  //       fetchpriority: "high",
  //     },
  //     {
  //       rel: "preload",
  //       as: "image",
  //       href: "/project-images/fap.webp",
  //       fetchpriority: "high",
  //     },
  //   ],
});

const {
  data: projects,
  pending: isLoading,
  error,
} = await useAsyncData<ProjectItem[]>("projects", () => fetchProjects(), {
  default: () => [],
});

const featuredProjects = computed(() =>
  projects.value
    .filter((p) => Number(p.featured) === 1)
    .sort((a, b) => Number(a.sort_order ?? 100) - Number(b.sort_order ?? 100)),
);

const otherProjects = computed(() =>
  projects.value
    .filter((p) => Number(p.featured) !== 1)
    .sort((a, b) => Number(a.sort_order ?? 100) - Number(b.sort_order ?? 100)),
);

const visible = ref(false);
const selectedProjectId = ref<number | null>(null);

const toggleActiveProject = (id: number) => {
  visible.value = !visible.value;
  selectedProjectId.value = id;
};

const activeProject = computed(() => {
  return projects.value.find((p) => p.id === selectedProjectId.value) ?? null;
});

// This reactive object will track which IDs are loaded
const loaded = reactive<Record<number, boolean>>({});

function markLoaded(id: number) {
  loaded[id] = true;
}

// This function runs for every image when the component mounts
const checkImageCache = (el: any, id: number) => {
  if (el && el.complete) {
    markLoaded(id);
  }
};

const op = ref();
function togglePopOver(event: Event) {
  op.value.toggle(event);
}
</script>
<template>
  <main>
    <ScrollTop icon="pi pi-arrow-up" />
    <div id="main_box" class="generic_text">
      <h1>Andy Gaskin</h1>
      <div class="email">
        <a href="mailto:andy@andygaskin.com">andy@andygaskin.com</a>
      </div>
    </div>
    <div class="page_wrapper">
      <p class="body_text professional_summary">
        <strong>Senior Frontend / UX Engineer</strong> with 15+ years of
        experience designing and building platforms from zero to scale. I lead
        product direction and front-end architecture, delivering responsive,
        accessible systems for statewide and national audiences. A background in
        visual design shapes how I engineer software-- pragmatic and aware,
        tastefully translating complex requirements into clear, intuitive
        applications that don't make the user
        <button @click="togglePopOver" class="definition">have to think</button
        >-- all while balancing the bottom-line of real-world business
        constraints. Full-stack capable (Nuxt/Vue, PHP, MySQL) with a passion
        for building maintainable, modern design systems.
      </p>
      <ul class="socials">
        <li>
          <a href="https://vimeo.com/263925614" target="_blank"
            ><i class="pi pi-video" /><span>Video Production</span></a
          >
        </li>
        <li>
          <a href="https://www.instagram.com/andygaskin/" target="_blank"
            ><i class="pi pi-instagram" /><span>Photography</span></a
          >
        </li>
        <li>
          <a href="https://soundcloud.com/after-space" target="_blank">
            <i class="pi pi-volume-up" /><span>Music Production</span></a
          >
        </li>
        <li>
          <a href="https://github.com/andygaskin" target="_blank">
            <i class="pi pi-github" /><span>GitHub</span></a
          >
        </li>
      </ul>
      <!-- <h2>Recent Highlights</h2> -->

      <div class="main_card_holder featured">
        <button
          @click="toggleActiveProject(project.id)"
          v-for="project in featuredProjects"
          :key="project.id"
          class="block_holder featured"
        >
          <div class="the_image">
            <img
              :src="`/project-images/${project.image_url}`"
              :class="{ 'is-loaded': loaded[project.id] }"
              @load="markLoaded(project.id)"
              :ref="(el) => checkImageCache(el, project.id)"
              loading="eager"
              fetchpriority="high"
              :alt="`${project.title}`"
            />
          </div>
          <div class="project_title">
            {{ project.title }}
          </div>
        </button>
      </div>

      <!--END featured-->

      <div class="separator" />
      <h2 class="mobile_show">Notable Past Projects:</h2>

      <div class="main_card_holder">
        <button
          @click="toggleActiveProject(project.id)"
          v-for="project in otherProjects"
          :key="project.id"
          class="block_holder tier2"
        >
          <div class="the_image">
            <img
              :src="`/project-images/${project.image_url}`"
              :class="{ 'is-loaded': loaded[project.id] }"
              @load="markLoaded(project.id)"
              :ref="(el) => checkImageCache(el, project.id)"
              loading="lazy"
              fetchpriority="low"
              decoding="async"
              :alt="`${project.title}`"
            />
          </div>
          <div class="project_title">{{ project.title }}</div>
        </button>
      </div>
      <AppTestimonials />
    </div>
  </main>
  <Dialog
    v-model:visible="visible"
    modal
    dismissableMask
    :draggable="false"
    :header="activeProject?.title"
    :style="{ width: 'min(900px, 92vw)' }"
  >
    <div class="project_detail">
      <div>
        <img
          :src="`/project-images/${activeProject?.image_url}`"
          :alt="`Screenshot of ${activeProject?.title} project`"
        />

        <img
          v-if="activeProject?.id == 55"
          src="/project-images/ae2.webp"
          :alt="`Screenshot of ${activeProject?.title} project`"
        /><img
          v-if="activeProject?.id == 32"
          src="/project-images/fap2.webp"
          :alt="`Screenshot of ${activeProject?.title} project`"
        />
      </div>
      <div class="body_text">
        <div class="project_summary">{{ activeProject?.summary }}</div>

        <div v-html="activeProject?.description"></div>

        <div v-if="activeProject?.project_url" class="project_link">
          <a :href="`https://${activeProject.project_url}`" target="_blank">{{
            activeProject.project_url
          }}</a
          >&nbsp; <i class="pi pi-external-link" style="font-size: 0.8rem" />
        </div>
      </div>
    </div>

    <div
      class="flex justify-end gap-2"
      style="display: flex; justify-content: right; padding-top: 5px"
    ></div>
    <template #footer
      ><Button
        type="button"
        label="Close"
        class="close_button"
        @click="visible = false"
      ></Button
    ></template>
  </Dialog>
  <Popover ref="op" class="definition_panel"
    ><div class="project_detail">
      <div class="image_holder">
        <img src="/krug.webp" />
      </div>
      <div class="body_text">
        Yes, this is a Steve Krug reference. It's been ages since I've read his
        book (parts of which I'm sure are woefully out of date by now), but his
        user-centric principles contnue to stick with me. Still highly
        recommended for anyone interested in UX or thoughtful software design.
      </div>
    </div></Popover
  >
</template>
>
