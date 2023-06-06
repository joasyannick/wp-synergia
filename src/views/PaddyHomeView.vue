<script setup lang="ts">
  import constants from '@/constants'
  import Recent from '@/components/Recent.vue'
  import MustSees from '@/components/MustSees.vue'
</script>

<template>
  <Recent :star-count="Math.trunc( constants.starryNight.starCount / 2 )" />
  <MustSees />
</template>

<style scoped>
</style>