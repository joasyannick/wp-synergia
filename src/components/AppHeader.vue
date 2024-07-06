<script setup lang="ts">
  import { inject, ref, computed } from 'vue'
  import { useRoute } from 'vue-router'
  import constants from '@/constants'
  import observers from '@/router/observers'
  import { Media } from '@/types'
  import type { ContentPreview } from '@/types'
  import type { IMenu } from '@/injection'
  import { iMenu } from '@/injection'
  import Menu from '@/components/Menu.vue'
  import ContentPreviewer from '@/components/ContentPreviewer.vue'

  const menu = inject( iMenu ) as IMenu

  const route = useRoute()

  const cssStyle = { '--snrg-menu-transition-duration': ( Math.round(0.5 * constants.menu.animation * 1000) / 1000 ) + 's' }

  const posts = ref( [] as any[] )
  const modules = ref( [] as any[] )

  const isPaddyView = computed( () => ! route.name ? false : observers.isPaddyView( route.name.toString() ) )
  const isHelikiaView = computed( () => ! route.name ? false : observers.isHelikiaView( route.name.toString() ) )

  const previews = [ { cardinality: 'one', title: 'Hellow World!', description: 'Test post', thumbnail: '', background: '', media: new Set( [ Media.TEXT ] ), url: '' } ] as ContentPreview[]
</script>

<template>
  <header class="snrg-header" :style="cssStyle">
    <Menu />
    <Transition name="snrg">
      <ContentPreviewer v-if="isPaddyView" v-show="menu.opened.value" :previews="previews" />
      <ContentPreviewer v-else-if="isHelikiaView" v-show="menu.opened.value" :previews="previews" />
    </Transition>
  </header>
</template>

<style scoped>
  header.snrg-header {
    position: absolute;
    left: 0;
    top: 0;
    z-index: 1;
  }
</style>