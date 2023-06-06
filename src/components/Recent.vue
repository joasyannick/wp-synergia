<script setup lang="ts">
  import StarryNight2 from '@/components/images/StarryNight2.vue'

  const props = defineProps< { starCount: number } >()
</script>

<template>
  <article class="snrg-welcome">
    <StarryNight2 :star-count="props.starCount" />
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

  article.snrg-welcome:deep( svg.snrg-graphic ) {
      position: absolute;
      left: 0;
      top: 0;
      width:100%;
      height:100%;
    }

  article.snrg-welcome:deep( svg.snrg-graphic.snrg-stars ) {
      transform: translateZ( -200px ) scale( 3 )
    }

  article.snrg-welcome:deep( svg.snrg-graphic.snrg-mountains ) {
      transform: translateZ( -100px ) scale( 2 )
    }
  article.snrg-welcome:deep( svg.snrg-graphic.snrg-plain ) {
      transform: translateZ( -50px ) scale( 1.5 )
    }

  article.snrg-welcome:deep( svg.snrg-graphic.snrg-forest ) {
      transform: translateZ( -25px ) scale( 1.25 )
    }
</style>