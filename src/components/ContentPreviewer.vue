<script setup lang="ts">
  import type { ContentPreview } from '@/types'
  const props = defineProps< { contents: ContentPreview[] } >()
</script>

<template>
  <nav class="snrg-content-previewer">
    <div class="snrg-content-search">
    </div>
    <div class="snrg-content-list">
    </div>
    <div class="snrg-content-description">
    </div>
  </nav>
</template>

<style scoped>
</style>