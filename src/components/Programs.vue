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
    <div>
      <article v-if="programs.length" v-for="program in programs" :key="program.id">
        <header>
          <h2 v-html="program.title"></h2>
        </header>
        <div v-if="program.data.get( 'content.rendered' )" v-html="program.data.get( 'content.rendered' )"></div>
      </article>
      <article v-else>
        <p>Pas de programme pour le moment.</p>
      </article>
    </div>
  </nav>
</template>

<style scoped>
  nav.snrg-programs {
    position: relative;
    min-height: 100vh;
    background-color: hsl(var(--SNRG-BACKGROUND-HUE), var(--SNRG-BACKGROUND-SATURATION), var(--snrg-background-lightness));
    padding-top: 2rem;
    padding-left: calc(var(--snrg-outer-margin) + var(--snrg-middle-content-margin));
    padding-right: calc(var(--snrg-outer-margin) + var(--snrg-middle-content-margin));
  }

  nav.snrg-programs > header > h1 {
    margin: 0;
  }

  nav.snrg-programs > div {
    margin-left: calc(var(--snrg-middle-content-margin));
    margin-right: calc(var(--snrg-middle-content-margin));
  }
</style>