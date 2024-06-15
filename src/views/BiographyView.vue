<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'

  const defaultBiography = { id: -1, title: 'Biographie', excerpt: '', content: '<p>Raconter son histoire.</p>' }
  const biography = ref ( defaultBiography )
  //biography.value = await constants.function.fetchPost( 'pages', constants.route.paddy.biography.name, false, true, defaultBiography )
  //const posts = await Promise.all( [ constants.function.fetchPost( 'pages', constants.route.paddy.biography.name, false, true, defaultBiography ), constants.function.fetchPost( 'posts', constants.route.paddy.biography.name, false, true, defaultBiography ) ] )
  //posts.filter( post => post.id !== -1 ).forEach( post => biography.value = post )
</script>

<template>
  <section class="snrg-biography">
    <header>
      <h2 v-html="biography.title"></h2>
    </header>
    <div v-html="biography.content">
    </div>
  </section>
</template>

<style scoped>
</style>
