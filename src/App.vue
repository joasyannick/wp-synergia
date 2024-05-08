<script setup lang="ts">
  import { ref, provide , watch } from 'vue'
  import { RouterView, useRoute } from 'vue-router'
  import { iMenu } from '@/injection'
  import AppHeader from '@/components/AppHeader.vue'

  const route = useRoute()

  const menuOpened = ref( false )

  const openOrCloseMenu = () => { menuOpened.value = ! menuOpened.value }

  provide( iMenu, { opened: menuOpened, openOrClose: openOrCloseMenu } )

  watch( () => route.path, ( now, before ) => document.getElementById( 'snrg-app' )!.dataset.snrgRoute = now, { immediate: true } )
</script>

<template>
  <AppHeader />
  <RouterView />
</template>

<style scoped>
</style>@/injection