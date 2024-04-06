<script setup lang="ts">
  enum PostType { TEXT, AUDIO, VIDEO }
  type PostPreview = { title: string, featuredImage: string, description: string, url: string, type: PostType }
  const props = defineProps< { posts: { preview: PostPreview | PostPreview[], pinned: boolean }[] } >()
</script>

<template>
</template>

<style scoped>
</style>