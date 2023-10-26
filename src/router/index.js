import { createRouter, createWebHistory } from 'vue-router'
import AcceuilView from '../views/AcceuilView.vue'
import AnnoncesView from '../views/AnnoncesView.vue'
import VehiculeView from '../views/VehiculeView.vue'
import ErrorView from '../views/ErrorView.vue'
import ReparationView from "../views/ReparationView.vue"
import ContactView from "../views/ContactView.vue"

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
    },
    {
      path: '/reparations',
      name: 'reparations',
      component: ReparationView
    },
    {
      path: '/contact/:id',
      name: 'contact',
      component: ContactView
    }
  ]
})

export default router
