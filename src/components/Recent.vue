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
    }

  article.snrg-welcome:deep( :is( svg.snrg-graphic, div.snrg-tagline ) ) {
      position: absolute;
      left: 0;
      top: 0;
      width:100%;
      height:100%;
    }

  article.snrg-welcome:deep( svg.snrg-graphic.snrg-sky ) {
      transform: translateZ( -160px ) scale( 2.6 ) /* scale = (perspective - distance) / perspective */
    }

  article.snrg-welcome:deep( svg.snrg-graphic.snrg-sky > g > rect.snrg-overlay ) {
      mix-blend-mode: multiply;
    }

  article.snrg-welcome:deep( svg.snrg-graphic.snrg-stars ) {
      transform: translateZ( -80px ) scale( 1.8 );
    }

  article.snrg-welcome:deep( div.snrg-taglines ) {
      display: flex;
      align-items: center;
      justify-content: center;
    }

  article.snrg-welcome:deep( svg.snrg-graphic.snrg-mountains ) {
      transform: translateZ( -40px ) scale( 1.4 );
    }

  article.snrg-welcome:deep( svg.snrg-graphic.snrg-plain ) {
      transform: translateZ( -20px ) scale( 1.2 )
    }

  article.snrg-welcome:deep( svg.snrg-graphic.snrg-forest ) {
      transform: translateZ( -10px ) scale( 1.1 );
    }
</style>