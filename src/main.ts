import { createApp } from 'vue'
import { createPinia } from 'pinia'
import 'leaflet' // Patch, should be able to remove it...
import App from '@/App.vue'
import router from '@/router'

const app = createApp( App )
app.use( createPinia() )
app.use( router )
const dataElement = document.getElementById( 'snrg-data' )
if ( dataElement ) {
  router.push( JSON.parse( dataElement.textContent! ).route )
}
app.mount( '#snrg-vue' )