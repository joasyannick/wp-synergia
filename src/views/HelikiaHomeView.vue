<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'

  const helikia = ref ( { id: -1, title: 'Helikia', excerpt: '', content: "<p>Parler d'Helikia.</p>" } )
  const posts = await Promise.all( [ constants.function.fetchPost( 'pages', constants.route.helikia.name, false, true, helikia.value ), constants.function.fetchPost( 'posts', constants.route.helikia.name, false, true, helikia.value ) ] )
  posts.filter( post => post.id !== -1 ).forEach( post => helikia.value = post )
</script>

<template>
    <section class="snrg-helikia">
      <header>
        <h2 v-html="helikia.title"></h2>
      </header>
      <div v-html="helikia.content">
      </div>
  </section>
</template>

<style scoped>
</style>