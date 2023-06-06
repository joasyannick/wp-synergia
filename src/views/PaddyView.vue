<script setup lang="ts">
  import { RouterView } from 'vue-router'
  import constants from '@/constants'
  import StarryNight1 from '@/components/images/StarryNight1.vue'
</script>

<template>
  <aside class="snrg-background">
    <StarryNight1 :star-count="Math.trunc( constants.starryNight.starCount / 2 )" />
  </aside>
  <main class="snrg-paddy">
    <RouterView></RouterView>
  </main>
</template>

<style scoped>
  aside.snrg-background {
      position: fixed;
      left: 50%;
      width: max(100vw, 1600vh / 9);
      height: max(900vw / 16, 100vh);
      transform: translateX(-50%);
    }

    aside.snrg-background:deep(svg.snrg-graphic) {
      position: absolute;
      left: 0;
      top: 0;
      width:100%;
      height:100%;
    }

  aside.snrg-background:deep( svg.snrg-graphic.snrg-sky > g > rect.snrg-overlay ) {
      mix-blend-mode: multiply;
    }

  div#snrg-app[data-snrg-route='/'] main.snrg-paddy {
      position: relative;
      z-index: 0;
      width: 100vw;
      height: 100vh;
      overflow: hidden auto;
      perspective: 100px;
    }
</style>