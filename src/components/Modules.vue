<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'

  const modules = ref( [] )
  //constants.function.fetchAllPosts( import.meta.env.VITE_WP_REST_URL, 'snrg-programs', false, true, programs.value )
</script>

<template>
  <nav class="snrg-modules">
  </nav>
</template>

<style scoped>
  nav.snrg-modules {
    width: 100vw;
    height: 100vh;
    background: black;
  }

  nav.snrg-modules.snrg-enter-active {
    transition: opacity var( --snrg-menu-transition-duration ) ease-in-out var( --snrg-menu-transition-duration );
  }

  nav.snrg-modules.snrg-leave-active {
    transition: opacity var( --snrg-menu-transition-duration ) ease-in-out;
  }

  nav.snrg-modules.snrg-enter-from,
  nav.snrg-modules.snrg-leave-to {
    opacity: 0;
  }
</style>