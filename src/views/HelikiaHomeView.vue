<script setup lang="ts">
  import { ref } from 'vue'
  import { HELIKIA_PAGE, WP_CONTENT_RENDERED, WP_PAGES } from '@/constants'
  import { fetchPost } from '@/wordpress'

  const helikia = ref ( null as null | { id: number, title: string, data: Map< string, any > } )

  const options = new Map()
  options.set( WP_CONTENT_RENDERED, true )
  fetchPost( import.meta.env.VITE_WP_REST_URL, WP_PAGES, HELIKIA_PAGE, options )
      .then( result => helikia.value = result )
</script>

<template>
  <article class="snrg-helikia">
      <header>
      <h1 v-if="helikia" v-html="helikia.title"></h1>
      <h1 v-else>Helikia</h1>
    </header>
    <div v-if="helikia && helikia.data.get( WP_CONTENT_RENDERED )" v-html="helikia.data.get( WP_CONTENT_RENDERED )"></div>
    <div v-else>
      <p>Parler d'Helikia.</p>
    </div>
  </article>
</template>

<style scoped>
</style>