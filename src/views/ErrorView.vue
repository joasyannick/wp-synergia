<script setup lang="ts">
  import { ref } from 'vue'
  import { ERROR_PAGE, WP_CONTENT_RENDERED, WP_PAGES } from '@/constants'
  import { fetchPost } from '@/wordpress'
  import Main from '@/components/Main.vue'

  const error = ref ( null as null | { id: number, title: string, data: Map< string, any > } )

  const options = new Map()
  options.set( WP_CONTENT_RENDERED, true )
  fetchPost( import.meta.env.VITE_WP_REST_URL, WP_PAGES, ERROR_PAGE, options )
      .then( result => error.value = result )
</script>

<template>
  <Main class="snrg-404">
    <article class="snrg-404">
      <header>
        <h1 v-if="error" v-html="error.title"></h1>
        <h1 v-else>Page introuvable</h1>
      </header>
      <div v-if="error && error.data.get( WP_CONTENT_RENDERED )" v-html="error.data.get( WP_CONTENT_RENDERED )"></div>
      <div v-else>
        <p>La page recherchée n'existe pas.</p>
      </div>
    </article>
  </Main>
</template>

<style scoped>
</style>