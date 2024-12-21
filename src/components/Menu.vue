<script setup lang="ts">
  import { inject, ref, computed, type Ref } from 'vue'
  import { RouterLink, useRoute } from 'vue-router'
  import * as constants from '@/constants'
  import * as observers from '@/router/observers'
  import type { IMenu } from '@/injection'
  import { iMenu, iScrollDirection } from '@/injection'
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

  const menu = inject( iMenu ) as IMenu
  const scrollDirection = inject( iScrollDirection ) as Ref< string >

  const route = useRoute()
  const themeStore = useThemeStore()

  const hesychiaUrl = ref( '' )

  const downscroll = computed( () => constants.DOWNWARD === scrollDirection.value )
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
          link: constants.BIOGRAPHY_FULL_PATH,
          external: false,
          condition: isPaddyView.value && ! isBiographyView.value,
          onClick: () => {}
        },
      {
          class: 'snrg-synergia-link',
          icon: SynergiaIcon,
          label: 'Synergia',
          link: constants.SYNERGIA_FULL_PATH,
          external: false,
          condition: isHelikiaView.value && ! isSynergiaView.value,
          onClick: () => {}
        },
      {
          class: 'snrg-theme-button',
          icon: ThemeIcon,
          label: 'Mode nuit',
          link: '',
          external: false,
          condition: isAccountView.value,
          onClick: () => { themeStore.toggle() }
        },
      {
          class: 'snrg-contact-link',
          icon: ContactIcon,
          label: 'Contact',
          link: '',
          external: false,
          condition: isPaddyView.value,
          onClick: () => {}
        },
      {
          class: 'snrg-home-link',
          icon: HomeIcon,
          label: 'Paddy Fontaine',
          link: constants.PADDY_FULL_PATH,
          external: false,
          condition: ! isPaddyHomeView.value,
          onClick: () => {}
        },
      {
          class: 'snrg-helikia-link',
          icon: HelikiaIcon,
          label: 'Helikia',
          link: constants.HELIKIA_FULL_PATH,
          external: false,
          condition: ! isHelikiaHomeView.value,
          onClick: () => {}
        },
      {
          class: 'snrg-hesychia-link',
          icon: HesychiaIcon,
          label: 'Cap Hesychia',
          link: hesychiaUrl.value,
          external: true,
          condition: hesychiaUrl.value,
          onClick: () => {}
        },
      {
          class: 'snrg-account-link',
          icon: AccountIcon,
          label: 'Compte',
          link: constants.ACCOUNT_FULL_PATH,
          external: false,
          condition: ! isAccountView.value,
          onClick: () => {}
        }
    ] )

  const fetchHesychiaUrl = async () => {
      try {
          const response = await fetch( import.meta.env.VITE_WP_REST_URL + '/synergia/v1/settings/hesychia-url' )
          hesychiaUrl.value = await response.json()
        } catch ( exception ) {
          console.error( 'Failed to fetch the URL of Cap Hesychia' )
        }
    }

  fetchHesychiaUrl()
</script>

<template>
  <TransitionGroup ref="menuRef" name="snrg" tag="nav" class="snrg-menu">
    <button key="Menu" class="snrg-menu-button" type="button" @click="menu.openOrClose" data-snrg-label="Menu"><MenuIcon /></button>
    <span class="snrg-transitioner" v-if="menu.opened.value"></span>
    <template v-for="button in buttons" :key="button.label">
      <a v-if="! menu.opened.value && ! downscroll && button.condition && button.link && button.external" :class="button.class" :href="button.link" :data-snrg-label="button.label" target="_blank" rel="noopener noreferrer"><component :is="button.icon" /></a>
      <RouterLink v-else-if="! menu.opened.value && ! downscroll && button.condition && button.link && ! button.external" :class="button.class" :to="button.link" :data-snrg-label="button.label"><component :is="button.icon" /></RouterLink>
      <button v-else-if="! menu.opened.value && ! downscroll && button.condition && ! button.link" :class="button.class" type="button" @click="button.onClick" :data-snrg-label="button.label"><component :is="button.icon" /></button>
    </template>
  </TransitionGroup>
</template>

<style scoped>
  nav.snrg-menu {
    --snrg-menu-button-hue: var(--snrg-background-hue);
    --snrg-menu-button-saturation: 10%;
    --snrg-menu-button-lightness: (var(--snrg-background-lightness) - 25% * (var(--snrg-light-sign)));
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

  div#snrg-app[data-snrg-route='/'] nav.snrg-menu,
  nav.snrg-menu > a.snrg-home-link:hover {
    --snrg-menu-button-hue: var(--SNRG-PADDY-HUE);
  }

  div#snrg-app[data-snrg-route='/helikia'] nav.snrg-menu,
  nav.snrg-menu > a.snrg-helikia-link:hover {
    --snrg-menu-button-hue: var(--SNRG-HELIKIA-HUE);
  }

  nav.snrg-menu > a.snrg-hesychia-link:hover {
    --snrg-menu-button-hue: var(--SNRG-HESYCHIA-HUE);
  }

  div#snrg-app[data-snrg-route='/compte'] nav.snrg-menu,
  nav.snrg-menu > a.snrg-account-link:hover {
    --snrg-menu-button-hue: var(--SNRG-ACCOUNT-HUE);
  }

  nav.snrg-menu > span.snrg-transitioner {
    display: none;
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
    /* Override div#snrg-app button */
    display: inline-flex;
    border: 1px solid hsl(var(--snrg-menu-button-border-hue) var(--snrg-menu-button-border-saturation) var(--snrg-menu-button-border-lightness) / var(--snrg-menu-button-border-opacity));
    border-radius: 50%;
    background-color: hsl(var(--snrg-menu-button-hue) var(--snrg-menu-button-saturation) calc(var(--snrg-menu-button-lightness)) / var(--snrg-menu-button-opacity));
    box-shadow: 0 3px 6px hsl(0 0% 0% / 0.15), 0 3px 6px hsl(0 0% 0% / 0.25);
    /* End of override */
    width: calc(var(--snrg-menu-button-size));
    height: calc(var(--snrg-menu-button-size));
    justify-content: center;
    align-items: center;
    -webkit-backdrop-filter: blur(var(--snrg-menu-button-blur));
    backdrop-filter: blur(var(--snrg-menu-button-blur));
  }

  div#snrg-app nav.snrg-menu > :is(a, button):hover {
    --snrg-menu-button-lightness: (var(--snrg-background-lightness) - 40% * (var(--snrg-light-sign)));
  }

  div#snrg-app nav.snrg-menu > :is(a, button):not(.snrg-menu-button) {
    margin-left: calc(var(--snrg-menu-button-gap));
  }

  div#snrg-app nav.snrg-menu > :is(span.snrg-transitioner, a, button):is(.snrg-enter-from, .snrg-leave-to) {
    opacity: 0;
  }

  div#snrg-app nav.snrg-menu > :is(a, button):is(.snrg-enter-from, .snrg-leave-to) {
    width: 0;
  }

  div#snrg-app nav.snrg-menu > :is(a, button):not(.snrg-menu-button):is(.snrg-enter-from, .snrg-leave-to) {
    margin-left: 0;
  }

  div#snrg-app nav.snrg-menu > span.snrg-transitioner:is(.snrg-enter-active, .snrg-leave-active) {
    transition: opacity calc(2 * var(--SNRG-HEADER-TRANSITION-DURATION));
  }

  div#snrg-app nav.snrg-menu > :is(a, button).snrg-enter-active {
    transition:
        margin-left var(--SNRG-HEADER-TRANSITION-TIMING) var(--SNRG-HEADER-TRANSITION-DURATION),
        width var(--SNRG-HEADER-TRANSITION-TIMING) var(--SNRG-HEADER-TRANSITION-DURATION),
        opacity var(--SNRG-HEADER-TRANSITION-TIMING) calc(4/3 * var(--SNRG-HEADER-TRANSITION-DURATION));
  }

  div#snrg-app nav.snrg-menu > span.snrg-transitioner ~ :is(a, button).snrg-enter-active {
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

  nav.snrg-menu > :is(a, button) > svg :deep(path) {
    fill: hsl(var(--snrg-menu-icon-hue) var(--snrg-menu-icon-saturation) calc(var(--snrg-menu-icon-lightness)));
  }
</style>