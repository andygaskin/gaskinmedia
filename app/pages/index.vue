<script setup lang="ts">
import type { ProjectItem } from "@/services/projectsApi";
import { fetchProjects } from "@/services/projectsApi";

useHead({
  title: "Gaskin Media - Andy Gaskin",
  meta: [
    {
      name: "description",
      content:
        "Portfolio of Andy Gaskin, Software Engineer - frontend UI/UX strategy and Product Design.",
    },
  ],
});

const route = useRoute();
const showVideo = computed(
  () => route.path === "/conversation" || route.path === "/conversation/",
);

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

// runs for every image when the component mounts
const checkImageCache = (el: any, id: number) => {
  if (el && el.complete) {
    markLoaded(id);
  }
};

const op = ref();
const isDefinitionOpen = ref(false);

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
        <strong>Senior Frontend Engineer / UX Strategist</strong> with 20 years
        of experience building and modernizing complex web applications. I bring
        a design-minded engineering perspective to product strategy, translating
        complex systems into clear, polished, and maintainable user experiences.
        A dedicated practitioner of the
        <button
          type="button"
          class="definition"
          aria-haspopup="dialog"
          aria-controls="definition-popover"
          :aria-expanded="isDefinitionOpen"
          @click="togglePopOver"
        >
          Don't Make Me Think
        </button>
        philosophy, I help teams set a high bar for modern applications that are
        practical to develop, easy to use, and built to last.
      </p>

      <ul class="socials">
        <li>
          <a
            href="https://vimeo.com/263925614"
            target="_blank"
            rel="noopener noreferrer"
            ><i class="pi pi-video" aria-hidden="true" /><span
              >Video Production<span class="sr-only">
                (opens in a new tab)</span
              ></span
            ></a
          >
        </li>
        <li>
          <a
            href="https://www.instagram.com/andygaskin/"
            target="_blank"
            rel="noopener noreferrer"
            ><i class="pi pi-instagram" aria-hidden="true" /><span
              >Photography<span class="sr-only">
                (opens in a new tab)</span
              ></span
            ></a
          >
        </li>
        <li>
          <a
            href="https://soundcloud.com/after-space"
            target="_blank"
            rel="noopener noreferrer"
          >
            <i class="pi pi-volume-up" aria-hidden="true" /><span
              >Music Production<span class="sr-only">
                (opens in a new tab)</span
              ></span
            ></a
          >
        </li>
        <li>
          <a
            href="https://github.com/andygaskin"
            target="_blank"
            rel="noopener noreferrer"
          >
            <i class="pi pi-github" aria-hidden="true" /><span
              >GitHub<span class="sr-only"> (opens in a new tab)</span></span
            ></a
          >
        </li>
      </ul>
      <!--yay youtube-->
      <div v-if="showVideo" class="youtube_holder">
        <iframe
          class="the_video"
          width="560"
          height="315"
          src="https://www.youtube.com/embed/CRzV0LRu5CU?si=mM5hQToM1lPRTv5U&rel=0"
          title="Conversation with Andy Gaskin"
          frameborder="0"
          allow="
            accelerometer;
            autoplay;
            clipboard-write;
            encrypted-media;
            gyroscope;
            picture-in-picture;
            web-share;
          "
          referrerpolicy="strict-origin-when-cross-origin"
          allowfullscreen
        ></iframe>
      </div>
      <!--END youtube-->
      <div class="separator" />

      <section aria-labelledby="featured-projects-heading">
        <h2 id="featured-projects-heading" class="sr-only">
          Featured projects
        </h2>
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
                alt=""
              />
            </div>
            <div class="project_title">
              {{ project.title }}
            </div>
          </button>
        </div>
      </section>

      <!--END featured-->

      <section aria-labelledby="past-projects-heading">
        <h2 id="past-projects-heading" class="mobile_show">
          Notable Past Projects:
        </h2>

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
                alt=""
              />
            </div>
            <div class="project_title">{{ project.title }}</div>
          </button>
        </div>
      </section>
      <AppTestimonials />
    </div>
  </main>
  <Dialog
    v-model:visible="visible"
    modal
    dismissableMask
    :draggable="false"
    :header="activeProject?.title"
    :style="{ width: 'min(1100px, 92vw)' }"
  >
    <div class="project_detail">
      <div>
        <img
          :src="`/project-images/${activeProject?.image_url}`"
          :alt="`Main screenshot of ${activeProject?.title} project`"
        />

        <img
          v-if="activeProject?.id == 55"
          src="/project-images/ae2.webp"
          :alt="`Additional screenshot of ${activeProject?.title} project`"
        /><img
          v-if="activeProject?.id == 32"
          src="/project-images/fap2.webp"
          :alt="`Additional screenshot of ${activeProject?.title} project`"
        />
      </div>
      <div class="body_text">
        <div class="project_summary">{{ activeProject?.summary }}</div>

        <div v-html="activeProject?.description"></div>

        <div v-if="activeProject?.project_url" class="project_link">
          <a
            :href="`https://${activeProject.project_url}`"
            target="_blank"
            rel="noopener noreferrer"
            >{{ activeProject.project_url }}<span class="sr-only">
              (opens in a new tab)</span
            ></a
          >&nbsp;
          <i
            class="pi pi-external-link"
            aria-hidden="true"
            style="font-size: 0.8rem"
          />
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
  <Popover
    id="definition-popover"
    ref="op"
    class="definition_panel"
    @show="isDefinitionOpen = true"
    @hide="isDefinitionOpen = false"
  >
    <div class="definition_content">
      <div class="image_holder">
        <img
          src="/krug.webp"
          alt="Cover of Don't Make Me Think by Steve Krug"
        />
      </div>
      <div class="body_text">
        Yes, this is a Steve Krug reference. It's been ages since I've read his
        book (parts of which I'm sure are painfully out of date by now), but his
        user-centric principles continue to stick with me. Still highly
        recommended for anyone interested in UX or thoughtful software design.
      </div>
    </div>
  </Popover>
</template>
