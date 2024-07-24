<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'

  const posts = ref( [] as { id: number, slug: string, title: string, data: Map< string, any > }[] )

  const options = new Map()
  options.set( 'excerpt.rendered', true )
  options.set( 'wp:featuredmedia', true )
  constants.function.fetchAllPosts( 'https://paddyfontaine.fr/wp-json', 'posts', options ).then( results => posts.value = results )
</script>

<template>
  <nav class="snrg-posts">
    <header>
      <h1>Blog</h1>
    </header>
    <article v-for="post in posts" :key="post.id">
      <header>
        <h1 v-html="post.title"></h1>
      </header>
      <aside><img v-if="post.data.get( 'wp:featuredmedia' )" :src="post.data.get( 'wp:featuredmedia' )" /></aside>
      <div v-if="post.data.get( 'excerpt.rendered' )" v-html="post.data.get( 'excerpt.rendered' )"></div>
    </article>
  </nav>
</template>

<style scoped>
  nav.snrg-posts {
    width: 100vw;
    height: 100vh;
    background: black;
  }

  nav.snrg-posts.snrg-enter-active {
    transition: opacity var( --snrg-menu-transition-duration ) ease-in-out var( --snrg-menu-transition-duration );
  }

  nav.snrg-posts.snrg-leave-active {
    transition: opacity var( --snrg-menu-transition-duration ) ease-in-out;
  }

  nav.snrg-posts.snrg-enter-from,
  nav.snrg-posts.snrg-leave-to {
    opacity: 0;
  }
</style>