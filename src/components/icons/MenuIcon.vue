<script setup lang="ts">
  import { ref, computed, watch } from 'vue'
  import constants from '@/constants'

  const props = defineProps< { opened: boolean } >()
  const emit = defineEmits< { animation: [ inProgress: boolean ] } >()

  const duration = Math.round(0.5 * constants.animation.menu.duration.onOpenOrClose * 1000) / 1000
  const translate1a = ref< SVGAnimateTransformElement | null >( null )
  const rotate1b = ref< SVGAnimateTransformElement | null >( null )
  const translate2a = ref< SVGAnimateTransformElement | null >( null )
  const rotate2b = ref< SVGAnimateTransformElement | null >( null )
  const path3 = ref< SVGPathElement | null >( null )
  const path4 = ref< SVGPathElement | null >( null )
  const translate4a = ref< SVGAnimateTransformElement | null >( null )
  const translate4b = ref< SVGAnimateTransformElement | null >( null )

  const cssClass = computed( () => ( { 'snrg-opened': props.opened } ) )
  const cssStyle = computed( () => ( { transition: 'opacity 0s ' + duration + 's' } ) )

  watch( () => props.opened, ( now, before ) => {
      emit( 'animation', true )
      setTimeout( () => emit( 'animation', false ), constants.animation.menu.duration.onOpenOrClose * 1000 )
      if ( now ) {
        translate1a.value?.beginElement()
        translate2a.value?.beginElement()
        translate4a.value?.beginElement()
      } else {
        rotate1b.value?.beginElement()
        rotate2b.value?.beginElement()
        setTimeout( () => translate4b.value?.beginElement(), duration * 1000 )
      }
    } )
</script>

<template>
  <svg class="snrg-menu-icon" :class="cssClass" viewBox="0 0 417 417">
    <path d="M397.111,59.479c10.815,0 19.583,8.768 19.583,19.583c0,6.518 0,13.776 0,20.302c0,5.214 -2.079,10.212 -5.776,13.888c-3.697,3.676 -8.708,5.726 -13.922,5.695c-70.198,-0.41 -307.666,-1.799 -377.5,-2.208c-10.77,-0.063 -19.468,-8.812 -19.468,-19.583c-0,-5.84 -0,-12.246 -0,-18.093c-0,-10.816 8.767,-19.584 19.583,-19.584l377.5,0Z">
      <animateTransform ref="translate1a" id="translate1a" attributeName="transform" type="translate" from="0 0" to="0 119.063" begin="indefinite" :dur="duration + 's'" fill="freeze" />
      <animateTransform id="rotate1a" attributeName="transform" type="rotate" from="0 208.5 89.437" to="45 208.5 89.437" begin="translate1a.end" :dur="duration + 's'" fill="freeze" additive="sum" />
      <animateTransform ref="rotate1b" id="rotate1b" attributeName="transform" type="rotate" from="0 208.5 89.437" to="-45 208.5 89.437" begin="indefinite" :dur="duration + 's'" fill="freeze" additive="sum" />
      <animateTransform id="translate1b" attributeName="transform" type="translate" from="0 0" to="0 -119.063" begin="rotate1b.end" :dur="duration + 's'" fill="freeze" additive="sum" />
    </path>
    <path d="M397.111,59.479c10.815,0 19.583,8.768 19.583,19.583c0,6.518 0,13.776 0,20.302c0,5.214 -2.079,10.212 -5.776,13.888c-3.697,3.676 -8.708,5.726 -13.922,5.695c-70.198,-0.41 -307.666,-1.799 -377.5,-2.208c-10.77,-0.063 -19.468,-8.812 -19.468,-19.583c-0,-5.84 -0,-12.246 -0,-18.093c-0,-10.816 8.767,-19.584 19.583,-19.584l377.5,0Z">
      <animateTransform ref="translate2a" id="translate2a" attributeName="transform" type="translate" from="0 0" to="0 119.063" begin="indefinite" :dur="duration + 's'" fill="freeze" />
      <animateTransform id="rotate2a" attributeName="transform" type="rotate" from="0 208.5 89.437" to="-45 208.5 89.437" begin="translate2a.end" :dur="duration + 's'" fill="freeze" additive="sum" />
      <animateTransform ref="rotate2b" id="rotate2b" attributeName="transform" type="rotate" from="0 208.5 89.437" to="45 208.5 89.437" begin="indefinite" :dur="duration + 's'" fill="freeze" additive="sum" />
      <animateTransform id="translate2b" attributeName="transform" type="translate" from="0 0" to="0 -119.063" begin="rotate2b.end" :dur="duration + 's'" fill="freeze" additive="sum" />
    </path>
    <path :style="cssStyle" ref="path3"  d="M324.194,178.542c10.816,-0 19.584,8.767 19.584,19.583c-0,6.555 -0,13.861 -0,20.417c-0,10.815 -8.768,19.583 -19.584,19.583c-49.957,0 -181.709,0 -231.666,0c-10.816,0 -19.584,-8.768 -19.584,-19.583c0,-6.556 0,-13.862 0,-20.417c0,-10.816 8.768,-19.583 19.584,-19.583c49.957,-0 181.709,-0 231.666,-0Z" />
    <path :style="cssStyle" ref="path4" d="M251.278,297.604c10.815,0 19.583,8.768 19.583,19.583c-0,6.556 -0,13.862 -0,20.417c-0,10.816 -8.768,19.583 -19.583,19.584c-23.426,-0.001 -62.408,-0.001 -85.834,-0.001c-10.815,0 -19.583,-8.767 -19.583,-19.583c-0,-6.555 -0,-13.861 -0,-20.417c-0,-10.815 8.768,-19.583 19.583,-19.583c23.426,0 62.408,0 85.834,0Z">
      <animateTransform ref="translate4a" id="translate4a" attributeName="transform" type="translate" from="0 0" to="0 -119.062" begin="indefinite" :dur="duration + 's'" fill="freeze" />
      <animateTransform ref="translate4b" id="translate4b" attributeName="transform" type="translate" from="0 0" to="0 119.062" begin="indefinite" :dur="duration + 's'" fill="freeze" additive="sum" />
    </path>
  </svg>
</template>

<style scoped>
  svg.snrg-menu-icon > path {
      fill: hsl( var( --snrg-text-hue ), var( --snrg-text-saturation ), var( --snrg-text-lightness ) );
    }

  svg.snrg-menu-icon.snrg-opened > path:is(:nth-of-type(3), :nth-of-type(4)) {
      opacity: 0;
    }
</style>