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
  div#snrg-app > main.snrg-paddy {
    width: 100vw;
    height: 100vh;
    padding-left: 0;
    padding-right: 0;
  }

  main.snrg-paddy {
    perspective: 100px;
  }
</style>