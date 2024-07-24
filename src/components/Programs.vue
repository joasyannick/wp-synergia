<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'

  const programs = ref( [] as { id: number, slug: string, title: string, data: Map< string, any > }[] )

  const options = new Map()
  options.set( 'content.rendered', true )
  constants.function.fetchAllPosts( import.meta.env.VITE_WP_REST_URL, 'snrg-programs', options ).then( results => programs.value = results )
</script>

<template>
  <nav class="snrg-programs">
    <header>
      <h1>Nos programmes</h1>
    </header>
    <article v-if="programs.length" v-for="program in programs" :key="program.id">
      <header>
        <h2 v-html="program.title"></h2>
      </header>
      <div v-if="program.data.get( 'content.rendered' )" v-html="program.data.get( 'content.rendered' )"></div>
    </article>
    <article v-else>
      <p>Pas de programme pour le moment.</p>
    </article>
  </nav>
</template>

<style scoped>
  nav.snrg-programs {
    position: relative;
    margin-left: calc(-1 * var(--snrg-padding));
    box-sizing: border-box;
    width: 100vw;
    min-height: 100vh;
    background: hsl(var(--SNRG-BACKGROUND-HUE), var(--SNRG-BACKGROUND-SATURATION), var(--snrg-background-lightness));
    padding-left: inherit;
    padding-right: inherit;
  }

  nav.snrg-programs > header > h1 {
    margin: 0;
  }
</style>