import { createApp } from 'vue'
import { createPinia } from 'pinia'
import 'leaflet' // Patch, should be able to remove it...
import App from './App.vue'
import router from './router'
import constants from '@/constants'

const route = document.getElementById( 'snrg-app' )!.dataset.snrgRoute
const app = createApp( App )
app.use( createPinia() )
app.use( router )
router.push( route ? route : constants.route.paddy.fullPath )
app.mount( '#snrg-app' )