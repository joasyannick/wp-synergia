<script setup lang="ts">
  import { ref } from 'vue'
  import { useRoute } from 'vue-router'
  import constants from '@/constants'

  const slug = useRoute().params.slug as string

  const module = ref( null as null | { id: number, title: string, data: Map< string, any > } )

  const options = new Map()
  options.set( 'content.rendered', true )
  constants.function.fetchPost( import.meta.env.VITE_WP_REST_URL, 'posts', slug, options )
      .then( result => module.value = result ? result : module.value )</script>
<template>
  <section v-if="module" class="snrg-module">
    <header>
      <h1 v-html="module.title"></h1>
    </header>
    <div v-if="module.data.get( 'content.rendered' )" v-html="module.data.get( 'content.rendered' )"></div>
  </section>
</template>
  
<style scoped>
</style>
  