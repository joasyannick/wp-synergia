<script setup lang="ts">
  import { ref } from 'vue'
  import { useRoute } from 'vue-router'
  import { WP_CONTENT_RENDERED, WP_POSTS } from '@/constants'
  import { fetchPost } from '@/wordpress'

  const slug = useRoute().params.slug as string

  const post = ref( null as null | { id: number, title: string, data: Map< string, any > } )

  const options = new Map()
  options.set( WP_CONTENT_RENDERED, true )
  fetchPost( import.meta.env.VITE_WP_REST_URL, WP_POSTS, slug, options )
      .then( result => post.value = result )
</script>

<template>
  <article v-if="post" class="snrg-post">
    <header>
      <h1 v-html="post.title"></h1>
    </header>
    <div v-if="post.data.get( WP_CONTENT_RENDERED )" v-html="post.data.get( WP_CONTENT_RENDERED )"></div>
  </article>
</template>

<style scoped>
</style>
