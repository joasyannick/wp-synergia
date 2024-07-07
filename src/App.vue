<script setup lang="ts">
  import { ref, provide , watch } from 'vue'
  import { RouterView, useRoute } from 'vue-router'

  import { iMenu } from '@/injection'
  import AppHeader from '@/components/AppHeader.vue'

  const route = useRoute()

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
  $snrg-padding-at-1584px: snrg-fluid-value( $snrg-padding-until-396px, 1584px, 396px, $snrg-padding-until-396px, 1584px, math.div( 1584px, 4 ) );
  $snrg-padding-coefficient-at-1584px: snrg-fluid-coefficient( 396px, $snrg-padding-until-396px, 1584px, math.div( 1584px, 4 ) );
  $snrg-nunito-sans-size-until-1584px: 18px;
  $snrg-roboto-ratio: 0.9;

  :is(header.snrg-header, main) {
    --snrg-font-size: #{ $snrg-nunito-sans-size-until-1584px };
  }

  $snrg-heading-coefficient: 1;
  @each $heading-level in 3, 2, 1 {
    $snrg-heading-coefficient: $major-second * $major-second * $snrg-heading-coefficient;
    :is(header.snrg-header, main) {
      --snrg-heading-font-size-#{ $heading-level }: #{ $snrg-nunito-sans-size-until-1584px * $snrg-roboto-ratio * $snrg-heading-coefficient };
    }
  }

  @each $heading-level in 4, 5, 6 {
    :is(header.snrg-header, main) {
      --snrg-heading-font-size-#{ $heading-level }: #{ $snrg-nunito-sans-size-until-1584px * $snrg-roboto-ratio };
    }
  }

  @media screen and (min-width: 396px) {
    :is(header.snrg-header, main) {
      --snrg-margin: #{ snrg-fluid-expression( $snrg-padding-until-396px, 100vw, 396px, $snrg-padding-until-396px, 1584px, math.div( 1584px, 4 ) ) };
    }
    
    $snrg-initial-heading-coefficient: 1;
    $snrg-final-heading-coefficient: 1;
    @each $heading-level in 3, 2, 1 {
      $snrg-initial-heading-coefficient: $major-second * $major-second * $snrg-initial-heading-coefficient;
      $snrg-initial-heading-size: $snrg-nunito-sans-size-until-1584px * $snrg-roboto-ratio * $snrg-initial-heading-coefficient;
      $snrg-final-heading-coefficient: $minor-third * $minor-third * $snrg-final-heading-coefficient;
      $snrg-final-heading-size: $snrg-nunito-sans-size-until-1584px * $snrg-roboto-ratio * $snrg-final-heading-coefficient;
      :is(header.snrg-header, main) {
        --snrg-heading-font-size-#{ $heading-level }: #{ snrg-fluid-expression( $snrg-initial-heading-size, 100vw, 396px, $snrg-initial-heading-size, 1584px, $snrg-final-heading-size ) };
      }
    }
  }

  @media screen and (min-width: 1584px) {
    :is(header.snrg-header, main) {
      --snrg-font-size: #{ snrg-font-size-expression( $snrg-nunito-sans-size-until-1584px, $snrg-padding-coefficient-at-1584px, $snrg-padding-at-1584px, 100vw, 1584px ) };
      --snrg-margin: #{ snrg-fluid-expression(  $snrg-padding-at-1584px, 100vw, 1584px, math.div( 1584px, 4 ), 1588px, math.div( 1588px, 4 ) ) };
    }

    $snrg-heading-font-size: #{ $snrg-roboto-ratio } + ' * ( ' + snrg-font-size-expression( $snrg-nunito-sans-size-until-1584px, $snrg-padding-coefficient-at-1584px, $snrg-padding-at-1584px, 100vw, 1584px ) + ' )';
    @each $heading-level in 3, 2, 1 {
      $snrg-heading-font-size: #{ $minor-third } + ' * ' + #{ $minor-third } + ' * ' + $snrg-heading-font-size;
      :is(header.snrg-header, main) {
        --snrg-heading-font-size-#{ $heading-level }: #{ $snrg-heading-font-size };
      }
    }

    @each $heading-level in 4, 5, 6 {
      $snrg-heading-font-size: #{ $snrg-roboto-ratio } + ' * ' + '( ' + snrg-font-size-expression( $snrg-nunito-sans-size-until-1584px, $snrg-padding-coefficient-at-1584px, $snrg-padding-at-1584px, 100vw, 1584px ) + ' )';
      :is(header.snrg-header, main) {
        --snrg-heading-font-size-#{ $heading-level }: #{ $snrg-heading-font-size };
      }
    }
  }
</style>