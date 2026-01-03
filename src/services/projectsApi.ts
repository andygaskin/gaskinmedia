export type ProjectItem = {
  id: number
  title: string
  summary: string
  description: string
  news_date: string
  image_url: string
  project_url: string
  featured: number
  sort_order: number
}

export async function fetchProjects(): Promise<ProjectItem[]> {
  const res = await fetch('/api/projects.php')
  // const res = await fetch('/mockProjects.json')

  if (!res.ok) {
    throw new Error('Failed to load data')
  }

  const data = await res.json()

  if (!Array.isArray(data)) {
    return []
  }

  return data as ProjectItem[]
}
