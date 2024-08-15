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
      let innerMargin = 1.125
      let outerMargin = innerMargin
      if ( 396 < viewportWidth && viewportWidth < 1584 ) {
        // innerMargin = ( ( 7 / 26136 ) * viewportWidth * viewportWidth - ( 7 / 33 ) * viewportWidth + 60 ) / 16
        innerMargin = ( ( 7 / 62099136 ) * viewportWidth * viewportWidth * viewportWidth - ( 7 / 132 ) * viewportWidth + 32 ) / 16
        // innerMargin = ( ( 7 / 31049568 ) * viewportWidth * viewportWidth * viewportWidth - ( 7 / 26136 ) * viewportWidth * viewportWidth + ( 7 / 66 ) * viewportWidth + 4 ) / 16
        outerMargin = ( ( 1 / 41399424 ) * viewportWidth * viewportWidth * viewportWidth - ( 1 / 88 ) * viewportWidth + 21 ) / 16
      } else if ( 1584 <= viewportWidth ) {
        innerMargin = ( 0.25 * viewportWidth ) / 16
        outerMargin = ( 0.0625 * viewportWidth ) / 16
      }
      appElement.value!.style.setProperty( '--snrg-inner-margin',  `${ innerMargin }rem` )
      appElement.value!.style.setProperty( '--snrg-outer-margin',  `${ outerMargin }rem` )
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
  @use 'sass:math';

  @function rem( $px, $em: false ) {
    @if not unitless( $px ) {
      @error 'The value passed to rem() must be unitless.';
    }
    @if $em {
      @return math.div( $px, 16 ) * 1em;
    }
    @return math.div( $px, 16 ) * 1rem;
  }

  @function strip-unit( $number ) {
    @if type-of( $number ) == 'number' and not unitless( $number ) {
      @return math.div( $number, ( $number * 0 + 1 ) );
    }
    @return $number;
  }

  @function linear-coefficient( $x1, $y1, $x2, $y2 ) {
    @return math.div( $y2 - $y1 , $x2 - $x1 );
  }

  @function linear-expression( $x1, $y1, $x2, $y2, $x ) {
    @return  '#{ $y1 } + (#{ $x } - #{ $x1 }) * #{ linear-coefficient( strip-unit( $x1 ), strip-unit( $y1 ), strip-unit( $x2 ), strip-unit( $y2 ) ) }';
  }

  @function font-size-coefficient( $font-size-0, $width-0, $margin-0, $margin-coefficient ) {
    @return math.div( ( 1 - 2 * $margin-coefficient ) * $font-size-0, $width-0 - 2 * $margin-0 );
  }

  $MAJOR-SECOND: 1.125;
  $MINOR-THIRD: 1.2;
  $MARGIN-AT-396: 1.125rem;
  $MARGIN-AT-1584: rem( math.div( 1584, 4 ) );
  $MARGIN-COEFFICIENT-AT-1584: linear-coefficient( strip-unit( rem( 396 ) ), strip-unit( $MARGIN-AT-396 ), strip-unit( rem( 1584 ) ), strip-unit( rem( math.div( 1584, 4 ) ) ) );
  $NUNITO-SANS-SIZE-AT-1584: 1.125rem;
  $NUNITO-SANS-SIZE-AT-1684: $NUNITO-SANS-SIZE-AT-1584 + font-size-coefficient( strip-unit( $NUNITO-SANS-SIZE-AT-1584 ), strip-unit( rem( 1584 ) ), strip-unit( $MARGIN-AT-1584 ), $MARGIN-COEFFICIENT-AT-1584 ) * rem( 100 );
  $ROBOTO-RATIO: 0.9;

  div#snrg-app {
    --SNRG-BACKGROUND-HUE: 225;
    --SNRG-BACKGROUND-SATURATION: 70%;
    --SNRG-TEXT-HUE: 210;
    --SNRG-TEXT-SATURATION: 29%;
    --SNRG-DARK-FILTER: invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%);
    --snrg-menu-height: 2rem;
    --snrg-top-margin: 1rem;
    --snrg-bottom-margin: 1rem;
    --snrg-content-margin: ((var(--snrg-inner-margin)) - (var(--snrg-outer-margin)));
    --snrg-middle-content-margin: (0.5 * var(--snrg-content-margin));
    --snrg-font-size: #{ $NUNITO-SANS-SIZE-AT-1584 };
    --snrg-font-size-h4-h5-h6: #{ $NUNITO-SANS-SIZE-AT-1584 * $ROBOTO-RATIO };
    position: relative;
    background: hsl(var(--SNRG-BACKGROUND-HUE), var(--SNRG-BACKGROUND-SATURATION), var(--snrg-background-lightness));
    color: hsl(var(--SNRG-TEXT-HUE), var(--SNRG-TEXT-SATURATION), var(--snrg-text-lightness));
    font: calc(var(--snrg-font-size))/calc(5/3) 'Nunito Sans';
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

  $snrg-heading-coefficient: 1;
  @each $heading-level in 3, 2, 1 {
    $snrg-heading-coefficient: $MAJOR-SECOND * $MAJOR-SECOND * $snrg-heading-coefficient;

    div#snrg-app {
      --snrg-font-size-h#{ $heading-level }: (#{ $NUNITO-SANS-SIZE-AT-1584 * $ROBOTO-RATIO * $snrg-heading-coefficient });
    }

    div#snrg-app h#{ $heading-level } {
      font-size: calc(var(--snrg-font-size-h#{ $heading-level }));
    }
  }

  div#snrg-app :is(button, h1, h2, h3, h4, h5, h6) {
    font-family: 'Roboto', sans-serif;
  }

  div#snrg-app :is(h1, h2, h3, h4, h5, h6) {
    font-weight: 500;
  }

  @media screen and (min-width: rem( 396, true ) ) {
    $snrg-initial-heading-coefficient: 1;
    $snrg-final-heading-coefficient: 1;
    @each $heading-level in 3, 2, 1 {
      $snrg-initial-heading-coefficient: $MAJOR-SECOND * $MAJOR-SECOND * $snrg-initial-heading-coefficient;
      $snrg-initial-heading-size: $NUNITO-SANS-SIZE-AT-1584 * $ROBOTO-RATIO * $snrg-initial-heading-coefficient;
      $snrg-final-heading-coefficient: $MINOR-THIRD * $MINOR-THIRD * $snrg-final-heading-coefficient;
      $snrg-final-heading-size: $NUNITO-SANS-SIZE-AT-1584 * $ROBOTO-RATIO * $snrg-final-heading-coefficient;
      
      div#snrg-app {
        --snrg-font-size-h#{ $heading-level }: (#{ linear-expression( rem( 396 ), $snrg-initial-heading-size, rem( 1584 ), $snrg-final-heading-size, 100vw ) });
      }
    }
  }

  @media screen and (min-width: rem( 1584, true ) ) {
    div#snrg-app {
      --snrg-font-size: (#{ linear-expression( rem( 1584 ), $NUNITO-SANS-SIZE-AT-1584, rem( 1684 ), $NUNITO-SANS-SIZE-AT-1684, 100vw ) });
    }

    $snrg-heading-coefficient: 1;
    @each $heading-level in 3, 2, 1 {
      $snrg-heading-coefficient: $MINOR-THIRD * $MINOR-THIRD * $snrg-heading-coefficient;

      div#snrg-app {
        --snrg-font-size-h#{ $heading-level }: (#{ $ROBOTO-RATIO * $snrg-heading-coefficient } * var(--snrg-font-size));
      }
    }

    div#snrg-app {
      --snrg-font-size-h4-h5-h6: (#{ $ROBOTO-RATIO } * (var(--snrg-font-size)));
    }
  }
</style>