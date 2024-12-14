<script setup lang="ts">
  import { ref, inject } from 'vue'
  import { INTRODUCTION_PAGE, WP_CONTENT_RENDERED, WP_PAGES } from '@/constants'
  import { fetchPost } from '@/wordpress'
  import type { IMenu } from '@/injection'
  import { iMenu } from '@/injection'

  const menu = inject( iMenu ) as IMenu

  const introduction = ref( null as null | { id: number, title: string, data: Map< string, any > } )

  const options = new Map()
  options.set( WP_CONTENT_RENDERED, true )
  fetchPost( import.meta.env.VITE_WP_REST_URL, WP_PAGES, INTRODUCTION_PAGE, options )
      .then( result => introduction.value = result )
</script>

<template>
  <article class="snrg-introduction">
    <header>
      <h1 v-if="introduction" v-html="introduction.title"></h1>
      <h1 v-else>Bienvenue</h1>
    </header>
    <div v-if="introduction && introduction.data.get( WP_CONTENT_RENDERED )" v-html="introduction.data.get( WP_CONTENT_RENDERED )"></div>
    <div v-else>
      <p>Présenter le site.</p>
    </div>
    <footer><button type="button" class="snrg-action-button" @click="menu.openOrClose">Lire le blog</button></footer>
  </article>
</template>

<style scoped>
  article.snrg-introduction {
    position: relative;
    margin-top: -10vh;
    padding-left: calc(var(--snrg-outer-margin) + var(--snrg-middle-content-margin));
    padding-right: calc(var(--snrg-outer-margin) + var(--snrg-middle-content-margin));
    background-color: hsl(var(--snrg-background-hue) var(--SNRG-BACKGROUND-SATURATION) var(--snrg-background-lightness));
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

  article.snrg-introduction > div {
    margin-left: calc(var(--snrg-middle-content-margin));
    margin-right: calc(var(--snrg-middle-content-margin));
  }
</style>