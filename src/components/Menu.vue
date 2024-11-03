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
  import ContactIcon from '@/components/icons/ContactIcon.vue'
  import ThemeIcon from '@/components/icons/ThemeIcon.vue'
  import HomeIcon from '@/components/icons/HomeIcon.vue'
  import HelikiaIcon from '@/components/icons/HelikiaIcon.vue'
  import HesychiaIcon from '@/components/icons/HesychiaIcon.vue'
  import AccountIcon from '@/components/icons/AccountIcon.vue'

  const props = defineProps< { scrollDirection: null | ScrollDirection } >()

  const menu = inject( iMenu ) as IMenu

  const route = useRoute()
  const themeStore = useThemeStore()

  const hesychiaUrl = ref( '' )

  const classes = computed( () => [ { 'snrg-opened': menu.opened.value }, { 'snrg-down': props.scrollDirection === ScrollDirection.DOWN } ] )
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
          onClick: () => {}
        },
      {
          class: 'snrg-synergia-link',
          icon: SynergiaIcon,
          label: 'Synergia',
          link: constants.route.helikia.synergia.fullPath,
          external: false,
          condition: ! menu.opened.value && isHelikiaView.value && ! isSynergiaView.value,
          onClick: () => {}
        },
      {
          class: 'snrg-theme-button',
          icon: ThemeIcon,
          label: 'Mode nuit',
          link: '',
          external: false,
          condition: ! menu.opened.value && isAccountView.value,
          onClick: () => { themeStore.toggle() }
        },
      {
          class: 'snrg-contact-link',
          icon: ContactIcon,
          label: 'Contact',
          link: '',
          external: false,
          condition: ! menu.opened.value && isPaddyView.value,
          onClick: () => {}
        },
      {
          class: 'snrg-home-link',
          icon: HomeIcon,
          label: 'Paddy Fontaine',
          link: constants.route.paddy.fullPath,
          external: false,
          condition: ! menu.opened.value && ! isPaddyHomeView.value,
          onClick: () => {}
        },
      {
          class: 'snrg-helikia-link',
          icon: HelikiaIcon,
          label: 'Helikia',
          link: constants.route.helikia.fullPath,
          external: false,
          condition: ! menu.opened.value && ! isHelikiaHomeView.value,
          onClick: () => {}
        },
      {
          class: 'snrg-hesychia-link',
          icon: HesychiaIcon,
          label: 'Cap Hesychia',
          link: hesychiaUrl.value,
          external: true,
          condition: ! menu.opened.value,
          onClick: () => {}
        },
      {
          class: 'snrg-account-link',
          icon: AccountIcon,
          label: 'Compte',
          link: constants.route.account.fullPath,
          external: false,
          condition: ! menu.opened.value && ! isAccountView.value,
          onClick: () => {}
        }
    ] )

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
    <button key="Menu" class="snrg-menu-button" type="button" @click="menu.openOrClose" data-snrg-label="Menu"><MenuIcon /></button>
    <template v-for="button in buttons" :key="button.label">
      <a v-if="button.condition && button.link && button.external" :class="button.class" :href="button.link" :data-snrg-label="button.label" target="_blank" rel="noopener noreferrer"><component :is="button.icon" /></a>
      <RouterLink v-else-if="button.condition && button.link && ! button.external" :class="button.class" :to="button.link" :data-snrg-label="button.label"><component :is="button.icon" /></RouterLink>
      <button v-else-if="button.condition && ! button.link" :class="button.class" type="button" @click="button.onClick" :data-snrg-label="button.label"><component :is="button.icon" /></button>
    </template>
  </TransitionGroup>
</template>

<style scoped>
  nav.snrg-menu {
    --snrg-menu-button-hue: var(--snrg-background-hue);
    --snrg-menu-button-saturation: 0%;
    --snrg-menu-button-lightness: (var(--snrg-background-lightness) - (var(--snrg-light-sign)) * 25%);
    --snrg-menu-button-opacity: 0.5;
    --snrg-menu-button-blur: 5px;
    --snrg-menu-button-border-hue: var(--snrg-menu-button-hue);
    --snrg-menu-button-border-saturation: 100%;
    --snrg-menu-button-border-opacity: 0.15;
    --snrg-menu-button-border-lightness: 95%;
    --snrg-menu-button-size: (0.85 * var(--snrg-h1-size));
    --snrg-menu-button-gap: (0.25 * var(--snrg-h1-size));
    --snrg-menu-icon-hue: var(--snrg-text-hue);
    --snrg-menu-icon-saturation: var(--SNRG-TEXT-SATURATION);
    --snrg-menu-icon-lightness: var(--snrg-text-lightness);
    --snrg-menu-top: 1rem;
    position: absolute;
    left: var(--snrg-outer-margin);
    top: var(--snrg-menu-top);
    z-index: 1;
    display: inline-flex;
  }

  div#snrg-app[data-snrg-route='/'] nav.snrg-menu {
    --snrg-menu-button-hue: var(--SNRG-PADDY-HUE);
  }

  div#snrg-app[data-snrg-route='/helikia'] nav.snrg-menu {
    --snrg-menu-button-hue: var(--SNRG-HELIKIA-HUE);
  }

  div#snrg-app[data-snrg-route='/compte'] nav.snrg-menu {
    --snrg-menu-button-hue: var(--SNRG-ACCOUNT-HUE);
  }

  nav.snrg-menu a.snrg-home-link {
    --snrg-menu-icon-hue: var(--SNRG-PADDY-HUE);
  }

  nav.snrg-menu a.snrg-helikia-link {
    --snrg-menu-icon-hue: var(--SNRG-HELIKIA-HUE);
  }

  nav.snrg-menu a.snrg-hesychia-link {
    --snrg-menu-icon-hue: var(--SNRG-HESYCHIA-HUE);
  }

  nav.snrg-menu a.snrg-account-link {
    --snrg-menu-icon-hue: var(--SNRG-ACCOUNT-HUE);
  }

  div#snrg-app nav.snrg-menu > :is(a, button) {
    display: inline-flex;
    border: 1px solid hsl(var(--snrg-menu-button-border-hue) var(--snrg-menu-button-border-saturation) var(--snrg-menu-button-border-lightness) / var(--snrg-menu-button-border-opacity));
    border-radius: 50%;
    background-color: hsl(var(--snrg-menu-button-hue) var(--snrg-menu-button-saturation) calc(var(--snrg-menu-button-lightness)) / var(--snrg-menu-button-opacity));
    box-shadow: 0 3px 6px hsl(0 0% 0% / 0.15), 0 3px 6px hsl(0 0% 0% / 0.25);
  }

  nav.snrg-menu > :is(a, button) {
    width: calc(var(--snrg-menu-button-size));
    height: calc(var(--snrg-menu-button-size));
    justify-content: center;
    align-items: center;
    -webkit-backdrop-filter: blur(var(--snrg-menu-button-blur));
    backdrop-filter: blur(var(--snrg-menu-button-blur));
  }

  nav.snrg-menu > :is(a, button):is(.snrg-enter-from, .snrg-leave-to) {
    width: 0;
    opacity: 0;
  }

  nav.snrg-menu > a,
  div#snrg-app nav.snrg-menu > button:not(.snrg-menu-button) {
    margin-left: calc(var(--snrg-menu-button-gap));
  }

  nav.snrg-menu > a:is(.snrg-enter-from, .snrg-leave-to),
  div#snrg-app nav.snrg-menu > button:not(.snrg-menu-button):is(.snrg-enter-from, .snrg-leave-to) {
    margin-left: 0;
  }

  div#snrg-app nav.snrg-menu > :is(a, button).snrg-enter-active {
    transition:
      margin-left var(--SNRG-HEADER-TRANSITION-DURATION) var(--SNRG-HEADER-TRANSITION-TIMING) var(--SNRG-HEADER-TRANSITION-DURATION),
      width var(--SNRG-HEADER-TRANSITION-DURATION) var(--SNRG-HEADER-TRANSITION-TIMING) var(--SNRG-HEADER-TRANSITION-DURATION),
      opacity calc(2/3 * var(--SNRG-HEADER-TRANSITION-DURATION)) var(--SNRG-HEADER-TRANSITION-TIMING) calc(4/3 * var(--SNRG-HEADER-TRANSITION-DURATION));
  }

  div#snrg-app nav.snrg-menu > :is(a, button).snrg-leave-active {
    transition:
      margin-left var(--SNRG-HEADER-TRANSITION-DURATION) var(--SNRG-HEADER-TRANSITION-TIMING),
      width var(--SNRG-HEADER-TRANSITION-DURATION) var(--SNRG-HEADER-TRANSITION-TIMING),
      opacity calc(2/3 * var(--SNRG-HEADER-TRANSITION-DURATION)) var(--SNRG-HEADER-TRANSITION-TIMING);
  }

  nav.snrg-menu > :is(a, button) > svg {
    width: 60%;
    height: auto;
  }

  nav.snrg-menu > :is(a, button) > svg :deep(:is(.snrg-stroke, .snrg-fill)) {
    fill: hsl(var(--snrg-menu-icon-hue) var(--snrg-menu-icon-saturation) calc(var(--snrg-menu-icon-lightness)));
  }

  nav.snrg-menu > :is(a, button) > svg :deep(.snrg-fill) {
    --snrg-menu-icon-lightness: (var(--snrg-text-lightness) + (var(--snrg-light-sign)) * 25%);
  }

  nav.snrg-menu > :is(a, button) > svg :deep(.snrg-fill),
  nav.snrg-menu > :is(a, button):hover > svg :deep(.snrg-stroke),
  nav.snrg-menu > :is(a, button):is(.snrg-home-link, .snrg-helikia-link, .snrg-hesychia-link, .snrg-account-link) > svg :deep(.snrg-stroke),
  nav.snrg-menu > :is(a, button):is(.snrg-home-link, .snrg-helikia-link, .snrg-hesychia-link, .snrg-account-link):hover > svg :deep(.snrg-fill),
  nav.snrg-menu.snrg-opened > button.snrg-menu-button:hover > svg :deep(.snrg-fill),
  div#snrg-app:is([data-snrg-theme='dark'], [data-snrg-route='/']) nav.snrg-menu > button.snrg-theme-button:hover > svg :deep(.snrg-fill) {
    fill-opacity: 0;
  }

  nav.snrg-menu > :is(a, button) > svg :deep(.snrg-stroke),
  nav.snrg-menu > :is(a, button):hover > svg :deep(.snrg-fill),
  nav.snrg-menu > :is(a, button):is(.snrg-home-link, .snrg-helikia-link, .snrg-hesychia-link, .snrg-account-link) > svg :deep(.snrg-fill),
  nav.snrg-menu > :is(a, button):is(.snrg-home-link, .snrg-helikia-link, .snrg-hesychia-link, .snrg-account-link):hover > svg :deep(.snrg-stroke),
  nav.snrg-menu.snrg-opened > button.snrg-menu-button > svg :deep(.snrg-fill),
  nav.snrg-menu.snrg-opened > button.snrg-menu-button:hover > svg :deep(.snrg-stroke),
  div#snrg-app:is([data-snrg-theme='dark'], [data-snrg-route='/']) nav.snrg-menu > button.snrg-theme-button > svg :deep(.snrg-fill),
  div#snrg-app:is([data-snrg-theme='dark'], [data-snrg-route='/']) nav.snrg-menu > button.snrg-theme-button:hover > svg :deep(.snrg-stroke) {
    fill-opacity: 1;
  }
</style>