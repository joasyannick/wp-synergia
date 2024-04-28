<script setup lang="ts">
  import { ref, computed } from 'vue'
  import { Media } from '@/types'
  import type { ContentPreview } from '@/types'
  import Menu from '@/components/Menu.vue'
  import ContentPreviewer from '@/components/ContentPreviewer.vue'

  const menuOpened = ref( false )

  const cssClass = computed( () => ( { 'snrg-menu-opened': menuOpened.value } ) )

  const onMenuStateChanged = ( opened: boolean ) => { menuOpened.value = opened }

  // Fetch content data
  //const posts = [] // Test le cas vide
  const posts = [ { cardinality: 'one', title: 'Hellow World!', description: 'Test post', thumbnail: '', background: '', media: new Set( [ Media.TEXT ] ), url: '' } ] as ContentPreview[]
</script>

<template>
  <header class="snrg-header" :class="cssClass">
    <Menu @state-changed="onMenuStateChanged" />
    <ContentPreviewer v-show="menuOpened" :contents="posts" />
  </header>
</template>

<style scoped>
  header.snrg-header {
      display: flex;
      flex-direction: column;
    }

  header.snrg-header.snrg-menu-opened {
      min-height: 100vh;
      background: black;
    }
</style>