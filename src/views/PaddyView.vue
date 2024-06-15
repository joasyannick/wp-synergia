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
  div#snrg-app[data-snrg-route='/'] main.snrg-paddy {
      perspective: 100px;
    }
</style>