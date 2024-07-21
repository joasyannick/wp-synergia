<script setup lang="ts">
  import { ref } from 'vue'
  import { useRoute } from 'vue-router'
  import constants from '@/constants'

  const slug = useRoute().params.slug as string
  const module = ref( { id: -1, title: '', excerpt: '', content: '' } )
  constants.function.fetchPost( import.meta.env.VITE_WP_REST_URL, 'posts', slug, false, true, module.value )
      .then( result => module.value = result.id !== -1 ? result : module.value )</script>

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
  