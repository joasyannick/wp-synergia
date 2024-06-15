<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'

  const biography = ref ( { id: -1, title: 'Biographie', excerpt: '', content: '<p>Raconter son histoire.</p>' } )
  Promise.all( [ constants.function.fetchPost( 'pages', constants.route.paddy.biography.name, false, true, biography.value ), constants.function.fetchPost( 'posts', constants.route.paddy.biography.name, false, true, biography.value ) ] )
      .then( results => results.filter( result => result.id !== -1 ).forEach( result => biography.value = result ) )
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
