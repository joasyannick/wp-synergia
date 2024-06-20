<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'

  const programs = ref( [ { id: -1, slug:'', title: 'Programme n°1', excerpt: '', content: '<p>Un programme.</p>' }, { id: -2, slug:'', title: 'Programme n°2', excerpt: '', content: '<p>Un autre programme.</p>' } ] )
  constants.function.fetchAllPosts( 'snrg-programs', false, true, programs.value )
</script>

<template>
  <nav class="snrg-programs">
    <header>
      <h1>Nos programmes</h1>
    </header>
    <article v-for="program in programs" :key="program.id">
      <header>
        <h2 v-html="program.title"></h2>
      </header>
      <div v-html="program.content"></div>
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
    font-family: 'Roboto';
    margin: 0;
  }

  nav.snrg-programs > article > header > h2 {
    font-family: 'Roboto';
  }
</style>