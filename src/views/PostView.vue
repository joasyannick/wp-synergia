<script setup lang="ts">
  import { ref } from 'vue'
  import { useRoute } from 'vue-router'
  import constants from '@/constants'

  const slug = useRoute().params.slug as string
  const post = ref( { id: -1, title: '', excerpt: '', content: '' } )
  constants.function.fetchPost( 'posts', slug, false, true, post.value )
      .then( result => post.value = result.id !== -1 ? result : post.value )
</script>

<template>
  <section v-if="post" class="snrg-post">
    <header>
      <h2 v-html="post.title"></h2>
    </header>
    <div v-html="post.content"></div>
  </section>
</template>

<style scoped>
</style>
