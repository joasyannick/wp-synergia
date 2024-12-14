<script setup lang="ts">
  import { ref } from 'vue'

  const modules = ref( [] )
</script>

<template>
  <nav class="snrg-modules">
  </nav>
</template>

<style scoped>
  nav.snrg-modules {
    width: 100vw;
    height: 100vh;
    background-color: black;
  }

  nav.snrg-modules.snrg-enter-active {
    transition: opacity var(--SNRG-HEADER-TRANSITION-DURATION) var(--SNRG-HEADER-TRANSITION-TIMING) var(--SNRG-HEADER-TRANSITION-DURATION);
  }

  nav.snrg-modules.snrg-leave-active {
    transition: opacity var(--SNRG-HEADER-TRANSITION-DURATION) var(--SNRG-HEADER-TRANSITION-TIMING);
  }

  nav.snrg-modules.snrg-enter-from,
  nav.snrg-modules.snrg-leave-to {
    opacity: 0;
  }
</style>