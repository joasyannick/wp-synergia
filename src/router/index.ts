import { createRouter, createWebHistory } from 'vue-router'
import * as constants from '@/constants'
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
            path: constants.PADDY_PATH,
            component: PaddyView,
            children: [
                {
                    path: '',
                    name: constants.PADDY_ROUTE,
                    component: PaddyHomeView
                  },
                {
                    path: constants.BIOGRAPHY_PATH,
                    name: constants.BIOGRAPHY_ROUTE,
                    component: BiographyView
                  },
                {
                    path: constants.POST_PATH,
                    name: constants.POST_ROUTE,
                    component: PostView
                  }
              ]
          },
        {
            path: constants.HELIKIA_PATH,
            component: HelikiaView,
            children: [
                {
                    path: '',
                    name: constants.HELIKIA_ROUTE,
                    component: HelikiaHomeView
                  },
                {
                    path: constants.SYNERGIA_PATH,
                    name: constants.SYNERGIA_ROUTE,
                    component: SynergiaView
                  },
                {
                    path: constants.MODULE_PATH,
                    name: constants.MODULE_ROUTE,
                    component: ModuleView
                  }
              ]
          },
        {
            path: constants.ACCOUNT_PATH,
            name: constants.ACCOUNT_ROUTE,
            component: AccountView
          },
        {
            path: constants.ERROR_PATH,
            name: constants.ERROR_ROUTE,
            component: ErrorView
          }
      ]
  } )

export default router