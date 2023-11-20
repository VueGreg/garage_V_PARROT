import { createRouter, createWebHistory } from 'vue-router'
import AcceuilView from '../views/AcceuilView.vue'
import AnnoncesView from '../views/AnnoncesView.vue'
import VehiculeView from '../views/VehiculeView.vue'
import ErrorView from '../views/ErrorView.vue'
import ReparationView from "../views/ReparationView.vue"
import ContactView from "../views/ContactView.vue"
import ConnexionView from "../views/connexionView.vue"
import DashboardView from "../views/dashboardView.vue"
import MessagesView from "../views/messageView.vue"
import UserView from "../views/userView.vue"
import SettingView from "../views/settingView.vue"
import carView from "../views/carView.vue"
import testimonyView from "../views/testimonyView.vue"

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
      name: 'erreur',
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
    },
    {
      path: '/connexion',
      name: 'connexion',
      component: ConnexionView
    },
    {
      path: '/dashboard',
      component: DashboardView,
      children: [
        {
          path: '/dashboard/messages',
          name: 'messages',
          component: MessagesView
        },
        {
          path: '/dashboard/utilisateurs',
          name: 'utilisateurs',
          component: UserView
        },
        {
          path: '/dashboard/parametre',
          name: 'parametre',
          component: SettingView
        },
        {
          path: '/dashboard/vehicule/:id',
          name: 'vehicule',
          component: carView
        },
        {
          path: '/dashboard/temoignage',
          name: 'temoignage',
          component: testimonyView
        },
      ]
    }
  ],
  scrollBehavior() {
    return {x: 0, y: 0}
}
})

export default router
