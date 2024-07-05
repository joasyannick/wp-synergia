<script setup lang="ts">
  import { ref, provide , watch } from 'vue'
  import { RouterView, useRoute } from 'vue-router'
  import { useThemeStore } from '@/stores/theme'
  import { iMenu } from '@/injection'
  import AppHeader from '@/components/AppHeader.vue'

  const route = useRoute()
  useThemeStore()

  const menuOpened = ref( false )

  const openOrCloseMenu = () => { menuOpened.value = ! menuOpened.value }

  provide( iMenu, { opened: menuOpened, openOrClose: openOrCloseMenu } )

  watch( () => route.path, ( now ) => document.getElementById( 'snrg-app' )!.dataset.snrgRoute = now, { immediate: true } )
</script>

<template>
  <AppHeader />
  <RouterView />
</template>

<style lang="scss">
  @use "sass:math";

  @function snrg-strip-unit( $number ) {
    @if type-of( $number ) == 'number' and not unitless( $number ) {
      @return math.div( $number, ( $number * 0 + 1 ) );
    }
    @return $number;
  }

  @function snrg-fluid-coefficient( $min-viewport-width, $value-for-min-viewport-width, $max-viewport-width, $value-for-max-viewport-width ) {
    @return math.div( ( snrg-strip-unit( $value-for-max-viewport-width ) - snrg-strip-unit( $value-for-min-viewport-width ) ), ( snrg-strip-unit( $max-viewport-width ) - snrg-strip-unit( $min-viewport-width ) ) );
  }

  @function snrg-fluid-value( $initial-value, $viewport-width, $min-viewport-width, $value-for-min-viewport-width, $max-viewport-width, $value-for-max-viewport-width ) {
    @return  $initial-value + ( $viewport-width - $min-viewport-width ) * snrg-fluid-coefficient( $min-viewport-width, $value-for-min-viewport-width, $max-viewport-width, $value-for-max-viewport-width );
  }

  @function snrg-fluid-expression( $initial-value, $viewport-width, $min-viewport-width, $value-for-min-viewport-width, $max-viewport-width, $value-for-max-viewport-width ) {
    @return  #{ $initial-value } + ' + ( ' + #{ $viewport-width } + ' - ' + #{ $min-viewport-width } + ' ) * ' + #{ snrg-fluid-coefficient( $min-viewport-width, $value-for-min-viewport-width, $max-viewport-width, $value-for-max-viewport-width ) };
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
  $snrg-padding-at-1188px: snrg-fluid-value( $snrg-padding-until-396px, 1188px, 396px, $snrg-padding-until-396px, 1188px, math.div( 1188px, 6 ) );
  $snrg-padding-coefficient-at-1188px: snrg-fluid-coefficient( 396px, $snrg-padding-until-396px, 1188px, math.div( 1188px, 6 ) );
  $snrg-nunito-sans-size-until-1188px: 18px;
  $snrg-roboto-ratio: 0.9;

  :is(header.snrg-header, main) {
    font: $snrg-nunito-sans-size-until-1188px/var(--SNRG-GOLDEN-RATIO) 'Nunito Sans';
  }

  header.snrg-header {
    position: absolute;
    left: 0;
    top: 0;
    z-index: 1;
  }

  main {
    position: relative;
    z-index: 0;
    box-sizing: border-box;
    width: 100vw;
    height: 100vh;
    overflow: hidden auto;
    padding-left: $snrg-padding-until-396px;
    padding-right: $snrg-padding-until-396px;
  }

  :is(header.snrg-header, main) :is(button, h1, h2, h3, h4, h5, h6) {
    font-family: 'Roboto', sans-serif;
  }

  :is(header.snrg-header, main) :is(h1, h2, h3, h4, h5, h6) {
    font-weight: 500;
  }

  $snrg-heading-coefficient: 1;
  @each $heading-level in 3, 2, 1 {
    $snrg-heading-coefficient: $major-second * $major-second * $snrg-heading-coefficient;
    :is(header.snrg-header, main) h#{ $heading-level } {
      font-size: $snrg-nunito-sans-size-until-1188px * $snrg-roboto-ratio * $snrg-heading-coefficient;
    }
  }

  :is(header.snrg-header, main) :is(button, h4, h5, h6) {
    font-size: $snrg-nunito-sans-size-until-1188px * $snrg-roboto-ratio;
  }

  @media screen and (min-width: 396px) {
    main {
      padding-left: calc( snrg-fluid-expression( $snrg-padding-until-396px, 100vw, 396px, $snrg-padding-until-396px, 1188px, math.div( 1188px, 6 ) ) );
      padding-right: calc( snrg-fluid-expression( $snrg-padding-until-396px, 100vw, 396px, $snrg-padding-until-396px, 1188px, math.div( 1188px, 6 ) ) );
    }
    
    $snrg-initial-heading-coefficient: 1;
    $snrg-final-heading-coefficient: 1;
    @each $heading-level in 3, 2, 1 {
      $snrg-initial-heading-coefficient: $major-second * $major-second * $snrg-initial-heading-coefficient;
      $snrg-initial-heading-size: $snrg-nunito-sans-size-until-1188px * $snrg-roboto-ratio * $snrg-initial-heading-coefficient;
      $snrg-final-heading-coefficient: $minor-third * $minor-third * $snrg-final-heading-coefficient;
      $snrg-final-heading-size: $snrg-nunito-sans-size-until-1188px * $snrg-roboto-ratio * $snrg-final-heading-coefficient;
      :is(header.snrg-header, main) h#{ $heading-level } {
        font-size: calc( snrg-fluid-expression( $snrg-initial-heading-size, 100vw, 396px, $snrg-initial-heading-size, 1188px, $snrg-final-heading-size ) );
      }
    }
  }

  @media screen and (min-width: 1188px) {
    :is(header.snrg-header, main) {
      font-size: calc( snrg-font-size-expression( $snrg-nunito-sans-size-until-1188px, $snrg-padding-coefficient-at-1188px, $snrg-padding-at-1188px, 100vw, 1188px ) );
    }

    main {
      padding-left: calc( snrg-fluid-expression(  $snrg-padding-at-1188px, 100vw, 1188px, math.div( 1188px, 6 ), 1194px, math.div( 1194px, 6 ) ) );
      padding-right: calc( snrg-fluid-expression(  $snrg-padding-at-1188px, 100vw, 1188px, math.div( 1188px, 6 ), 1194px, math.div( 1194px, 6 ) ) );
    }

    $snrg-heading-font-size: #{ $snrg-roboto-ratio } + ' * ( ' + snrg-font-size-expression( $snrg-nunito-sans-size-until-1188px, $snrg-padding-coefficient-at-1188px, $snrg-padding-at-1188px, 100vw, 1188px ) + ' )';
    @each $heading-level in 3, 2, 1 {
      $snrg-heading-font-size: #{ $minor-third } + ' * ' + #{ $minor-third } + ' * ' + $snrg-heading-font-size;
      :is(header.snrg-header, main) h#{ $heading-level } {
        font-size: calc( $snrg-heading-font-size );
      }
    }

    :is(header.snrg-header, main) :is(button, h4, h5, h6) {
      font-size: #{ $snrg-roboto-ratio } + ' * ' + '( ' + snrg-font-size-expression( $snrg-nunito-sans-size-until-1188px, $snrg-padding-coefficient-at-1188px, $snrg-padding-at-1188px, 100vw, 1188px ) + ' )';
    }
  }
</style>