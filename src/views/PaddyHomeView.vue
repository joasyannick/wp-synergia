<script setup lang="ts">
  import constants from '@/constants'
  import StarryNight from '@/components/StarryNight.vue'
  import Introduction from '@/components/Introduction.vue'
  import Programs from '@/components/Programs.vue'
</script>

<template>
  <StarryNight :star-count="constants.starryNight.starCount" />
  <Introduction />
  <Programs />
</template>

<style scoped>
</style>