<script setup lang="ts">
  import { ref } from 'vue'
  import { useRoute } from 'vue-router'
  import constants from '@/constants'

  const slug = useRoute().params.slug as string

  const post = ref( null as null | { id: number, title: string, data: Map< string, any > } )

  const options = new Map()
  options.set( 'content.rendered', true )
  constants.function.fetchPost( import.meta.env.VITE_WP_REST_URL, 'posts', slug, options )
      .then( result => post.value = result ? result : post.value )
</script>

<template>
  <section v-if="post" class="snrg-post">
    <header>
      <h1 v-html="post.title"></h1>
    </header>
    <div v-if="post.data.get( 'content.rendered' )" v-html="post.data.get( 'content.rendered' )"></div>
  </section>
</template>

<style scoped>
</style>
