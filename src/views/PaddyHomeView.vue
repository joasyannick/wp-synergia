<script setup lang="ts">
  import { STAR_COUNT } from '@/constants'
  import StarryNight from '@/components/StarryNight.vue'
  import Introduction from '@/components/Introduction.vue'
  import Programs from '@/components/Programs.vue'
</script>

<template>
  <StarryNight :star-count="STAR_COUNT" />
  <Introduction />
  <Programs />
</template>

<style scoped>
</style>