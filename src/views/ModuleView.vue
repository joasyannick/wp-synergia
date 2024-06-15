<script setup lang="ts">
  import { ref } from 'vue'
  import { useRoute } from 'vue-router'
  import constants from '@/constants'

  const slug = useRoute().params.slug as string
  const module = ref ( await constants.function.fetchPost( 'snrg-modules', slug, false, true, { id: -1, title: '', excerpt: '', content: '' } ) )
</script>

<template>
  <section v-if="module" class="snrg-module">
    <header>
      <h2 v-html="module.title"></h2>
    </header>
    <div v-html="module.content">
    </div>
  </section>
</template>
  
<style scoped>
</style>
  