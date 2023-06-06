<script setup lang="ts">
  import { watch } from 'vue'
  import { RouterView, useRoute } from 'vue-router'
  import AppHeader from '@/components/AppHeader.vue'
  import SearchIcon from '@/components/icons/SearchIcon.vue'
  import BiographyIcon from '@/components/icons/BiographyIcon.vue'
  import ContactIcon from '@/components/icons/ContactIcon.vue'
  import SynergiaIcon from '@/components/icons/SynergiaIcon.vue'
  import PaddyIcon from '@/components/icons/PaddyIcon.vue'
  import HelikiaIcon from '@/components/icons/HelikiaIcon.vue'
  import AccountIcon from '@/components/icons/AccountIcon.vue'
  import MenuIcon from '@/components/icons/MenuIcon.vue'

  const route = useRoute()
  watch( () => route.path, ( now, before ) => document.getElementById( 'snrg-app' )!.dataset.snrgRoute = now, { immediate: true } )
</script>

<template>
  <AppHeader>
    <template #search-icon><SearchIcon /></template>
    <template #biography-icon><BiographyIcon /></template>
    <template #contact-icon><ContactIcon /></template>
    <template #synergia-icon><SynergiaIcon /></template>
    <template #paddy-icon><PaddyIcon /></template>
    <template #helikia-icon><HelikiaIcon /></template>
    <template #account-icon><AccountIcon /></template>
    <template #menu-icon><MenuIcon /></template>
  </AppHeader>
    <RouterView />
</template>

<style scoped>
</style>