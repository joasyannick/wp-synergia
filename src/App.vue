<script setup lang="ts">
  import { ref, provide , watch } from 'vue'
  import { RouterView, useRoute } from 'vue-router'
  import { useThemeStore } from '@/stores/theme'
  import { iMenu } from '@/injection'
  import AppHeader from '@/components/AppHeader.vue'

  const route = useRoute()
  const theme = useThemeStore()

  const menuOpened = ref( false )

  const openOrCloseMenu = () => { menuOpened.value = ! menuOpened.value }

  provide( iMenu, { opened: menuOpened, openOrClose: openOrCloseMenu } )

  watch( () => route.path, ( now, before ) => document.getElementById( 'snrg-app' )!.dataset.snrgRoute = now, { immediate: true } )
</script>

<template>
  <AppHeader />
  <RouterView />
</template>

<style lang="scss">
  $test: blue;

  header.snrg-header {
    position: absolute;
    left: 0;
    top: 0;
    z-index: 1;
  }

  main {
    --snrg-padding: var(--SNRG-PADDING-UNTIL-396PX);
    position: relative;
    z-index: 0;
    box-sizing: border-box;
    width: 100vw;
    height: 100vh;
    overflow: hidden auto;
    padding-left: calc(var(--snrg-padding));
    padding-right: calc(var(--snrg-padding));
  }

  :is(header.snrg-header, main) {
    --SNRG-NUNITO-SANS-SIZE-UNTIL-1188PX: 18px;
    --SNRG-PADDING-UNTIL-396PX: 1rem;
    --SNRG-PADDING-AT-1188PX: (var(--SNRG-PADDING-UNTIL-396PX) + (1188px - 396px) * var(--SNRG-PADDING-COEFFICIENT-UNTIL-1188PX));
    --SNRG-PADDING-COEFFICIENT-UNTIL-1188PX: ((1188/6 - 18) / (1188 - 396));
    --SNRG-PADDING-COEFFICIENT-AT-1188PX: ((1194/6 - 1188/6) / (1194 - 1188));
    --snrg-nunito-sans-size: var(--SNRG-NUNITO-SANS-SIZE-UNTIL-1188PX);
    --snrg-roboto-size: (var(--snrg-nunito-sans-size) * var(--SNRG-ROBOTO-RATIO));
    font: calc(var(--snrg-nunito-sans-size))/var(--SNRG-GOLDEN-RATIO) 'Nunito Sans';
  }

  :is(header.snrg-header, main) :is(button, h1, h2, h3, h4, h5, h6) {
    font-family: 'Roboto', sans-serif;
  }

  :is(header.snrg-header, main) :is(h1, h2, h3, h4, h5, h6) {
    --snrg-scale-factor: var(--SNRG-MAJOR-SECOND);
    font-weight: 500;
  }

  :is(header.snrg-header, main) h1 {
    font-size: calc(var(--snrg-roboto-size) * var(--snrg-scale-factor) * var(--snrg-scale-factor) * var(--snrg-scale-factor) * var(--snrg-scale-factor) * var(--snrg-scale-factor) * var(--snrg-scale-factor));
  }

  :is(header.snrg-header, main) h2 {
    font-size: calc(var(--snrg-roboto-size) * var(--snrg-scale-factor) * var(--snrg-scale-factor) * var(--snrg-scale-factor) * var(--snrg-scale-factor));
  }

  :is(header.snrg-header, main) h3 {
    font-size: calc(var(--snrg-roboto-size) * var(--snrg-scale-factor) * var(--snrg-scale-factor));
  }

  :is(header.snrg-header, main) :is(button, h4, h5, h6) {
    font-size: calc(var(--snrg-roboto-size));
  }

  @media screen and (min-width: 396px) {
    main {  
      --snrg-padding: (var(--SNRG-PADDING-UNTIL-396PX) + (100vw - 396px) * var(--SNRG-PADDING-COEFFICIENT-UNTIL-1188PX));
    }
  }

  @media screen and (min-width: 1188px) {
    main {
      --snrg-padding: (var(--SNRG-PADDING-AT-1188PX) + (100vw - 1188px) * var(--SNRG-PADDING-COEFFICIENT-AT-1188PX));
    }
  }
</style>