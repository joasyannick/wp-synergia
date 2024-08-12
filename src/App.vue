<script setup lang="ts">
  import { ref, provide , watch, onMounted, onUnmounted } from 'vue'
  import { RouterView, useRoute } from 'vue-router'
  import { storeToRefs } from 'pinia'
  import { throttle } from 'throttle-debounce'
  import { iMenu } from '@/injection'
  import { useThemeStore } from '@/stores/theme'
  import AppHeader from '@/components/AppHeader.vue'

  const route = useRoute()
  const { theme } = storeToRefs( useThemeStore() )

  const menuOpened = ref( false )
  const appElement = ref( null as null | HTMLDivElement )

  const openOrCloseMenu = () => { menuOpened.value = ! menuOpened.value }

  const updateMargins = () => {
      const viewportWidth = Math.max( document.documentElement.clientWidth || 0, window.innerWidth || 0 )
      if ( viewportWidth < 396 ) {
        appElement.value!.style.setProperty( '--snrg-margin', '1.125rem' )
      } else if ( viewportWidth < 1584 ) {
        appElement.value!.style.setProperty( '--snrg-margin', ( ( ( 7 / 31049568 ) * viewportWidth * viewportWidth * viewportWidth - ( 7 / 26136 ) * viewportWidth * viewportWidth + ( 7 / 66 ) * viewportWidth + 4 ) / 16 ) + 'rem' )
      } else {
        appElement.value!.style.setProperty( '--snrg-margin', ( ( 0.25 * viewportWidth ) / 16 ) + 'rem' )
      }
    }

  const onResize = throttle( 100, updateMargins )

  provide( iMenu, { opened: menuOpened, openOrClose: openOrCloseMenu } )

  watch( () => route.path, ( now ) => {
      if ( appElement.value ) {
        appElement.value.dataset.snrgRoute = now
      }
    } )
  
  watch( theme, ( now ) => {
      if ( appElement.value ) {
        appElement.value.dataset.snrgRoute = now
      }
    } )

  onMounted( () => {
      appElement.value!.dataset.snrgRoute = route.path
      appElement.value!.dataset.snrgTheme = theme.value
      updateMargins()
      window.addEventListener( 'resize', onResize )
    } )

  onUnmounted( () => window.removeEventListener( 'resize', onResize ) )
</script>

<template>
  <div id="snrg-app" ref="appElement">
    <AppHeader />
    <RouterView />
  </div>
</template>

<style lang="scss">
  @use "sass:math";

  @function snrg-strip-unit( $number ) {
    @if type-of( $number ) == 'number' and not unitless( $number ) {
      @return math.div( $number, ( $number * 0 + 1 ) );
    }
    @return $number;
  }

  @function snrg-linear-coefficient( $min-viewport-width, $value-for-min-viewport-width, $max-viewport-width, $value-for-max-viewport-width ) {
    @return math.div( ( snrg-strip-unit( $value-for-max-viewport-width ) - snrg-strip-unit( $value-for-min-viewport-width ) ), ( snrg-strip-unit( $max-viewport-width ) - snrg-strip-unit( $min-viewport-width ) ) );
  }

  @function snrg-linear-value( $initial-value, $viewport-width, $min-viewport-width, $value-for-min-viewport-width, $max-viewport-width, $value-for-max-viewport-width ) {
    @return  $initial-value + ( $viewport-width - $min-viewport-width ) * snrg-linear-coefficient( $min-viewport-width, $value-for-min-viewport-width, $max-viewport-width, $value-for-max-viewport-width );
  }

  @function snrg-linear-expression( $initial-value, $viewport-width, $min-viewport-width, $value-for-min-viewport-width, $max-viewport-width, $value-for-max-viewport-width ) {
    @return  #{ $initial-value } + ' + ( ' + #{ $viewport-width } + ' - ' + #{ $min-viewport-width } + ' ) * ' + #{ snrg-linear-coefficient( $min-viewport-width, $value-for-min-viewport-width, $max-viewport-width, $value-for-max-viewport-width ) };
  }

  @function snrg-font-size-coefficient( $initial-value, $padding-coefficient, $initial-padding, $min-viewport-width ) {
    @return math.div( ( 1 - 2 * $padding-coefficient ) * $initial-value, snrg-strip-unit( $min-viewport-width ) - 2 * $initial-padding );
  }

  @function snrg-font-size-expression( $initial-value, $padding-coefficient, $initial-padding, $viewport-width, $min-viewport-width ) {
    @return #{ $initial-value } + ' + ( ' + #{ $viewport-width } + ' - ' + #{ $min-viewport-width } + ' ) * ' + #{ snrg-font-size-coefficient( $initial-value, $padding-coefficient, $initial-padding, $min-viewport-width ) };
  }

  $major-second: 1.125;
  $minor-third: 1.2;
  $snrg-padding-until-396px: 18px;
  $snrg-padding-at-1584px: snrg-linear-value( $snrg-padding-until-396px, 1584px, 396px, $snrg-padding-until-396px, 1584px, math.div( 1584px, 4 ) );
  $snrg-padding-coefficient-at-1584px: snrg-linear-coefficient( 396px, $snrg-padding-until-396px, 1584px, math.div( 1584px, 4 ) );
  $snrg-nunito-sans-size-until-1584px: 18px;
  $snrg-roboto-ratio: 0.9;

  div#snrg-app {
    --SNRG-BACKGROUND-HUE: 225;
    --SNRG-BACKGROUND-SATURATION: 70%;
    --SNRG-TEXT-HUE: 210;
    --SNRG-TEXT-SATURATION: 29%;
    --SNRG-DARK-FILTER: invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%);
    --snrg-menu-height: 2rem;
    --snrg-menu-top: 1rem;
    --snrg-menu-left: 1rem;
    position: relative;
    background: hsl(var(--SNRG-BACKGROUND-HUE), var(--SNRG-BACKGROUND-SATURATION), var(--snrg-background-lightness));
    color: hsl(var(--SNRG-TEXT-HUE), var(--SNRG-TEXT-SATURATION), var(--snrg-text-lightness));
    font: 1.125rem/calc(5/3) 'Nunito Sans';
  }

  div#snrg-app[data-snrg-theme='light'] {
    --snrg-light-sign: 1;
    --snrg-background-lightness: 100%;
    --snrg-text-lightness: 24.3%;
  }

  div#snrg-app:is([data-snrg-theme='dark'], [data-snrg-route='/']) {
    --snrg-light-sign: -1;
    --snrg-background-lightness: 10%;
    --snrg-text-lightness: 92.2%;
  }

  div#snrg-app {
    --snrg-font-size: #{ $snrg-nunito-sans-size-until-1584px };
  }

  $snrg-heading-coefficient: 1;
  @each $heading-level in 3, 2, 1 {
    $snrg-heading-coefficient: $major-second * $major-second * $snrg-heading-coefficient;
    div#snrg-app {
      --snrg-heading-font-size-#{ $heading-level }: #{ $snrg-nunito-sans-size-until-1584px * $snrg-roboto-ratio * $snrg-heading-coefficient };
    }
  }

  @each $heading-level in 4, 5, 6 {
    div#snrg-app {
      --snrg-heading-font-size-#{ $heading-level }: #{ $snrg-nunito-sans-size-until-1584px * $snrg-roboto-ratio };
    }
  }

  div#snrg-app :is(button, h1, h2, h3, h4, h5, h6) {
    font-family: 'Roboto', sans-serif;
  }

  div#snrg-app :is(h1, h2, h3, h4, h5, h6) {
    font-weight: 500;
  }

  @media screen and (min-width: 396px) {
    $snrg-initial-heading-coefficient: 1;
    $snrg-final-heading-coefficient: 1;
    @each $heading-level in 3, 2, 1 {
      $snrg-initial-heading-coefficient: $major-second * $major-second * $snrg-initial-heading-coefficient;
      $snrg-initial-heading-size: $snrg-nunito-sans-size-until-1584px * $snrg-roboto-ratio * $snrg-initial-heading-coefficient;
      $snrg-final-heading-coefficient: $minor-third * $minor-third * $snrg-final-heading-coefficient;
      $snrg-final-heading-size: $snrg-nunito-sans-size-until-1584px * $snrg-roboto-ratio * $snrg-final-heading-coefficient;
      div#snrg-app {
        --snrg-heading-font-size-#{ $heading-level }: #{ snrg-linear-expression( $snrg-initial-heading-size, 100vw, 396px, $snrg-initial-heading-size, 1584px, $snrg-final-heading-size ) };
      }
    }
  }

  @media screen and (min-width: 1584px) {
    div#snrg-app {
      --snrg-font-size: #{ snrg-font-size-expression( $snrg-nunito-sans-size-until-1584px, $snrg-padding-coefficient-at-1584px, $snrg-padding-at-1584px, 100vw, 1584px ) };
    }

    $snrg-heading-font-size: #{ $snrg-roboto-ratio } + ' * ( ' + snrg-font-size-expression( $snrg-nunito-sans-size-until-1584px, $snrg-padding-coefficient-at-1584px, $snrg-padding-at-1584px, 100vw, 1584px ) + ' )';
    @each $heading-level in 3, 2, 1 {
      $snrg-heading-font-size: #{ $minor-third } + ' * ' + #{ $minor-third } + ' * ' + $snrg-heading-font-size;
      div#snrg-app {
        --snrg-heading-font-size-#{ $heading-level }: #{ $snrg-heading-font-size };
      }
    }

    @each $heading-level in 4, 5, 6 {
      $snrg-heading-font-size: #{ $snrg-roboto-ratio } + ' * ' + '( ' + snrg-font-size-expression( $snrg-nunito-sans-size-until-1584px, $snrg-padding-coefficient-at-1584px, $snrg-padding-at-1584px, 100vw, 1584px ) + ' )';
      div#snrg-app {
        --snrg-heading-font-size-#{ $heading-level }: #{ $snrg-heading-font-size };
      }
    }
  }
</style>