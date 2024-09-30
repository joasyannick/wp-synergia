<script setup lang="ts">
  import { inject, ref, computed } from 'vue'
  import { RouterLink, useRoute } from 'vue-router'
  import constants from '@/constants'
  import observers from '@/router/observers'
  import type { IMenu } from '@/injection'
  import { ScrollDirection } from '@/types'
  import { iMenu } from '@/injection'
  import { useThemeStore } from '@/stores/theme'
  import MenuIcon from '@/components/icons/MenuIcon.vue'
  import BiographyIcon from '@/components/icons/BiographyIcon.vue'
  import SynergiaIcon from '@/components/icons/SynergiaIcon.vue'
  import ThemeIcon from '@/components/icons/ThemeIcon.vue'
  import HomeIcon from '@/components/icons/HomeIcon.vue'
  import HelikiaIcon from '@/components/icons/HelikiaIcon.vue'
  import HesychiaIcon from '@/components/icons/HesychiaIcon.vue'
  import AccountIcon from '@/components/icons/AccountIcon.vue'

  const props = defineProps< { scrollDirection: null | ScrollDirection } >()

  const menu = inject( iMenu ) as IMenu

  const route = useRoute()
  const theme = useThemeStore()

  const menuIconAnimated = ref( false )
  const hesychiaUrl = ref( '' )

  const classes = computed( () => [ { 'snrg-down': props.scrollDirection === ScrollDirection.DOWN } ] )

  const isPaddyView = computed( () => ! route.name ? false : observers.isPaddyView( route.name.toString() ) )
  const isPaddyHomeView = computed( () => ! route.name ? false : observers.isPaddyHomeView( route.name.toString() ) )
  const isBiographyView = computed( () => ! route.name ? false : observers.isBiographyView( route.name.toString() ) )
  const isHelikiaView = computed( () => ! route.name ? false : observers.isHelikiaView( route.name.toString() ) )
  const isHelikiaHomeView = computed( () => ! route.name ? false : observers.isHelikiaHomeView( route.name.toString() ) )
  const isSynergiaView = computed( () => ! route.name ? false : observers.isSynergiaView( route.name.toString() ) )
  const isAccountView = computed( () => ! route.name ? false : observers.isAccountView( route.name.toString() ) )
  const buttons = computed( () => [
      {
          class: 'snrg-biography-link',
          icon: BiographyIcon,
          label: 'Biographie',
          link: constants.route.paddy.biography.fullPath,
          external: false,
          condition: ! menu.opened.value && isPaddyView.value && ! isBiographyView.value,
          onClick: () => { return }
        },
      {
          class: 'snrg-synergia-link',
          icon: SynergiaIcon,
          label: 'Synergia',
          link: constants.route.helikia.synergia.fullPath,
          external: false,
          condition: ! menu.opened.value && isHelikiaView.value && ! isSynergiaView.value,
          onClick: () => { return }
        },
      {
          class: 'snrg-theme-button',
          icon: ThemeIcon,
          label: 'Mode nuit',
          link: '',
          external: false,
          condition: ! menu.opened.value && isAccountView.value,
          onClick: () => { theme.toggle() }
        },
      {
          class: 'snrg-home-link',
          icon: HomeIcon,
          label: 'Paddy Fontaine',
          link: constants.route.paddy.fullPath,
          external: false,
          condition: ! menu.opened.value && ! isPaddyHomeView.value,
          onClick: () => { return }
        },
      {
          class: 'snrg-helikia-link',
          icon: HelikiaIcon,
          label: 'Helikia',
          link: constants.route.helikia.fullPath,
          external: false,
          condition: ! menu.opened.value && ! isHelikiaHomeView.value,
          onClick: () => { return }
        },
      {
          class: 'snrg-hesychia-link',
          icon: HesychiaIcon,
          label: 'Cap Hesychia',
          link: hesychiaUrl.value,
          external: true,
          condition: ! menu.opened.value,
          onClick: () => { return }
        },
      {
          class: 'snrg-account-link',
          icon: AccountIcon,
          label: 'Compte',
          link: constants.route.account.fullPath,
          external: false,
          condition: ! menu.opened.value && ! isAccountView.value,
          onClick: () => { return }
        }
    ] )

  const openOrClose = () => { if ( ! menuIconAnimated.value ) { menu.openOrClose() } }
  const onMenuIconAnimated = ( state: boolean ) => { menuIconAnimated.value = state }
  const fetchHesychiaUrl = async () => {
      try {
          const response = await fetch( import.meta.env.VITE_WP_REST_URL + '/synergia/v1/hesychia-url' )
          hesychiaUrl.value = await response.json()
        } catch ( exception ) {
          console.error( 'Failed to fetch the URL of Cap Hesychia' )
        }
    }

  fetchHesychiaUrl()
</script>

<template>
  <TransitionGroup name="snrg" tag="nav" class="snrg-menu" :class="classes" >
    <button key="Menu" class="snrg-menu-button" type="button" @click="openOrClose" data-snrg-label="Menu"><MenuIcon :opened="menu.opened.value" @animated="onMenuIconAnimated" /></button>
    <template v-for="button in buttons" :key="button.label">
      <a v-if="button.condition && button.link && button.external" :class="button.class" :href="button.link" :data-snrg-label="button.label" target="_blank" rel="noopener noreferrer"><component :is="button.icon" /></a>
      <RouterLink v-else-if="button.condition && button.link && ! button.external" :class="button.class" :to="button.link" :data-snrg-label="button.label"><component :is="button.icon" /></RouterLink>
      <button v-else-if="button.condition && ! button.link" :class="button.class" type="button" @click="button.onClick" :data-snrg-label="button.label"><component :is="button.icon" /></button>
    </template>
  </TransitionGroup>
</template>

<style scoped>
  nav.snrg-menu {
    --SNRG-PADDY-HUE: var(--SNRG-BACKGROUND-HUE);
    --SNRG-HELIKIA-HUE: 30;
    --SNRG-HESYCHIA-HUE: 285;
    --SNRG-ACCOUNT-HUE: 75;
    --snrg-menu-top: 1rem;
    --snrg-menu-button-length: (0.85 * var(--snrg-h1-size));
    --snrg-menu-button-gap: (0.25 * var(--snrg-h1-size));
    --snrg-header-lightness-1: (var(--snrg-background-lightness) - (var(--snrg-light-sign) * 30%));
    --snrg-header-lightness-2: (var(--snrg-header-lightness-1) - (var(--snrg-light-sign) * 30%));
    position: absolute;
    left: var(--snrg-outer-margin);
    top: var(--snrg-menu-top);
    z-index: 1;
    display: inline-flex;
  }

  div#snrg-app[data-snrg-route^='/'] nav.snrg-menu, nav.snrg-menu a.snrg-home-link {
    --snrg-button-hue: var(--SNRG-PADDY-HUE);
  }

  div#snrg-app[data-snrg-route^='/helikia'] nav.snrg-menu, nav.snrg-menu a.snrg-helikia-link {
    --snrg-button-hue: var(--SNRG-HELIKIA-HUE);
  }

  nav.snrg-menu a.snrg-hesychia-link {
    --snrg-button-hue: var(--SNRG-HESYCHIA-HUE);
  }

  div#snrg-app[data-snrg-route^='/compte'] nav.snrg-menu, nav.snrg-menu a.snrg-account-link {
    --snrg-button-hue: var(--SNRG-ACCOUNT-HUE);
  }

  nav.snrg-menu > :is(a, button) {
    display: inline-flex;
    width: calc(var(--snrg-menu-button-length));
    height: calc(var(--snrg-menu-button-length));
    justify-content: center;
    align-items: center;
  }

  nav.snrg-menu > :is(a, button):is(.snrg-enter-from, .snrg-leave-to) {
    width: 0;
    opacity: 0;
  }

  nav.snrg-menu > :is(a, button):not(:first-child) {
    margin-left: calc(var(--snrg-menu-button-gap));
  }

  nav.snrg-menu > :is(a, button):not(:first-child):is(.snrg-enter-from, .snrg-leave-to) {
    margin-left: 0;
  }

  div#snrg-app nav.snrg-menu > :is(a, button).snrg-enter-active {
    transition:
      filter 0.5s ease,
      margin-left var(--snrg-menu-transition) ease-in-out var(--snrg-menu-transition),
      width var(--snrg-menu-transition) ease-in-out var(--snrg-menu-transition),
      opacity calc(2/3 * var(--snrg-menu-transition)) ease-in-out calc(4/3 * var(--snrg-menu-transition));
  }

  div#snrg-app nav.snrg-menu > :is(a, button).snrg-leave-active {
    transition:
      filter 0.5s ease,
      margin-left var(--snrg-menu-transition) ease-in-out,
      width var(--snrg-menu-transition) ease-in-out,
      opacity calc(2/3 * var(--snrg-menu-transition)) ease-in-out;
  }

  div#snrg-app nav.snrg-menu button.snrg-menu-button {
    --snrg-horizontal-button-radius: 50%;
    --snrg-button-shadow-radius: (1/3 * var(--snrg-menu-button-length));
    padding: initial;
  }

  div#snrg-app nav.snrg-menu button:not(.snrg-menu-button) {
    border-radius: initial;
    background-color: initial;
    padding: initial;
    color: transparent;
    box-shadow: initial;
  }

  nav.snrg-menu button.snrg-menu-button > svg {
    width: 55%;
    height: 55%;
  }

  nav.snrg-menu :is(a, button:not(.snrg-menu-button)) > svg {
    width: 75%;
    height: 75%;
    fill: hsl(var(--snrg-button-hue), calc(var(--snrg-button-saturation)), calc(var(--snrg-button-lightness)));
    transition: fill var(--SNRG-BUTTON-TRANSITION) ease;
  }

  nav.snrg-menu :is(a, button:not(.snrg-menu-button)):hover > svg {
    fill: hsl(var(--snrg-button-hue), calc(var(--snrg-button-saturation)), calc(var(--snrg-button-lightness-on-hover)));
  }
</style>