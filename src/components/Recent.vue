<script setup lang="ts">
  import constants from '@/constants'
  import StarryNight from '@/components/images/StarryNight.vue'
</script>

<template>
  <article class="snrg-welcome">
    <StarryNight :star-count="constants.starryNight.starCount" />
  </article>
</template>

<style scoped>
  article.snrg-welcome {
      position: relative;
      left: 50%;
      width: max(100vw, 1600vh / 9);
      height: max(900vw / 16, 100vh);
      transform: translateX(-50%);
      transform-style: preserve-3d;
      pointer-events: none;
    }
</style>