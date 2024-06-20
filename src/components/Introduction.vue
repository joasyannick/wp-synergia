<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'

  const introduction = ref( { id: -1, title: 'Bienvenue', excerpt: '', content: '<p>Présenter le site.</p>' } )
  Promise.all( [ constants.function.fetchPost( 'pages', constants.route.paddy.introduction, false, true, introduction.value ), constants.function.fetchPost( 'posts', constants.route.paddy.introduction, false, true, introduction.value ) ] )
      .then( results => results.filter( result => result.id !== -1 ).forEach( result => introduction.value = result ) )
</script>

<template>
  <article class="snrg-introduction">
    <header>
      <h1 v-html="introduction.title"></h1>
    </header>
    <div v-html="introduction.content"></div>
  </article>
</template>

<style scoped>
  article.snrg-introduction {
    position: relative;
    margin-top: -10vh;
    background: hsl( var( --snrg-background-hue ), var( --snrg-background-saturation ), var( --snrg-background-lightness ) );
  }
  
  article.snrg-introduction > div > p:last-child {
    margin-bottom: 0;
  }

  article.snrg-introduction > header {
    min-height: 10vh;
  }

  article.snrg-introduction > header > h1 {
    font-family: 'Roboto';
    margin: 0;
  }
</style>