<script setup lang="ts">
  import { ref } from 'vue'
  import { useEventListener } from '@vueuse/core'
  import { throttle } from 'throttle-debounce'
  import { DOWNWARD, UPWARD, THROTTLING_PERIOD } from '@/constants'

  const emit = defineEmits< { scrolled: [ direction: string ] } >()

  const scrollPosition = ref( 0 )
  const mainElement = ref( null as null | HTMLElement )

  const getScrollDirection = ( event: Event ) => {
        const currentScrollPosition = ( event.target as HTMLElement ).scrollTop
        if ( currentScrollPosition < scrollPosition.value ) {
          emit( 'scrolled', UPWARD )
        } else if ( currentScrollPosition > scrollPosition.value ) {
          emit( 'scrolled', DOWNWARD )
        }
        scrollPosition.value = currentScrollPosition
    }

  const onScroll = throttle( THROTTLING_PERIOD, getScrollDirection )
  useEventListener( mainElement, 'scroll', onScroll )
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