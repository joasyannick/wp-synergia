<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'
  import Main from '@/components/Main.vue'

  const error = ref ( null as null | { id: number, title: string, data: Map< string, any > } )

  const options = new Map()
  options.set( 'content.rendered', true )
  Promise.all( [
      constants.function.fetchPost( import.meta.env.VITE_WP_REST_URL, 'pages', constants.page.error, options ),
      constants.function.fetchPost( import.meta.env.VITE_WP_REST_URL, 'posts', constants.page.error, options )
    ] ).then( results => results.filter( result => result ).forEach( result => error.value = result ) )
</script>

<template>
  <Main class="snrg-404">
    <article class="snrg-404">
      <header>
        <h1 v-if="error" v-html="error.title"></h1>
        <h1 v-else>Page introuvable</h1>
      </header>
      <div v-if="error && error.data.get( 'content.rendered' )" v-html="error.data.get( 'content.rendered' )"></div>
      <div v-else>
        <p>La page recherchée n'existe pas.</p>
      </div>
    </article>
  </Main>
</template>

<style scoped>
</style>