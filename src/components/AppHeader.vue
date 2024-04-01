<script setup lang="ts">
  import { ref, computed } from 'vue'
  import { RouterLink, useRoute } from 'vue-router'
  import constants from '@/constants'
  import { useThemeStore } from '@/stores/theme'
  import { useMenuStore } from '@/stores/menu'

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
          slot: 'search-icon'
        },
      {
          key: 2,
          condition: ( menuStore.enoughSpace || menuStore.opened ) && isPaddyView.value && ! isBiographyView.value,
          class: '',
          link: constants.route.paddy.biography.fullPath,
          label: 'Biographie',
          onClick: menuStore.close,
          slot: 'biography-icon'
        },
      {
          key: 3,
          condition: ( menuStore.enoughSpace || menuStore.opened ) && isPaddyView.value,
          class: '',
          link: '',
          label: 'Contact',
          onClick: themeStore.doSwitch,
          slot: 'contact-icon'
        },
      {
          key: 4,
          condition: ( menuStore.enoughSpace || menuStore.opened ) && isHelikiaView.value && ! isSynergiaView.value,
          class: '',
          link: constants.route.helikia.synergia.fullPath,
          label: 'Synergia',
          onClick: menuStore.close,
          slot: 'synergia-icon'
        },
      {
          key: 5,
          condition: ( menuStore.enoughSpace || menuStore.opened ),
          class: 'snrg-paddy',
          link: constants.route.paddy.fullPath,
          label: 'Paddy Fontaine',
          onClick: menuStore.close,
          slot: 'paddy-icon'
        },
      {
          key: 6,
          condition: ( menuStore.enoughSpace || menuStore.opened ),
          class: 'snrg-helikia',
          link: constants.route.helikia.fullPath,
          label: 'Helikia',
          onClick: menuStore.close,
          slot: 'helikia-icon'
        },
      {
          key: 7,
          condition: ( menuStore.enoughSpace || menuStore.opened ),
          class: 'snrg-account',
          link: constants.route.account.fullPath,
          label: 'Compte',
          onClick: menuStore.close,
          slot: 'account-icon'
        },
      {
          key: 8,
          condition: ! menuStore.enoughSpace,
          class: 'snrg-menu',
          link: '',
          label: '',
          onClick: menuStore.openOrClose,
          slot: 'menu-icon'
        }
  ] )
</script>

<template>
  <TransitionGroup name="menu" tag="header" appear class="snrg-header" :class="cssClass" :style="cssStyle">
    <template v-for="button in menu" :key="button.key">
      <!--<button v-if="button.key % 2 === test" type="button" @click="test = (test + 1)%2">{{ button.key }}</button>-->
      <RouterLink v-if="button.condition && button.link" :class="button.class" :to="button.link" @click="button.onClick" :data-snrg-label="button.label"><slot :name="button.slot"></slot></RouterLink>
      <button v-else-if="button.condition && ! button.link" :class="button.class" type="button" @click="button.onClick" :data-snrg-label="button.label"><slot :name="button.slot"></slot></button>
    </template>
  </TransitionGroup>
</template>

<style scoped>
  header.snrg-header {
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

  header.snrg-header {
      --snrg-header-lightness-1: (var(--snrg-background-lightness) - (var(--snrg-light-sign) * 30%));
      --snrg-header-lightness-2: (var(--snrg-header-lightness-1) - (var(--snrg-light-sign) * 30%));
    }

  div#snrg-app[data-snrg-route^='/'] header.snrg-header {
      --snrg-header-hue: var(--snrg-header-paddy-hue);
    }

  div#snrg-app[data-snrg-route^='/helikia'] header.snrg-header {
      --snrg-header-hue: var(--snrg-header-helikia-hue);
    }

  div#snrg-app[data-snrg-route^='/account'] header.snrg-header {
      --snrg-header-hue: var(--snrg-header-account-hue);
    }

  header.snrg-header > :is(a, button) {
      all: unset;
      cursor: default;
      display: inline-flex;
      width: var( --snrg-menu-button-width );
      overflow: hidden;
      justify-content: center;
      align-items: center;
    }

  header.snrg-header > :is(a, button):not(:first-of-type) {
      margin-left: var( --snrg-menu-button-gap );
    }

  header.snrg-header > :is(a, button).menu-enter-active,
  header.snrg-header > :is(a, button).menu-leave-active {
      transition: margin-left 3s linear, width 3s linear, opacity 3s linear;
    }

  header.snrg-header > :is(a, button).menu-enter-from,
  header.snrg-header > :is(a, button).menu-leave-to {
      width: 0;
      opacity: 0;
    }

  header.snrg-header > :is(a, button).menu-enter-from:not( :first-of-type ),
  header.snrg-header > :is(a, button).menu-leave-to:not( :first-of-type ) {
      margin-left: 0;
    }

/*
  header.snrg-header :is(a, button) {
    all: unset;
  }

  header.snrg-header a {
    cursor: pointer;
  }



  header.snrg-header > nav > :is(a, button) {
    position: relative;
    box-sizing: border-box;
    width: var( --snrg-menu-button-width );
    height: var( --snrg-menu-button-width );
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
  }

  header.snrg-header > nav > :is(a, button):not( .snrg-paddy, .snrg-helikia, .snrg-theme ) {
    border: 1px solid hsl( var( --snrg-text-hue ), var( --snrg-text-saturation ), var( --snrg-text-lightness ) );
  }

  header.snrg-header > nav > a.snrg-paddy {
    background-color: hsl( 180, 100%, calc( var( --snrg-text-lightness ) + ( var( --snrg-light-sign ) * var( --snrg-menu-button-lightness-gap ) ) ) );
  }

  header.snrg-header > nav > a.snrg-helikia {
    background-color: hsl( 150, 100%, calc( var( --snrg-text-lightness ) + ( var( --snrg-light-sign ) * var( --snrg-menu-button-lightness-gap ) ) ) );
  }

  header.snrg-header > nav > button.snrg-theme {
    background-color: hsl( 50, 100%, calc( var( --snrg-text-lightness ) + ( var( --snrg-light-sign ) * var( --snrg-menu-button-lightness-gap ) ) ) );
  }

  header.snrg-header.snrg-menu-opened > nav > button.snrg-menu {
    border: none;
    background-color: hsl( 0, 100%, calc( var( --snrg-theme-lightness ) + (-1 * var( --snrg-light-sign ) * var( --snrg-menu-button-lightness-gap ) ) ) );
  }

  header.snrg-header > nav > :is( a, button ):is( .snrg-paddy, .snrg-helikia, .snrg-theme ) > svg {
    stroke: hsl( var( --snrg-background-hue ), var( --snrg-background-saturation ), var( --snrg-background-lightness ) );
  }

  header.snrg-header > nav > :is( a, button ) > svg {
    width: 55%;
    height: auto;
  }

  header.snrg-header > nav > :is( a, button )::after {
    content: attr( data-snrg-label );
    position: absolute;
    left: 50%;
    top: var( --snrg-menu-button-width );
    width: var( --snrg-max-menu-width );
    display: none;
    transform: translateX( -50% );
    text-align: center;
  }

  header.snrg-header > nav > :is( a, button ):hover::after {
    display: initial;
  }
  */
</style>