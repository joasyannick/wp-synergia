<script setup lang="ts">
  import { ref } from 'vue'
  import { BIOGRAPHY_PAGE, WP_CONTENT_RENDERED, WP_PAGES } from '@/constants'
  import { fetchPost } from '@/wordpress'

  const biography = ref ( null as null | { id: number, title: string, data: Map< string, any > } )

  const options = new Map()
  options.set( WP_CONTENT_RENDERED, true )
  fetchPost( import.meta.env.VITE_WP_REST_URL, WP_PAGES, BIOGRAPHY_PAGE, options )
      .then( result => biography.value = result )
</script>

<template>
  <article class="snrg-biography">
    <header>
      <h1 v-if="biography" v-html="biography.title"></h1>
      <h1 v-else>Biographie</h1>
    </header>
    <div v-if="biography && biography.data.get( WP_CONTENT_RENDERED )" v-html="biography.data.get( WP_CONTENT_RENDERED )"></div>
    <div v-else>
      <p>Raconter son histoire.</p>
    </div>
  </article>
</template>

<style scoped>
</style>
