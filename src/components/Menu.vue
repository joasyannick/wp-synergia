<script setup lang="ts">
  import { ref, computed } from 'vue'
  import { RouterLink, useRoute } from 'vue-router'
  import constants from '@/constants'
  import { useThemeStore } from '@/stores/theme'
  import { useMenuStore } from '@/stores/menu'
  import SearchIcon from '@/components/icons/SearchIcon.vue'
  import BiographyIcon from '@/components/icons/BiographyIcon.vue'
  import ContactIcon from '@/components/icons/ContactIcon.vue'
  import SynergiaIcon from '@/components/icons/SynergiaIcon.vue'
  import PaddyIcon from '@/components/icons/PaddyIcon.vue'
  import HelikiaIcon from '@/components/icons/HelikiaIcon.vue'
  import AccountIcon from '@/components/icons/AccountIcon.vue'
  import MenuIcon from '@/components/icons/MenuIcon.vue'

  const cssStyle = {
      '--snrg-menu-button-width' : constants.menu.buttonWidth + constants.menu.unit,
      '--snrg-menu-button-gap' : constants.menu.buttonGap + constants.menu.unit,
      '--snrg-max-menu-width' : constants.menu.maxWidth + constants.menu.unit
    }

  const route = useRoute()
  const themeStore = useThemeStore()
  const menuStore = useMenuStore()

  const test = ref(0)

  const currentRoute = computed( () => route.name?.toString() )
  const isPaddyView = computed( () => ! currentRoute.value ? false : [ constants.route.paddy.name, constants.route.paddy.biography.name, constants.route.paddy.post.name ].includes( currentRoute.value ) )
  const isBiographyView = computed( () => currentRoute.value === constants.route.paddy.biography.name )
  const isHelikiaView = computed( () => ! currentRoute.value ? false : [ constants.route.helikia.name, constants.route.helikia.synergia.name, constants.route.helikia.module.name, constants.route.helikia.session.name ].includes( currentRoute.value ) )
  const isSynergiaView = computed( () => currentRoute.value === constants.route.helikia.synergia.name )
  const cssClass = computed( () => ( {
      'snrg-menu-opened' : menuStore.opened
    } ) )
  const themeLabel = computed( () => themeStore.isLight ? 'Nuit' : 'Jour' )
  const menu = computed( () => [
      {
          key: 1,
          condition: ( menuStore.enoughSpace || menuStore.opened ) && ( isPaddyView.value || isHelikiaView.value ),
          class: '',
          link: '',
          label: 'Rechercher',
          onClick: () => null,
          icon: SearchIcon
        },
      {
          key: 2,
          condition: ( menuStore.enoughSpace || menuStore.opened ) && isPaddyView.value && ! isBiographyView.value,
          class: '',
          link: constants.route.paddy.biography.fullPath,
          label: 'Biographie',
          onClick: menuStore.close,
          icon: BiographyIcon
        },
      {
          key: 3,
          condition: ( menuStore.enoughSpace || menuStore.opened ) && isPaddyView.value,
          class: '',
          link: '',
          label: 'Contact',
          onClick: themeStore.doSwitch,
          icon: ContactIcon
        },
      {
          key: 4,
          condition: ( menuStore.enoughSpace || menuStore.opened ) && isHelikiaView.value && ! isSynergiaView.value,
          class: '',
          link: constants.route.helikia.synergia.fullPath,
          label: 'Synergia',
          onClick: menuStore.close,
          icon: SynergiaIcon
        },
      {
          key: 5,
          condition: ( menuStore.enoughSpace || menuStore.opened ),
          class: 'snrg-paddy',
          link: constants.route.paddy.fullPath,
          label: 'Paddy Fontaine',
          onClick: menuStore.close,
          icon: PaddyIcon
        },
      {
          key: 6,
          condition: ( menuStore.enoughSpace || menuStore.opened ),
          class: 'snrg-helikia',
          link: constants.route.helikia.fullPath,
          label: 'Helikia',
          onClick: menuStore.close,
          icon: HelikiaIcon
        },
      {
          key: 7,
          condition: ( menuStore.enoughSpace || menuStore.opened ),
          class: 'snrg-account',
          link: constants.route.account.fullPath,
          label: 'Compte',
          onClick: menuStore.close,
          icon: AccountIcon
        },
      {
          key: 8,
          condition: ! menuStore.enoughSpace,
          class: 'snrg-menu',
          link: '',
          label: '',
          onClick: menuStore.openOrClose,
          icon: MenuIcon
        }
  ] )
</script>

<template>
  <TransitionGroup name="menu" tag="nav" appear class="snrg-menu" :class="cssClass" :style="cssStyle">
    <template v-for="button in menu" :key="button.key">
      <!--<button v-if="button.key % 2 === test" type="button" @click="test = (test + 1)%2">{{ button.key }}</button>-->
      <RouterLink v-if="button.condition && button.link" :class="button.class" :to="button.link" @click="button.onClick" :data-snrg-label="button.label"><component :is="button.icon" /></RouterLink>
      <button v-else-if="button.condition && ! button.link" :class="button.class" type="button" @click="button.onClick" :data-snrg-label="button.label"><component :is="button.icon" /></button>
    </template>
  </TransitionGroup>
</template>

<style scoped>
  nav.snrg-menu {
      --snrg-header-paddy-hue: 225;
      --snrg-header-helikia-hue: 30;
      --snrg-header-account-hue: 75;
      position: absolute;
      right: var( --snrg-horizontal-body-padding );
      top: 0;
      height: var( --snrg-header-height );
      z-index: 1;
      display: inline-flex;
      align-items: center;
    }

  nav.snrg-menu {
      --snrg-header-lightness-1: (var(--snrg-background-lightness) - (var(--snrg-light-sign) * 30%));
      --snrg-header-lightness-2: (var(--snrg-header-lightness-1) - (var(--snrg-light-sign) * 30%));
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

  nav.snrg-menu > :is(a, button) {
      all: unset;
      cursor: default;
      display: inline-flex;
      width: var( --snrg-menu-button-width );
      overflow: hidden;
      justify-content: center;
      align-items: center;
    }

  nav.snrg-menu > :is(a, button):not(:first-of-type) {
      margin-left: var( --snrg-menu-button-gap );
    }

  nav.snrg-menu > :is(a, button).menu-enter-active,
  nav.snrg-menu > :is(a, button).menu-leave-active {
      transition: margin-left 3s linear, width 3s linear, opacity 3s linear;
    }

  nav.snrg-menu > :is(a, button).menu-enter-from,
  nav.snrg-menu > :is(a, button).menu-leave-to {
      width: 0;
      opacity: 0;
    }

  nav.snrg-menu > :is(a, button).menu-enter-from:not( :first-of-type ),
  nav.snrg-menu > :is(a, button).menu-leave-to:not( :first-of-type ) {
      margin-left: 0;
    }

/*
  nav.snrg-menu :is(a, button) {
    all: unset;
  }

  nav.snrg-menu a {
    cursor: pointer;
  }



  nav.snrg-menu > nav > :is(a, button) {
    position: relative;
    box-sizing: border-box;
    width: var( --snrg-menu-button-width );
    height: var( --snrg-menu-button-width );
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
  }

  nav.snrg-menu > nav > :is(a, button):not( .snrg-paddy, .snrg-helikia, .snrg-theme ) {
    border: 1px solid hsl( var( --snrg-text-hue ), var( --snrg-text-saturation ), var( --snrg-text-lightness ) );
  }

  nav.snrg-menu > nav > a.snrg-paddy {
    background-color: hsl( 180, 100%, calc( var( --snrg-text-lightness ) + ( var( --snrg-light-sign ) * var( --snrg-menu-button-lightness-gap ) ) ) );
  }

  nav.snrg-menu > nav > a.snrg-helikia {
    background-color: hsl( 150, 100%, calc( var( --snrg-text-lightness ) + ( var( --snrg-light-sign ) * var( --snrg-menu-button-lightness-gap ) ) ) );
  }

  nav.snrg-menu > nav > button.snrg-theme {
    background-color: hsl( 50, 100%, calc( var( --snrg-text-lightness ) + ( var( --snrg-light-sign ) * var( --snrg-menu-button-lightness-gap ) ) ) );
  }

  nav.snrg-menu.snrg-menu-opened > nav > button.snrg-menu {
    border: none;
    background-color: hsl( 0, 100%, calc( var( --snrg-theme-lightness ) + (-1 * var( --snrg-light-sign ) * var( --snrg-menu-button-lightness-gap ) ) ) );
  }

  nav.snrg-menu > nav > :is( a, button ):is( .snrg-paddy, .snrg-helikia, .snrg-theme ) > svg {
    stroke: hsl( var( --snrg-background-hue ), var( --snrg-background-saturation ), var( --snrg-background-lightness ) );
  }

  nav.snrg-menu > nav > :is( a, button ) > svg {
    width: 55%;
    height: auto;
  }

  nav.snrg-menu > nav > :is( a, button )::after {
    content: attr( data-snrg-label );
    position: absolute;
    left: 50%;
    top: var( --snrg-menu-button-width );
    width: var( --snrg-max-menu-width );
    display: none;
    transform: translateX( -50% );
    text-align: center;
  }

  nav.snrg-menu > nav > :is( a, button ):hover::after {
    display: initial;
  }
  */
</style>