<script setup lang="ts">
  import { ContentType } from '@/types'
  import Menu from '@/components/Menu.vue'
  import ContentPreviewer from '@/components/ContentPreviewer.vue'
  import SearchIcon from '@/components/icons/SearchIcon.vue'
  import BiographyIcon from '@/components/icons/BiographyIcon.vue'
  import ContactIcon from '@/components/icons/ContactIcon.vue'
  import SynergiaIcon from '@/components/icons/SynergiaIcon.vue'
  import PaddyIcon from '@/components/icons/PaddyIcon.vue'
  import HelikiaIcon from '@/components/icons/HelikiaIcon.vue'
  import AccountIcon from '@/components/icons/AccountIcon.vue'
  import MenuIcon from '@/components/icons/MenuIcon.vue'

  // Fetch content data
  const posts = [ { title: "Hellow World!", description: "Test post", thumbnail: "", background: "", type: ContentType.TEXT, url: "" } ]
</script>

<template>
  <header class="snrg-header">
    <Menu>
      <template #search-icon><SearchIcon /></template>
      <template #biography-icon><BiographyIcon /></template>
      <template #contact-icon><ContactIcon /></template>
      <template #synergia-icon><SynergiaIcon /></template>
      <template #paddy-icon><PaddyIcon /></template>
      <template #helikia-icon><HelikiaIcon /></template>
      <template #account-icon><AccountIcon /></template>
      <template #menu-icon><MenuIcon /></template>
    </Menu>
   <ContentPreviewer :contents="posts" />
  </header>
</template>

<style scoped>
</style>