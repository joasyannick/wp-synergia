<script setup lang="ts">
  import { inject, ref, computed } from 'vue'
  import { useRoute } from 'vue-router'
  import observers from '@/router/observers'
  import { Media } from '@/types'
  import type { ContentPreview } from '@/types'
  import type { IMenu } from '@/injection'
  import { iMenu } from '@/injection'
  import Menu from '@/components/Menu.vue'
  import ContentPreviewer from '@/components/ContentPreviewer.vue'

  const menu = inject( iMenu ) as IMenu

  const route = useRoute()

  const maxCount = 3
  const posts = ref( [] as any[] )
  const modules = ref( [] as any[] )

  const isHelikiaView = computed( () => ! route.name ? false : observers.isHelikiaView( route.name.toString() ) )

  const fetchPrograms = async () => {
      try {
        const response = await fetch( import.meta.env.VITE_WP_REST_URL + 'wp/v2/snrg-programs?per_page=' + maxCount + '&_fields=title.rendered,content.rendered' )
        posts.value = await response.json()
        posts.value.forEach( ( mustSee ) => mustSee.content.rendered = mustSee.content.rendered.replace( /(<\/?)h(\d+)/g, ( match: string, token: string, level: string ) => token + 'h' + ( parseInt( level ) + 1 ) ) )
      } catch ( exception ) {
        console.error( 'Failed to fetch programs' )
      }
    }

  // Fetch content data
  //const previews = [] // Test le cas vide
  // Refresh posts when the menu is open.
  const previews = [ { cardinality: 'one', title: 'Hellow World!', description: 'Test post', thumbnail: '', background: '', media: new Set( [ Media.TEXT ] ), url: '' } ] as ContentPreview[]
</script>

<template>
  <header class="snrg-header">
    <Menu />
    <Transition name="snrg">
      <ContentPreviewer v-if="isHelikiaView" v-show="menu.opened.value" :previews="previews" />
      <ContentPreviewer v-else v-show="menu.opened.value" :previews="previews" />
    </Transition>
  </header>
</template>

<style scoped>
nav.snrg-content-previewer.snrg-enter-active,
nav.snrg-content-previewer.snrg-leave-active {
  transition: opacity 2s ease-in-out;
}

nav.snrg-content-previewer.snrg-enter-from,
nav.snrg-content-previewer.snrg-leave-to {
  opacity: 0;
}
</style>