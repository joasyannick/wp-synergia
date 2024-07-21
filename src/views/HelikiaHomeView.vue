<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'

  const helikia = ref ( { id: -1, title: 'Helikia', excerpt: '', content: "<p>Parler d'Helikia.</p>" } )
  Promise.all( [ constants.function.fetchPost( import.meta.env.VITE_WP_REST_URL, 'pages', constants.route.helikia.name, false, true, helikia.value ), constants.function.fetchPost( import.meta.env.VITE_WP_REST_URL, 'posts', constants.route.helikia.name, false, true, helikia.value ) ] )
      .then( results => results.filter( result => result.id !== -1 ).forEach( result => helikia.value = result ) )
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