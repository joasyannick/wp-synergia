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
  main.snrg-helikia {
    position: relative;
    box-sizing: border-box;
    width: 100vw;
    height: 100vh;
    overflow: hidden auto;
  }
</style>
