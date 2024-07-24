<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'

  const biography = ref ( null as null | { id: number, title: string, data: Map< string, any > } )

  const options = new Map()
  options.set( 'content.rendered', true )
  Promise.all( [
      constants.function.fetchPost( import.meta.env.VITE_WP_REST_URL, 'pages', constants.page.biography, options ),
      constants.function.fetchPost( import.meta.env.VITE_WP_REST_URL, 'posts', constants.page.biography, options )
    ] ).then( results => results.filter( result => result ).forEach( result => biography.value = result ) )
</script>

<template>
  <section class="snrg-biography">
    <header>
      <h1 v-if="biography" v-html="biography.title"></h1>
      <h1 v-else>Biographie</h1>
    </header>
    <div v-if="biography && biography.data.get( 'content.rendered' )" v-html="biography.data.get( 'content.rendered' )"></div>
    <div v-else>
      <p>>Raconter son histoire.</p>
    </div>
  </section>
</template>

<style scoped>
</style>
