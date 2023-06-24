<script setup lang="ts">
  import { RouterLink, RouterView } from 'vue-router'
  import BackIcon from './components/icons/BackIcon.vue'
  //import BiographyIcon from './components/icons/BiographyIcon.vue'
  import BlogIcon from './components/icons/BlogIcon.vue'
  //import ContactIcon from './components/icons/ContactIcon.vue'
  import HelikiaIcon from './components/icons/HelikiaIcon.vue'
  //import HesychiaIcon from './components/icons/HesychiaIcon.vue'
  import SynergiaIcon from './components/icons/SynergiaIcon.vue'
</script>

<script lang="ts">
  export default {
    data() {
      return {
        appWidth: 0,
        appHeight: 0,
        menuOpened: false,
        menuSelection: 0,
        menuWindow: [2, 0],
        menuItemCount: 3
      }
    },
    computed: {
      headerStyle() {
        return {
            'snrg-menu-opened': this.menuOpened
          }
      },
      menuStyle() {
        return {
            '--snrg-menu-window-length': this.menuWindow.length
          }
      }
    },
    methods: {
      menuItemShown(menuItemId: number) {
        return (!this.menuOpened && this.menuSelection === menuItemId) || (this.menuOpened && this.menuWindow.includes(menuItemId))
      },
      menuItemStyle(menuItemId: number) {
        let itemIndex = this.menuWindow.indexOf(menuItemId)
        return {
            '--snrg-menu-item-position': this.menuOpened ? (itemIndex === -1 ? this.menuWindow.length : this.menuWindow.length - 1 - this.menuWindow.indexOf(menuItemId)) : 0
          }
      },
      closeMenu() {
        if (this.menuOpened) {
          this.menuOpened = false;
        }
      },
      openMenuOrSelect(menuItemId: number) {
        if (this.menuOpened) {
          if (menuItemId === this.menuSelection) {
            this.menuOpened = false
          } else {
            this.menuSelection = menuItemId
          }
        } else {
          this.menuOpened = true
        }
      },
      slideMenuWindow() {
        let slidingLength = this.menuWindow.length - 1
        this.menuWindow.splice(1, slidingLength)
        this.menuWindow.unshift(...Array(slidingLength).fill(this.menuWindow[0]).map((value, index) => (value - (slidingLength - index) + this.menuItemCount) % this.menuItemCount))
      }
    }
  }
</script>

<template>
  <header id="snrg-header" :class="headerStyle" @click="(event: Event) => closeMenu()">
    <nav :style="menuStyle">
      <BackIcon v-show="menuOpened && menuWindow.length < menuItemCount" @click="(event: Event) => { slideMenuWindow(); event.stopPropagation(); }"/>
      <RouterLink v-show="menuItemShown(0)" :style="menuItemStyle(0)" to="/" @click="(event: Event) => { openMenuOrSelect(0); event.stopPropagation(); }"><BlogIcon/></RouterLink>
      <!--<RouterLink v-show="menuItemShown(1)" :style="menuItemStyle(1)" to="/bio" @click="(event: Event) => { openMenuOrSelect(1); event.stopPropagation(); }"><BiographyIcon/></RouterLink>-->
      <RouterLink v-show="menuItemShown(2)" :style="menuItemStyle(2)" to="/helikia"  @click="(event: Event) => { openMenuOrSelect(2); event.stopPropagation(); }"><HelikiaIcon/></RouterLink>
      <RouterLink v-show="menuItemShown(1)" :style="menuItemStyle(1)" to="/synergia"  @click="(event: Event) => { openMenuOrSelect(1); event.stopPropagation(); }"><SynergiaIcon/></RouterLink>
      <!--<RouterLink v-show="menuItemShown(4)" :style="menuItemStyle(4)" to="/hesychia"  @click="(event: Event) => { openMenuOrSelect(4); event.stopPropagation(); }"><HesychiaIcon/></RouterLink>-->
      <!--<RouterLink v-show="menuItemShown(5)" :style="menuItemStyle(5)" to="/contact"  @click="(event: Event) => { openMenuOrSelect(5); event.stopPropagation(); }"><ContactIcon/></RouterLink>-->
    </nav>
  </header>
  <main id="snrg-main">
    <RouterView v-slot="{ Component }">
      <KeepAlive>
        <component :is="Component" />
      </KeepAlive>
    </RouterView>
  </main>
</template>

<style scoped>
  header#snrg-header {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 1;
  }
  header#snrg-header.snrg-menu-opened {
    bottom: 0;
    left: 0;
  }
  header#snrg-header > nav {
    --pj-menu-item-width: 80px;
    --pj-menu-item-gap: 10px;
    --pj-menu-center: 75px;
    position: absolute;
    top: 0;
    right: 0;
    height: calc(2 * var(--pj-menu-center));
  }
  header#snrg-header > nav > :is(svg, a) {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
  }
  header#snrg-header > nav > svg {
    right: calc(var(--snrg-menu-window-length) * (var(--pj-menu-item-width) + var(--pj-menu-item-gap)));
    width: calc(0.5 * var(--pj-menu-item-width));
    height: auto;
  }
  header#snrg-header > nav > a {
    right: calc(var(--snrg-menu-item-position) * (var(--pj-menu-item-width) + var(--pj-menu-item-gap)));
    width: var(--pj-menu-item-width);
    display: inline-flex;
  }
  main#snrg-main {
    position: relative;
    z-index: 0;
  }
</style>
