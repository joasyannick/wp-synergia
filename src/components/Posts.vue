<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'

  const posts = ref( [] as { id: number, slug: string, title: string, excerpt: string, content: string }[] )

  constants.function.fetchAllPosts( 'https://paddyfontaine.fr/wp-json', 'posts', true, false, [] ).then( results => posts.value = results )
</script>

<template>
  <nav class="snrg-posts">
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