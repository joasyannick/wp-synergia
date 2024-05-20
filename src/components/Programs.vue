<script setup lang="ts">
  import { ref } from 'vue'
  const maxCount = 3
  const programs = ref( [] as any[] )
  const dataReady = ref( false )

  const fetchPrograms = async () => {
      try {
        const response = await fetch( import.meta.env.VITE_WP_REST_URL + 'wp/v2/snrg-programs?per_page=' + maxCount + '&_fields=title.rendered,content.rendered' )
        programs.value = await response.json()
        programs.value.forEach( ( program ) => program.content.rendered = program.content.rendered.replace( /(<\/?)h(\d+)/g, ( match: string, token: string, level: string ) => token + 'h' + ( parseInt( level ) + 1 ) ) )
        dataReady.value = true
      } catch ( exception ) {
        console.error( 'Failed to fetch must-see' )
        dataReady.value = false
      }
      return dataReady.value
    }

  fetchPrograms()
</script>

<template>
  <nav class="snrg-programs">
    <header>
      <h1>Nos programmes</h1>
    </header>
    <article v-for="program in programs" :key="program.id">
      <header>
        <h2 v-html="program.title.rendered"></h2>
      </header>
      <div v-html="program.content.rendered"></div>
    </article>
  </nav>
</template>

<style scoped>
  nav.snrg-programs {
      position: relative;
      min-height: 100vh;
      background: hsl( var( --snrg-background-hue ), var( --snrg-background-saturation ), var( --snrg-background-lightness ) );
    }

  nav.snrg-programs > header > h1 {
      margin: 0;
    }
</style>