import { createRouter, createWebHistory } from 'vue-router'
import AcceuilView from '../views/AcceuilView.vue'
import AnnoncesView from '../views/AnnoncesView.vue'
import VehiculeView from '../views/VehiculeView.vue'
import ErrorView from '../views/ErrorView.vue'
import ReparationView from "../views/ReparationView.vue"
import ContactView from "../views/ContactView.vue"
import ConnexionView from "../views/connexionView.vue"
import DashboardView from "../views/dashboardView.vue"
import MessagesView from "../views/children/messageView.vue"
import UserView from "../views/children/userView.vue"
import SettingView from "../views/children/settingView.vue"
import carView from "../views/children/carView.vue"

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
          path: 'messages',
          component: MessagesView,
        },
        {
          path: 'utilisateurs',
          component: UserView,
        },
        {
          path: 'parametre',
          component: SettingView,
        },
        {
          path: 'vehicule/:id',
          component: carView,
        },
      ]
    }
  ],
})

export default router
