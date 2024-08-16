<script setup lang="ts">
</script>

<template>
  <nav class="snrg-settings">
  </nav>
</template>

<style scoped>
  nav.snrg-settings {
    width: 100vw;
    height: 100vh;
    background-color: black;
  }

  nav.snrg-settings.snrg-enter-active {
    transition: opacity var( --snrg-menu-transition-duration ) ease-in-out var( --snrg-menu-transition-duration );
  }

  nav.snrg-settings.snrg-leave-active {
    transition: opacity var( --snrg-menu-transition-duration ) ease-in-out;
  }

  nav.snrg-settings.snrg-enter-from,
  nav.snrg-settings.snrg-leave-to {
    opacity: 0;
  }
</style>