<script setup lang="ts">
  import { inject, ref, computed, watch, onMounted } from 'vue'
  import constants from '@/constants'
  import type { IMenu } from '@/injection'
  import { iMenu } from '@/injection'

  const menu = inject( iMenu ) as IMenu

  const emit = defineEmits< { animated: [ animated: boolean ] } >()

  const duration = Math.round(0.5 * constants.menu.animation * 1000) / 1000

  const openingTranslation = ref( null as null | SVGAnimateTransformElement )
  const openingRotation = ref( null as null | SVGAnimateTransformElement )
  const closingRotation = ref(null as null | SVGAnimateTransformElement )
  const closingTranslation = ref( null as null | SVGAnimateTransformElement )

  onMounted( () => {
      openingTranslation.value!.addEventListener( 'beginEvent', () => emit( 'animated', true ) )
      openingRotation.value!.addEventListener( 'endEvent', () => emit( 'animated', false ) )
      closingRotation.value!.addEventListener( 'beginEvent', () => emit( 'animated', true ) )
      closingTranslation.value!.addEventListener( 'endEvent', () => emit( 'animated', false ) )
    } )

  watch( () => menu.opened.value, ( now, before ) => {
      if ( now ) {
        openingTranslation.value?.beginElement()
      } else {
        closingRotation.value?.beginElement()
      }
    } )
</script>

<template>
  <svg class="snrg-menu-icon" viewBox="0 0 417 417">
    <path d="M397.111,59.479c10.815,0 19.583,8.768 19.583,19.583c0,6.518 0,13.776 0,20.302c0,5.214 -2.079,10.212 -5.776,13.888c-3.697,3.676 -8.708,5.726 -13.922,5.695c-70.198,-0.41 -307.666,-1.799 -377.5,-2.208c-10.77,-0.063 -19.468,-8.812 -19.468,-19.583c-0,-5.84 -0,-12.246 -0,-18.093c-0,-10.816 8.767,-19.584 19.583,-19.584l377.5,0Z">
      <animateTransform ref="openingTranslation" id="openingTranslation1" attributeName="transform" type="translate" from="0 0" to="0 119.063" begin="indefinite" :dur="duration + 's'" fill="freeze" />
      <animateTransform ref="openingRotation" attributeName="transform" type="rotate" from="0 208.5 89.437" to="45 208.5 89.437" begin="openingTranslation1.end" :dur="duration + 's'" fill="freeze" additive="sum" />
      <animateTransform ref="closingRotation" id="closingRotation1" attributeName="transform" type="rotate" from="0 208.5 89.437" to="-45 208.5 89.437" begin="indefinite" :dur="duration + 's'" fill="freeze" additive="sum" />
      <animateTransform ref="closingTranslation" id="closingTranslation1" attributeName="transform" type="translate" from="0 0" to="0 -119.063" begin="closingRotation1.end" :dur="duration + 's'" fill="freeze" additive="sum" />
    </path>
    <path d="M397.111,59.479c10.815,0 19.583,8.768 19.583,19.583c0,6.518 0,13.776 0,20.302c0,5.214 -2.079,10.212 -5.776,13.888c-3.697,3.676 -8.708,5.726 -13.922,5.695c-70.198,-0.41 -307.666,-1.799 -377.5,-2.208c-10.77,-0.063 -19.468,-8.812 -19.468,-19.583c-0,-5.84 -0,-12.246 -0,-18.093c-0,-10.816 8.767,-19.584 19.583,-19.584l377.5,0Z">
      <animateTransform id="openingTranslation2" attributeName="transform" type="translate" from="0 0" to="0 119.063" begin="openingTranslation1.begin" :dur="duration + 's'" fill="freeze" />
      <animateTransform attributeName="transform" type="rotate" from="0 208.5 89.437" to="-45 208.5 89.437" begin="openingTranslation2.end" :dur="duration + 's'" fill="freeze" additive="sum" />
      <animateTransform id="closingRotation2" attributeName="transform" type="rotate" from="0 208.5 89.437" to="45 208.5 89.437" begin="closingRotation1.begin" :dur="duration + 's'" fill="freeze" additive="sum" />
      <animateTransform attributeName="transform" type="translate" from="0 0" to="0 -119.063" begin="closingRotation2.end" :dur="duration + 's'" fill="freeze" additive="sum" />
    </path>
    <path d="M324.194,178.542c10.816,-0 19.584,8.767 19.584,19.583c-0,6.555 -0,13.861 -0,20.417c-0,10.815 -8.768,19.583 -19.584,19.583c-49.957,0 -181.709,0 -231.666,0c-10.816,0 -19.584,-8.768 -19.584,-19.583c0,-6.556 0,-13.862 0,-20.417c0,-10.816 8.768,-19.583 19.584,-19.583c49.957,-0 181.709,-0 231.666,-0Z">
      <animate attributeName="fill-opacity" from="1" to="0" begin="openingTranslation1.begin" :dur="duration + 's'" fill="freeze" />
      <animate attributeName="fill-opacity" from="0" to="1" begin="closingTranslation1.begin" :dur="duration + 's'" fill="freeze" />
    </path>
    <path d="M251.278,297.604c10.815,0 19.583,8.768 19.583,19.583c-0,6.556 -0,13.862 -0,20.417c-0,10.816 -8.768,19.583 -19.583,19.584c-23.426,-0.001 -62.408,-0.001 -85.834,-0.001c-10.815,0 -19.583,-8.767 -19.583,-19.583c-0,-6.555 -0,-13.861 -0,-20.417c-0,-10.815 8.768,-19.583 19.583,-19.583c23.426,0 62.408,0 85.834,0Z">
      <animateTransform attributeName="transform" type="translate" from="0 0" to="0 -119.062" begin="openingTranslation1.begin" :dur="duration + 's'" fill="freeze" />
      <animateTransform attributeName="transform" type="translate" from="0 0" to="0 119.062" begin="closingTranslation1.begin" :dur="duration + 's'" fill="freeze" additive="sum" />
      <animate attributeName="fill-opacity" from="1" to="0" begin="openingTranslation1.begin" :dur="duration + 's'" fill="freeze" />
      <animate attributeName="fill-opacity" from="0" to="1" begin="closingTranslation1.begin" :dur="duration + 's'" fill="freeze" />
    </path>
  </svg>
</template>

<style scoped>
</style>