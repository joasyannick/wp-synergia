import { createApp } from 'vue'
import { createPinia } from 'pinia'
import 'leaflet' // Patch, should be able to remove it...
import App from './App.vue'
import router from './router'

const route = document.getElementById( 'snrg-app' )!.dataset.snrgRoute!
const app = createApp( App )
app.use( createPinia() )
app.use( router )
router.push( route )
app.mount( '#snrg-app' )