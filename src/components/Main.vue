<script setup lang="ts">
  import { ref, onMounted, onUnmounted } from 'vue'
  import { throttle } from 'throttle-debounce'
  import constants from '@/constants'
  import { ScrollDirection } from '@/types'

  const emit = defineEmits< { scrolled: [ direction: ScrollDirection ] } >()

  const scrollPosition = ref( 0 )
  const mainElement = ref( null as null | HTMLElement )

  const getScrollDirection = ( event: Event ) => {
        const currentScrollPosition = ( event.target as HTMLElement ).scrollTop
        if ( currentScrollPosition < scrollPosition.value ) {
          emit( 'scrolled', ScrollDirection.UP )
        } else if ( currentScrollPosition > scrollPosition.value ) {
          emit( 'scrolled', ScrollDirection.DOWN )
        }
        scrollPosition.value = currentScrollPosition
    }

  const onScroll = throttle( constants.throttle.period, getScrollDirection )

  onMounted( () => { mainElement.value!.addEventListener( 'scroll', onScroll ) } )

  onUnmounted( () => { mainElement.value!.removeEventListener( 'scroll', onScroll ) } )
</script>

<template>
  <main ref="mainElement">
    <slot></slot>
  </main>
</template>

<style scoped>
  main {
    box-sizing: border-box;
    width: 100%;
    height: 100%;
    overflow: clip auto;
    padding-left: calc(var(--snrg-content-margin));
    padding-right: calc(var(--snrg-content-margin));
  }
</style>