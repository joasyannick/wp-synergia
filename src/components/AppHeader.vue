<script setup lang="ts">
  import { ref, computed } from 'vue'
  import { useRoute } from 'vue-router'
  import observers from '@/router/observers'
  import { Media } from '@/types'
  import type { ContentPreview } from '@/types'
  import Menu from '@/components/Menu.vue'
  import ContentPreviewer from '@/components/ContentPreviewer.vue'

  const route = useRoute()
  const maxCount = 3

  const menuOpened = ref( false )
  const posts = ref( [] as any[] )
  const modules = ref( [] as any[] )

  const onMenuStateChanged = ( opened: boolean ) => { menuOpened.value = opened }

  const isHelikiaView = computed( () => ! route.name ? false : observers.isHelikiaView( route.name.toString() ) )

  const fetchMustSee = async () => {
      try {
        const response = await fetch( import.meta.env.VITE_WP_REST_URL + 'wp/v2/snrg-must-sees?per_page=' + maxCount + '&_fields=title.rendered,content.rendered' )
        posts.value = await response.json()
        posts.value.forEach( ( mustSee ) => mustSee.content.rendered = mustSee.content.rendered.replace( /(<\/?)h(\d+)/g, ( match: string, token: string, level: string ) => token + 'h' + ( parseInt( level ) + 1 ) ) )
      } catch ( exception ) {
        console.error( 'Failed to fetch must-see' )
      }
    }

  // Fetch content data
  //const previews = [] // Test le cas vide
  const previews = [ { cardinality: 'one', title: 'Hellow World!', description: 'Test post', thumbnail: '', background: '', media: new Set( [ Media.TEXT ] ), url: '' } ] as ContentPreview[]
</script>

<template>
  <header class="snrg-header">
    <Menu @state-changed="onMenuStateChanged" />
    <ContentPreviewer v-if="isHelikiaView" v-show="menuOpened" :previews="previews" />
    <ContentPreviewer v-else v-show="menuOpened" :previews="previews" />
  </header>
</template>

<style scoped>
</style>