<script setup lang="ts">
  import { inject, ref, computed } from 'vue'
  import { RouterLink, useRoute } from 'vue-router'
  import constants from '@/constants'
  import observers from '@/router/observers'
  import type { IMenu } from '@/injection'
  import { iMenu } from '@/injection'
  import { useThemeStore } from '@/stores/theme'
  import MenuIcon from '@/components/icons/MenuIcon.vue'
  import BiographyIcon from '@/components/icons/BiographyIcon.vue'
  import SynergiaIcon from '@/components/icons/SynergiaIcon.vue'
  import ThemeIcon from '@/components/icons/ThemeIcon.vue'
  import ContactIcon from '@/components/icons/ContactIcon.vue'
  import HomeIcon from '@/components/icons/HomeIcon.vue'
  import HelikiaIcon from '@/components/icons/HelikiaIcon.vue'
  import HesychiaIcon from '@/components/icons/HesychiaIcon.vue'
  import AccountIcon from '@/components/icons/AccountIcon.vue'

  const menu = inject( iMenu ) as IMenu

  const route = useRoute()
  const theme = useThemeStore()

  const menuIconAnimated = ref( false )
  const hesychiaUrl = ref( '' )

  const isPaddyView = computed( () => ! route.name ? false : observers.isPaddyView( route.name.toString() ) )
  const isBiographyView = computed( () => ! route.name ? false : observers.isBiographyView( route.name.toString() ) )
  const isHelikiaView = computed( () => ! route.name ? false : observers.isHelikiaView( route.name.toString() ) )
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
          class: 'snrg-contact-button',
          icon: ContactIcon,
          label: 'Contact',
          link: '',
          external: false,
          condition: ! menu.opened.value && isPaddyView.value,
          onClick: () => { return }
        },
      {
          class: 'snrg-home-link',
          icon: HomeIcon,
          label: 'Paddy Fontaine',
          link: constants.route.paddy.fullPath,
          external: false,
          condition: ! menu.opened.value,
          onClick: () => { return }
        },
      {
          class: 'snrg-helikia-link',
          icon: HelikiaIcon,
          label: 'Helikia',
          link: constants.route.helikia.fullPath,
          external: false,
          condition: ! menu.opened.value,
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
          condition: ! menu.opened.value,
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
  <TransitionGroup name="snrg" tag="nav" class="snrg-menu">
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
    --snrg-paddy-hue: var(--SNRG-BACKGROUND-HUE);
    --snrg-helikia-hue: 30;
    --snrg-hesychia-hue: 285;
    --snrg-account-hue: 75;
    --snrg-menu-top: 1rem;
    --snrg-menu-button-width: var(--snrg-menu-height);
    --snrg-menu-button-gap: 0.25rem;
    --snrg-header-lightness-1: (var(--snrg-background-lightness) - (var(--snrg-light-sign) * 30%));
    --snrg-header-lightness-2: (var(--snrg-header-lightness-1) - (var(--snrg-light-sign) * 30%));
    position: absolute;
    left: var(--snrg-outer-margin);
    top: var(--snrg-menu-top);
    z-index: 1;
    display: inline-flex;
  }

  div#snrg-app[data-snrg-route^='/'] nav.snrg-menu,
  nav.snrg-menu a.snrg-home-link {
    --snrg-menu-hue: var(--snrg-paddy-hue);
  }

  div#snrg-app[data-snrg-route^='/helikia'] nav.snrg-menu,
  nav.snrg-menu a.snrg-helikia-link {
    --snrg-menu-hue: var(--snrg-helikia-hue);
  }

  nav.snrg-menu a.snrg-hesychia-link {
    --snrg-menu-hue: var(--snrg-hesychia-hue);
  }

  div#snrg-app[data-snrg-route^='/compte'] nav.snrg-menu,
  nav.snrg-menu a.snrg-account-link {
    --snrg-menu-hue: var(--snrg-account-hue);
  }

  nav.snrg-menu :is( a, button ) {
    display: inline-flex;
    border-radius: 50%;
    width: var(--snrg-menu-button-width);
    height: var(--snrg-menu-height);
    justify-content: center;
    align-items: center;
    background: hsl(var(--snrg-menu-hue), calc(var(--snrg-button-saturation)), var(--snrg-button-lightness));
  }

  nav.snrg-menu :is( a, button ) > svg {
    width: 55%;
    height: 55%;
    fill: hsl(var(--snrg-menu-hue), var(--SNRG-BACKGROUND-SATURATION), var(--snrg-background-lightness));
  }

  nav.snrg-menu > :is( a, button ):not( :first-child ) {
    margin-left: var(--snrg-menu-button-gap);
  }

  nav.snrg-menu > :is( a, button ).snrg-enter-active {
    transition: margin-left var(--snrg-menu-transition-duration) ease-in var(--snrg-menu-transition-duration), width var(--snrg-menu-transition-duration) ease-in var(--snrg-menu-transition-duration), opacity var(--snrg-menu-transition-duration) ease-in var(--snrg-menu-transition-duration);
  }

  nav.snrg-menu > :is( a, button ).snrg-leave-active {
    transition: margin-left var(--snrg-menu-transition-duration) ease-in, width var(--snrg-menu-transition-duration) ease-in, opacity var(--snrg-menu-transition-duration) ease-in;
  }

  nav.snrg-menu > :is( a, button ).snrg-enter-from,
  nav.snrg-menu > :is( a, button ).snrg-leave-to {
    width: 0;
    opacity: 0;
  }

  nav.snrg-menu > :is( a, button ):not( :first-child ).snrg-enter-from,
  nav.snrg-menu > :is( a, button ):not( :first-child ).snrg-leave-to {
    margin-left: 0;
  }
</style>