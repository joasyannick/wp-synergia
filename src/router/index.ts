import { createRouter, createWebHistory } from 'vue-router'
import constants from '@/constants'
import PaddyView from '@/views/PaddyView.vue'
import PaddyHomeView from '@/views/PaddyHomeView.vue'
import BiographyView from '@/views/BiographyView.vue'
import HelikiaView from '@/views/HelikiaView.vue'
import HelikiaHomeView from '@/views/HelikiaHomeView.vue'
import ModuleView from '@/views/ModuleView.vue'
import SynergiaView from '@/views/SynergiaView.vue'
import PostView from '@/views/PostView.vue'
import AccountView from '@/views/AccountView.vue'
import ErrorView from '@/views/ErrorView.vue'

const router = createRouter( {
    history: createWebHistory( import.meta.env.BASE_URL ),
    routes: [
        {
            path: constants.route.paddy.path,
            component: PaddyView,
            children: [
                {
                    path: '',
                    name: constants.route.paddy.name,
                    component: PaddyHomeView
                  },
                {
                    path: constants.route.paddy.biography.path,
                    name: constants.route.paddy.biography.name,
                    component: BiographyView
                  },
                {
                    path: constants.route.paddy.post.path,
                    name: constants.route.paddy.post.name,
                    component: PostView
                  }
              ]
          },
        {
            path: constants.route.helikia.path,
            component: HelikiaView,
            children: [
                {
                    path: '',
                    name: constants.route.helikia.name,
                    component: HelikiaHomeView
                  },
                {
                    path: constants.route.helikia.synergia.path,
                    name: constants.route.helikia.synergia.name,
                    component: SynergiaView
                  },
                {
                    path: constants.route.helikia.module.path,
                    name: constants.route.helikia.module.name,
                    component: ModuleView
                  }
              ]
          },
        {
            path: constants.route.account.path,
            name: constants.route.account.name,
            component: AccountView
          },
        {
            path: constants.route.error.path,
            name: constants.route.error.name,
            component: ErrorView
          }
      ]
  } )

export default router