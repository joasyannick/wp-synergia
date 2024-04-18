<script setup lang="ts">
  import { watch } from 'vue'
  import { RouterView, useRoute } from 'vue-router'
  import AppHeader from '@/components/AppHeader.vue'

  const route = useRoute()
  watch( () => route.path, ( now, before ) => document.getElementById( 'snrg-app' )!.dataset.snrgRoute = now, { immediate: true } )
</script>

<template>
  <AppHeader />
  <RouterView />
</template>

<style scoped>
</style>