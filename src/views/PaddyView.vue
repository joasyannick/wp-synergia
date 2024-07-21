<script setup lang="ts">
  import { RouterView } from 'vue-router'
</script>

<template>
  <main class="snrg-paddy">
    <RouterView v-slot="{ Component }">
      <KeepAlive>
        <component :is="Component" />
      </KeepAlive>
    </RouterView>
  </main>
</template>

<style scoped>
  main.snrg-paddy {
    position: relative;
    box-sizing: border-box;
    width: 100vw;
    height: 100vh;
    overflow: hidden auto;
    perspective: 100px;
  }
</style>