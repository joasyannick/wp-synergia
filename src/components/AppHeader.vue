<script setup lang="ts">
  import { ref } from 'vue'
  import { Media } from '@/types'
  import type { ContentPreview } from '@/types'
  import Menu from '@/components/Menu.vue'
  import ContentPreviewer from '@/components/ContentPreviewer.vue'

  const menuOpened = ref( false )
  const onMenuStateChanged = ( opened: boolean ) => { menuOpened.value = opened }
  // Fetch content data
  //const posts = [] // Test le cas vide
  const posts = [ { cardinality: 'one', title: 'Hellow World!', description: 'Test post', thumbnail: '', background: '', media: new Set( [ Media.TEXT ] ), url: '' } ] as ContentPreview[]
</script>

<template>
  <header class="snrg-header">
    <Menu @state-changed="onMenuStateChanged" />
    <ContentPreviewer v-show="menuOpened" :contents="posts" />
  </header>
</template>

<style scoped>
</style>