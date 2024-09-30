<script setup lang="ts">
  import { KeepAlive } from 'vue'
  import { RouterView } from 'vue-router'
  import Main from '@/components/Main.vue'
</script>

<template>
  <Main class="snrg-helikia">
    <RouterView v-slot="{ Component }">
      <KeepAlive>
        <component :is="Component" />
      </KeepAlive>
    </RouterView>
  </Main>
</template>

<style scoped>
</style>
