import { createRouter, createWebHistory } from 'vue-router'
import AcceuilView from '../views/AcceuilView.vue'
import AnnoncesView from '../views/AnnoncesView.vue'
import VehiculeView from '../views/VehiculeView.vue'
import ErrorView from '../views/ErrorView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Acceuil',
      component: AcceuilView
    },
    {
      path: '/annonces',
      name: 'Annonces',
      component: AnnoncesView
    },
    {
      path: '/annonces/:annonce',
      name: 'Vehicule',
      component: VehiculeView
    },
    {
      path: '/erreur',
      name: '404 not found',
      component: ErrorView
    }
  ]
})

export default router
