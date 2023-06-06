<script setup lang="ts">
  const props = defineProps< { viewBoxWidth: number, viewBoxHeight: number, clipId: string } >()
</script>

<template>
  <svg class="snrg-graphic" :viewBox="'0 0 ' + props.viewBoxWidth + ' ' + props.viewBoxHeight">
    <clipPath :id="props.clipId">
      <rect id="" x="0" y="0" :width="props.viewBoxWidth" :height="props.viewBoxHeight" />
    </clipPath>
    <slot></slot>
  </svg>
</template>

<style scoped>
</style>