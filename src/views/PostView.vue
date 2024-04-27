<script setup lang="ts">
  import { ref } from 'vue'
  import { useRoute } from 'vue-router'

  const slug = useRoute().params.slug

  const dataReady = ref( false )
  const post = ref( undefined as any )
  
  const fetchPost = async () => {
      try {
        const request = import.meta.env.VITE_WP_REST_URL + 'wp/v2/posts?slug=' + slug + '&_fields=title.rendered,content.rendered'
        const response = await fetch( request )
        const posts = await response.json()
        post.value = posts[ 0 ]
        dataReady.value = true
      } catch ( exception ) {
        console.error( 'Failed to fetch the post' )
        dataReady.value = false
      }
      return dataReady.value
    }
  
  fetchPost()
</script>

<template>
  <section v-if="dataReady" class="snrg-post">
    <header v-if="post.title.rendered">
      <h2>{{ post.title.rendered }}</h2>
    </header>
    <div v-if="post.content.rendered" v-html="post.content.rendered"></div>
  </section>
</template>

<style scoped>
</style>
