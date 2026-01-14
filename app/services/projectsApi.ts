export type ProjectItem = {
  id: number;
  title: string;
  summary: string;
  description: string;
  image_url: string;
  project_url: string | null;
  featured: number;
  sort_order: number;
  slug: string | null;
  active: number;
  created: string;
  updated: string;
};

import projectsMock from "@/mock/mockProjects.json";

export async function fetchProjects(): Promise<ProjectItem[]> {
  if (import.meta.dev) {
    return projectsMock as ProjectItem[];
  }

  return await $fetch<ProjectItem[]>(
    "https://gaskinmedia.com/api/projects.php",
  );
}
