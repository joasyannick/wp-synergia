<script setup lang="ts">
  import { ref, computed } from 'vue'
  import { RouterLink } from 'vue-router'
  import { isSingleContentPreview, type ContentPreview } from '@/types'
  const props = defineProps< { contents: ContentPreview[] } >()

  const current = ref( 0 )
  const currentLink = computed( () => { let a = props.contents[ current.value ]; return isSingleContentPreview( a ) ? a.url : '' } )
</script>

<template>
  <nav class="snrg-content-previewer">
    <div class="snrg-content-search">
      <button type="button">T</button><!-- Filter text content -->
      <button type="button">A</button><!-- Filter audio content -->
      <button type="button">V</button><!-- Filter video content -->
      <input type="search" />
    </div>
    <div class="snrg-content-list">
      <button type="button">P</button><!-- Previous page -->
      <button type="button">B</button><!-- Go back from a composite preview -->
      <img v-for="item in props.contents" :src="item.thumbnail"/>
      <button type="button">N</button><!-- Next page -->
    </div>
    <article v-if="props.contents.length" class="snrg-content-description">
      <header>{{ props.contents[ current ].title }}</header>
      <p>{{ props.contents[ current ].description }}</p>
      <footer v-show="isSingleContentPreview( props.contents[ current ] )"><RouterLink :to="currentLink" /></footer>
    </article>
  </nav>
</template>

<style scoped>
</style>