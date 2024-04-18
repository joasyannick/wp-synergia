<script setup lang="ts">
  import { ContentType } from '@/types'
  import Menu from '@/components/Menu.vue'
  import ContentPreviewer from '@/components/ContentPreviewer.vue'

  // Fetch content data
  const posts = [ { title: "Hellow World!", description: "Test post", thumbnail: "", background: "", type: ContentType.TEXT, url: "" } ]
</script>

<template>
  <header class="snrg-header">
    <Menu />
   <ContentPreviewer :contents="posts" />
  </header>
</template>

<style scoped>
</style>