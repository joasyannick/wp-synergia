<script setup lang="ts">
  import { RouterView } from 'vue-router'
  import Main from '@/components/Main.vue'
</script>

<template>
  <Main class="snrg-paddy">
    <RouterView v-slot="{ Component }">
      <KeepAlive>
        <component :is="Component" />
      </KeepAlive>
    </RouterView>
  </Main>
</template>

<style scoped>
  main.snrg-paddy {
    width: 100vw;
    height: 100vh;
    padding-left: 0;
    padding-right: 0;
    perspective: 100px;
  }
</style>