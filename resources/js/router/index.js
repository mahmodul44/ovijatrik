import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import About from '../views/About.vue'
import Contact from '../views/Contact.vue'
import Gallery from '../views/Gallery.vue'
import Volunteer from '../views/Volunteer.vue'
import Project from '../views/Project.vue'
import Campaign from '../views/Campaign.vue'
import Blog from '../views/Blog.vue'
import ProjectDetails from '../views/ProjectDetails.vue';

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/about', name: 'About', component: About },
  { path: '/contact', name: 'Contact', component: Contact },
  { path: '/gallery', name: 'Gallery', component: Gallery },
  { path: '/volunteer', name: 'Volunteer', component: Volunteer },
  { path: '/campaign', name: 'Campaign', component: Campaign },
  { path: '/blog', name: 'Blog', component: Blog },
  { path: '/project', name: 'Project', component: Project },
  { path: '/project/:id', name: 'ProjectDetails', component: ProjectDetails, props: true }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
