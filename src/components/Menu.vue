<script setup lang="ts">
  import { ref, computed } from 'vue'
  import { RouterLink, useRoute } from 'vue-router'
  import constants from '@/constants'
  import MenuIcon from '@/components/icons/MenuIcon.vue'
  import SearchIcon from '@/components/icons/SearchIcon.vue'
  import BiographyIcon from '@/components/icons/BiographyIcon.vue'
  import SynergiaIcon from '@/components/icons/SynergiaIcon.vue'
  import ContactIcon from '@/components/icons/ContactIcon.vue'
  import PaddyIcon from '@/components/icons/PaddyIcon.vue'
  import HelikiaIcon from '@/components/icons/HelikiaIcon.vue'
  import HesychiaIcon from '@/components/icons/HesychiaIcon.vue'
  import AccountIcon from '@/components/icons/AccountIcon.vue'

  const emit = defineEmits< { stateChanged: [ opened: boolean ] } >()

  const route = useRoute()

  const opened = ref( false )
  const menuAnimation = ref( false )

  const cssClass = computed( () => ( { 'snrg-opened': opened.value } ) )
  const isPaddyView = computed( () => ! route.name ? false : [ constants.route.paddy.name, constants.route.paddy.biography.name, constants.route.paddy.post.name ].includes( route.name.toString() ) )
  const isBiographyView = computed( () => route.name?.toString() === constants.route.paddy.biography.name )
  const isHelikiaView = computed( () => ! route.name ? false : [ constants.route.helikia.name, constants.route.helikia.synergia.name, constants.route.helikia.module.name, constants.route.helikia.session.name ].includes( route.name.toString() ) )
  const isSynergiaView = computed( () => route.name?.toString() === constants.route.helikia.synergia.name )

  const close = () => { if ( ! menuAnimation.value ) { opened.value = false; emit( 'stateChanged', opened.value ) } }
  const openOrClose = () => { if ( ! menuAnimation.value ) { opened.value = ! opened.value; emit( 'stateChanged', opened.value ) } }
  const onMenuAnimation = ( inProgress: boolean ) => { menuAnimation.value = inProgress }

  const menu = computed( () => [
      {
          key: 1,
          icon: SearchIcon,
          label: 'Rechercher',
          link: '',
          external: false,
          condition: opened.value && ( isPaddyView.value || isHelikiaView.value ),
          onClick: () => null
        },
      {
          key: 1,
          icon: BiographyIcon,
          label: 'Biographie',
          link: constants.route.paddy.biography.fullPath,
          external: false,
          condition: opened.value && isPaddyView.value && ! isBiographyView.value,
          onClick: close
        },
      {
          key: 3,
          icon: SynergiaIcon,
          label: 'Synergia',
          link: constants.route.helikia.synergia.fullPath,
          external: false,
          condition: opened.value && isHelikiaView.value && ! isSynergiaView.value,
          onClick: close
        },
      {
          key: 4,
          icon: ContactIcon,
          label: 'Contact',
          link: '',
          external: false,
          condition: opened.value,
          onClick: () => null
        },

      {
          key: 5,
          icon: PaddyIcon,
          label: 'Paddy Fontaine',
          link: constants.route.paddy.fullPath,
          external: false,
          condition: opened.value,
          onClick: close
        },
      {
          key: 6,
          icon: HelikiaIcon,
          label: 'Helikia',
          link: constants.route.helikia.fullPath,
          external: false,
          condition: opened.value,
          onClick: close
        },
      {
          key: 7,
          icon: HesychiaIcon,
          label: 'Cap Hesychia',
          link: 'https://cap-hesychia.fr/',
          external: true,
          condition: opened.value,
          onClick: close
        },
      {
          key: 8,
          icon: AccountIcon,
          label: 'Compte',
          link: constants.route.account.fullPath,
          external: false,
          condition: opened.value,
          onClick: close
        }
  ] )
</script>

<template>
  <nav class="snrg-menu" :class="cssClass">
    <button class="snrg-menu-button" type="button" @click="openOrClose" data-snrg-label="Menu"><MenuIcon :opened="opened" @animation="onMenuAnimation" /></button>
    <TransitionGroup name="menu" tag="span" class="snrg-menu-buttons" appear>
      <template v-for="button in menu" :key="button.key">
        <a v-if="button.condition && button.link && button.external" :href="button.link" @click="button.onClick" :data-snrg-label="button.label"><component :is="button.icon" /></a>
        <RouterLink v-else-if="button.condition && button.link && ! button.external" :to="button.link" @click="button.onClick" :data-snrg-label="button.label"><component :is="button.icon" /></RouterLink>
        <button v-else-if="button.condition && ! button.link" type="button" @click="button.onClick" :data-snrg-label="button.label"><component :is="button.icon" /></button>
      </template>
    </TransitionGroup>
  </nav>
</template>

<style scoped>
  nav.snrg-menu {
      --snrg-header-paddy-hue: 225;
      --snrg-header-helikia-hue: 30;
      --snrg-header-account-hue: 75;
      --snrg-menu-button-height: 2rem;
      --snrg-menu-button-width: var(--snrg-menu-button-height);
      --snrg-menu-button-gap: 0.5rem;
      --snrg-menu-top: 1rem;
      --snrg-menu-left: 1rem;
      --snrg-header-lightness-1: (var(--snrg-background-lightness) - (var(--snrg-light-sign) * 30%));
      --snrg-header-lightness-2: (var(--snrg-header-lightness-1) - (var(--snrg-light-sign) * 30%));
      width: 100vw;
      display: flex;
      padding: 1rem 0;
      align-items: center;
      justify-content: center;
    }

  div#snrg-app[data-snrg-route^='/'] nav.snrg-menu {
      --snrg-header-hue: var(--snrg-header-paddy-hue);
    }

  div#snrg-app[data-snrg-route^='/helikia'] nav.snrg-menu {
      --snrg-header-hue: var(--snrg-header-helikia-hue);
    }

  div#snrg-app[data-snrg-route^='/account'] nav.snrg-menu {
      --snrg-header-hue: var(--snrg-header-account-hue);
    }

  nav.snrg-menu :is(a, button) {
      all: unset;
      cursor: default;
      display: inline-flex;
      border-radius: 30%;
      width: var( --snrg-menu-button-width );
      height: var(--snrg-menu-button-height);
      justify-content: center;
      align-items: center;
    }

  nav.snrg-menu :is(a, button) > svg {
      width: 70%;
      height: 70%;
    }

  nav.snrg-menu > span.snrg-menu-buttons > :is(a, button) {
      margin-left: var( --snrg-menu-button-gap );
    }

  nav.snrg-menu > span.snrg-menu-buttons > :is(a, button).menu-enter-active {
      transition: margin-left 1s ease-in 1s, width 1s ease-in 1s, opacity 1s ease-in 1s;
    }

  nav.snrg-menu > span.snrg-menu-buttons > :is(a, button).menu-leave-active {
      transition: margin-left 1s ease-in, width 1s ease-in, opacity 1s ease-in;
    }

  nav.snrg-menu > span.snrg-menu-buttons > :is(a, button).menu-enter-from,
  nav.snrg-menu > span.snrg-menu-buttons > :is(a, button).menu-leave-to {
      width: 0;
      opacity: 0;
    }

  nav.snrg-menu > span.snrg-menu-buttons > :is(a, button).menu-enter-from,
  nav.snrg-menu > span.snrg-menu-buttons > :is(a, button).menu-leave-to {
      margin-left: 0;
    }
</style>