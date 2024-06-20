<script setup lang="ts">
  import constants from '@/constants'
  import StarryNight from '@/components/images/StarryNight.vue'
  import Introduction from '@/components/Introduction.vue'
  import Programs from '@/components/Programs.vue'
</script>

<template>
  <aside class="snrg-starry-night">
    <StarryNight :star-count="constants.starryNight.starCount" />
  </aside>
  <Introduction />
  <Programs />
</template>

<style scoped>
  aside.snrg-starry-night {
    position: relative;
    left: 50%;
    /* Fit a div of ( w0, h0 ) size into a div of ( w, h ) size in a cover way */
    width: max(100vw, 100vh * 16 / 9); /* max( w, h * w0 / h0 ) */
    height: max(100vw * 9 / 16, 100vh); /* max( w * h0 / w0, h ) */
    transform: translateX(-50%);
    transform-style: preserve-3d;
    pointer-events: none;
  }
</style>