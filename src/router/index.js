import { createRouter, createWebHistory } from 'vue-router'
import AcceuilView from '../views/AcceuilView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Acceuil',
      component: AcceuilView
    }
  ]
})

export default router
