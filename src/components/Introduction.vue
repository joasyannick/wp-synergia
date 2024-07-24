<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'

  const introduction = ref( null as null | { id: number, title: string, data: Map< string, any > } )

  const options = new Map()
  options.set( 'content.rendered', true )
  Promise.all( [
      constants.function.fetchPost( import.meta.env.VITE_WP_REST_URL, 'pages', constants.page.introduction, options ),
      constants.function.fetchPost( import.meta.env.VITE_WP_REST_URL, 'posts', constants.page.introduction, options )
    ] ).then( results => results.filter( result => result ).forEach( result => introduction.value = result ) )
</script>

<template>
  <article class="snrg-introduction">
    <header>
      <h1 v-if="introduction" v-html="introduction.title"></h1>
      <h1 v-else>Bienvenue</h1>
    </header>
    <div v-if="introduction && introduction.data.get( 'content.rendered' )" v-html="introduction.data.get( 'content.rendered' )"></div>
    <div v-else>
      <p>Présenter le site.</p>
    </div>
  </article>
</template>

<style scoped>
  article.snrg-introduction {
    position: relative;
    margin-left: calc(-1 * var(--snrg-padding));
    margin-top: -10vh;
    box-sizing: border-box;
    width: 100vw;
    background: hsl( var( --SNRG-BACKGROUND-HUE ), var( --SNRG-BACKGROUND-SATURATION ), var( --snrg-background-lightness ) );
    padding-left: inherit;
    padding-right: inherit;
  }
  
  article.snrg-introduction > div > p:last-child {
    margin-bottom: 0;
  }

  article.snrg-introduction > header {
    min-height: 10vh;
  }

  article.snrg-introduction > header > h1 {
    margin: 0;
  }
</style>