<script setup lang="ts">
  import { ref, computed } from 'vue'
  import { useRoute } from 'vue-router'
  import observers from '@/router/observers'
  import { Media } from '@/types'
  import type { ContentPreview } from '@/types'
  import Menu from '@/components/Menu.vue'
  import ContentPreviewer from '@/components/ContentPreviewer.vue'

  const route = useRoute()

  const menuOpened = ref( false )

  const onMenuStateChanged = ( opened: boolean ) => { menuOpened.value = opened }

  const isHelikiaView = computed( () => ! route.name ? false : observers.isHelikiaView( route.name.toString() ) )

  // Fetch content data
  //const posts = [] // Test le cas vide
  const posts = [ { cardinality: 'one', title: 'Hellow World!', description: 'Test post', thumbnail: '', background: '', media: new Set( [ Media.TEXT ] ), url: '' } ] as ContentPreview[]
</script>

<template>
  <header class="snrg-header">
    <Menu @state-changed="onMenuStateChanged" />
    <ContentPreviewer v-if="isHelikiaView" v-show="menuOpened" :contents="posts" />
    <ContentPreviewer v-else v-show="menuOpened" :contents="posts" />
  </header>
</template>

<style scoped>
</style>