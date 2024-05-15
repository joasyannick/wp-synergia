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
      <h1>Et si on passait de croyant à vivant&nbsp;?</h1>
    </header>
    <div>
      <p>J'ai fait la transition&nbsp;: j'ai trouvé et arpenté ce chemin resserré qui mène à la vie. Laissez-moi vous aider à y marcher.</p>
      <article v-for="program in programs">
      <header>
        <h2 v-html="program.title.rendered"></h2>
      </header>
      <div v-html="program.content.rendered"></div>
    </article>
    </div>
  </nav>
</template>

<style scoped>
  nav.snrg-programs {
      position: relative;
      margin-top: -10vh;
    }

  nav.snrg-programs > header {
      min-height: 10vh;
    }

  nav.snrg-programs > header > h1 {
      margin: 0;
    }

  nav.snrg-programs > div {
      min-height: 100vh;
      background: hsl(225,70%,10%);
    }

  nav.snrg-programs > div > p:first-of-type {
      margin-top: 0;
    }
</style>