<script setup lang="ts">
import { onMounted, ref, computed } from 'vue'
import type { ProjectItem } from '@/services/projectsApi'
import { fetchProjects } from '@/services/projectsApi'
import Testimonials from '@/components/AppTestimonials.vue'
import Dialog from 'primevue/dialog'
import Button from 'primevue/button'
import ScrollTop from 'primevue/scrolltop'

const projects = ref<ProjectItem[]>([])
const isLoading = ref(false)
const error = ref<string | null>(null)

onMounted(async () => {
  isLoading.value = true
  error.value = null

  try {
    projects.value = await fetchProjects()
  } catch (err) {
    error.value = 'Unable to load portfolio right now.'
    console.error(err)
  } finally {
    isLoading.value = false
  }
})

const featuredProjects = computed(() =>
  projects.value
    .filter((p) => Number(p.featured) === 1)
    .sort((a, b) => (a.sort_order ?? 100) - (b.sort_order ?? 100)),
)

const otherProjects = computed(() =>
  projects.value
    .filter((p) => Number(p.featured) !== 1)
    .sort((a, b) => (a.sort_order ?? 100) - (b.sort_order ?? 100)),
)

const visible = ref(false)
const selectedProjectId = ref<number | null>(null)

const toggleActiveProject = (id: number) => {
  // console.log(id)
  visible.value = !visible.value
  selectedProjectId.value = id
}
const activeProject = computed(() => {
  const currentProject = projects.value.find((p) => p.id === selectedProjectId.value)
  // console.log(currentProject)
  return currentProject ? currentProject : null
})
</script>

<template>
  <main>
    <ScrollTop icon="pi pi-arrow-up" />
    <div id="main_box" class="generic_text">
      <h1>Andy Gaskin</h1>
      <div class="email"><a href="mailto:andy@andygaskin.com">andy@andygaskin.com</a></div>
    </div>
    <div class="page_wrapper">
      <p class="body_text professional_summary">
        <strong>Senior Frontend Engineer</strong> with 15+ years of experience designing and
        building user-facing web platforms at scale. I lead product direction and front-end
        architecture, delivering responsive, accessible, maintainable systems for statewide and
        national audiences. My background in visual design and UI/UX shapes how I engineer
        software-- pragmatic and aware, translating complex requirements into clear, intuitive
        applications that don't make the user have to <em>think</em> -- all while balancing the
        bottom-line of real-world business constraints.
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
          class="block_holder featured"
          v-for="project in featuredProjects"
          :key="project.id"
          href="#"
          @click="toggleActiveProject(project.id)"
        >
          <div
            loading="lazy"
            class="the_image"
            :style="{ backgroundImage: `url('/project-images/${project.image_url}')` }"
          ></div>
          <div class="project_title">{{ project.title }}</div>
        </button>
      </div>

      <!--END featured-->

      <div class="keep_em_seperated" />
      <h2 class="mobile_show">Notable Past Projects:</h2>

      <div class="main_card_holder">
        <button
          @click="toggleActiveProject(project.id)"
          v-for="project in otherProjects"
          :key="project.id"
          class="block_holder"
        >
          <div
            loading="lazy"
            class="the_image"
            :style="{ backgroundImage: `url('/project-images/${project.image_url}')` }"
          ></div>
          <div class="project_title">{{ project.title }}</div>
        </button>
      </div>
      <Testimonials />
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
    >
      <Button type="button" label="Close" class="close_button" @click="visible = false"></Button>
    </div>
  </Dialog>
</template>
