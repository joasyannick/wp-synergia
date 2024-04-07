<script setup lang="ts">
  import type { PostPreview } from '@/types'
  const props = defineProps< { posts: { preview: PostPreview | PostPreview[], pinned: boolean }[] } >()
</script>

<template>
</template>

<style scoped>
</style>