<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'

  const helikia = ref ( null as null | { id: number, title: string, data: Map< string, any > } )

  const options = new Map()
  options.set( 'content.rendered', true )
  Promise.all( [
      constants.function.fetchPost( import.meta.env.VITE_WP_REST_URL, 'pages', constants.page.helikia, options ),
      constants.function.fetchPost( import.meta.env.VITE_WP_REST_URL, 'posts', constants.page.helikia, options )
    ] ).then( results => results.filter( result => result ).forEach( result => helikia.value = result ) )
</script>

<template>
  <section class="snrg-helikia">
      <header>
      <h1 v-if="helikia" v-html="helikia.title"></h1>
      <h1 v-else>Helikia</h1>
    </header>
    <div v-if="helikia && helikia.data.get( 'content.rendered' )" v-html="helikia.data.get( 'content.rendered' )"></div>
    <div v-else>
      <p>Parler d'Helikia.</p>
    </div>
  </section>
</template>

<style scoped>
</style>