<script setup lang="ts">
  import { ref, computed } from 'vue'
  import { RouterLink } from 'vue-router'
  import { Media, isSingleContentPreview, type ContentPreview } from '@/types'

  const props = defineProps< { previews: ContentPreview[] } >()

  const current = ref( props.previews.length ? [ 0 ] : [] )
  const firstOfPage = ref( current.value )
  const perPage = ref( 3 )

  const currentData = computed( () => {
      if ( current.value.length ) {
        return null
      }
    } )

  //const currentLink = computed( () => { let a = props.previews[ current.value ]; return isSingleContentPreview( a ) ? a.url : '' } )
  //const goLabel = computed( () => { let a = props.previews[ current.value ]; return isSingleContentPreview( a ) ? ( a.media.has( Media.VIDEO ) ? 'Regarder' : ( a.media.has( Media.AUDIO ) ? 'Ecouter' : 'Lire' ) ) : '' } )
</script>

<template>
  <nav class="snrg-content-previewer">
    <div class="snrg-content-search">
      <button type="button">A</button><!-- Show only audiovisual content -->
      <input type="search" />
    </div>
    <div class="snrg-content-list">
      <button type="button">P</button><!-- Previous page -->
      <button type="button">B</button><!-- Go back from a composite preview -->
      <img v-for="item in props.previews" :src="item.thumbnail"/>
      <button type="button">N</button><!-- Next page -->
    </div>
    <article v-if="props.previews.length" class="snrg-content-description">
      <!--<header>{{ props.previews[ current ].title }}</header>-->
      <!--<p>{{ props.previews[ current ].description }}</p>-->
      <!--<footer v-show="isSingleContentPreview( props.previews[ current ] )"><RouterLink :to="currentLink">{{ goLabel }}</RouterLink></footer>-->
    </article>
  </nav>
</template>

<style scoped>
  nav.snrg-content-previewer {
      width: 100vw;
      height: 100vh;
      background: black;
    }
</style>