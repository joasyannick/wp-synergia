<script setup lang="ts">
  import { ref } from 'vue'
  const maxCount = 3
  const mustSees = ref( [] as any[] )
  const dataReady = ref( false )

  const fetchMustSee = async () => {
      try {
        const response = await fetch( import.meta.env.VITE_WP_REST_URL + 'wp/v2/snrg-must-sees?per_page=' + maxCount + '&_fields=title.rendered,content.rendered' )
        mustSees.value = await response.json()
        mustSees.value.forEach( ( mustSee ) => mustSee.content.rendered = mustSee.content.rendered.replace( /(<\/?)h(\d+)/g, ( match: string, token: string, level: string ) => token + 'h' + ( parseInt( level ) + 1 ) ) )
        dataReady.value = true
      } catch ( exception ) {
        console.error( 'Failed to fetch must-see' )
        dataReady.value = false
      }
      return dataReady.value
    }

    fetchMustSee()
</script>

<template>
  <nav class="snrg-must-see">
    <article v-for="mustSee in mustSees">
      <header>
        <h2 v-html="mustSee.title.rendered"></h2>
      </header>
      <div v-html="mustSee.content.rendered"></div>
    </article>
  </nav>
</template>

<style scoped>
  nav.snrg-must-see {
      position: relative;
      min-height: 100vh;
      background-color: hsl(225,70%,10%);
    }

  nav.snrg-must-see > article > header > h2 {
      margin-top: 0;
    }
</style>