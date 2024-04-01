<script setup lang="ts">
  import { RouterView } from 'vue-router'
</script>

<template>
  <main class="snrg-paddy">
    <RouterView></RouterView>
  </main>
</template>

<style scoped>
  div#snrg-app[data-snrg-route='/'] main.snrg-paddy {
      position: relative;
      z-index: 0;
      width: 100vw;
      height: 100vh;
      overflow: hidden auto;
      perspective: 100px;
    }
</style>