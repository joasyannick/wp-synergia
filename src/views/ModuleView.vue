<script setup lang="ts">
  import { ref } from 'vue'
  import { useRoute } from 'vue-router'
  import { WP_CONTENT_RENDERED, WP_MODULES } from '@/constants'
  import { fetchPost } from '@/wordpress'

  const slug = useRoute().params.slug as string

  const module = ref( null as null | { id: number, title: string, data: Map< string, any > } )

  const options = new Map()
  options.set( WP_CONTENT_RENDERED, true )
  fetchPost( import.meta.env.VITE_WP_REST_URL, WP_MODULES, slug, options )
      .then( result => module.value = result )
</script>
<template>
  <article v-if="module" class="snrg-module">
    <header>
      <h1 v-html="module.title"></h1>
    </header>
    <div v-if="module.data.get( WP_CONTENT_RENDERED )" v-html="module.data.get( WP_CONTENT_RENDERED )"></div>
  </article>
</template>
  
<style scoped>
</style>
  