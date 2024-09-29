<script setup lang="ts">
  import { KeepAlive } from 'vue'
  import { RouterView } from 'vue-router'
</script>

<template>
  <main class="snrg-helikia">
    <RouterView v-slot="{ Component }">
      <KeepAlive>
        <component :is="Component" />
      </KeepAlive>
    </RouterView>
  </main>
</template>

<style scoped>
</style>
