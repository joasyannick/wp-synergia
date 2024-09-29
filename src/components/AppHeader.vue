<script setup lang="ts">
  import { inject, computed } from 'vue'
  import { useRoute } from 'vue-router'
  import constants from '@/constants'
  import observers from '@/router/observers'
  import type { IMenu } from '@/injection'
  import { iMenu } from '@/injection'
  import Menu from '@/components/Menu.vue'
  import Posts from '@/components/Posts.vue'
  import Modules from '@/components/Modules.vue'
  import Settings from '@/components/Settings.vue'

  const menu = inject( iMenu ) as IMenu

  const route = useRoute()

  const style = { '--snrg-menu-transition': ( Math.round(0.5 * constants.menu.animation * 1000) / 1000 ) + 's' }

  const classes = computed( () => [ { 'snrg-menu-opened': menu.opened.value } ] )
  const isPaddyView = computed( () => ! route.name ? false : observers.isPaddyView( route.name.toString() ) )
  const isHelikiaView = computed( () => ! route.name ? false : observers.isHelikiaView( route.name.toString() ) )
  const isAccountView = computed( () => ! route.name ? false : observers.isAccountView( route.name.toString() ) )
  const isErrorView = computed( () => ! route.name ? false : observers.isErrorView( route.name.toString() ) )
</script>

<template>
  <header class="snrg-header" :class="classes" :style="style">
    <Menu />
    <Transition name="snrg">
      <Posts v-if="isPaddyView || isErrorView" v-show="menu.opened.value" />
      <Modules v-else-if="isHelikiaView" v-show="menu.opened.value" />
      <Settings v-else-if="isAccountView" v-show="menu.opened.value" />
    </Transition>
  </header>
</template>

<style scoped>
  header.snrg-header {
    position: absolute;
    left: 0;
    top: 0;
    width: 0;
    height: 0;
    z-index: 1;
  }

  header.snrg-header.snrg-menu-opened {
    width: 100%;
    height: 100%;
  }
</style>