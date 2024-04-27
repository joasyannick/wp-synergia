<script setup lang="ts">
  import { computed } from 'vue'

  const props = defineProps< { opened: boolean } >()

  const cssClass = computed( () => ( {
      'snrg-opened': props.opened
    } ) )

</script>

<template>
  <svg class="snrg-menu-icon" :class="cssClass" viewBox="0 0 417 417">
    <path d="M397.111,59.479c10.815,0 19.583,8.768 19.583,19.583c0,6.518 0,13.776 0,20.302c0,5.214 -2.079,10.212 -5.776,13.888c-3.697,3.676 -8.708,5.726 -13.922,5.695c-70.198,-0.41 -307.666,-1.799 -377.5,-2.208c-10.77,-0.063 -19.468,-8.812 -19.468,-19.583c-0,-5.84 -0,-12.246 -0,-18.093c-0,-10.816 8.767,-19.584 19.583,-19.584l377.5,0Z">
      <animateTransform id="translate1a" attributeName="transform" type="translate" from="0 0" to="0 119.063" begin="3s;translate1b.end" dur="3s" fill="freeze" />
      <animateTransform id="rotate1a" attributeName="transform" type="rotate" from="0 208.5 208.5" to="45 208.5 208.5" begin="translate1a.end" dur="3s" fill="freeze" additive="sum" />
      <animateTransform id="rotate1b" attributeName="transform" type="rotate" from="0 208.5 208.5" to="-45 208.5 208.5" begin="rotate1a.end" dur="3s" fill="freeze" additive="sum" />
      <animateTransform id="translate1b" attributeName="transform" type="translate" from="0 0" to="0 -119.063" begin="rotate1b.end" dur="3s" fill="freeze" additive="sum" />
    </path>
    <path d="M397.111,59.479c10.815,0 19.583,8.768 19.583,19.583c0,6.518 0,13.776 0,20.302c0,5.214 -2.079,10.212 -5.776,13.888c-3.697,3.676 -8.708,5.726 -13.922,5.695c-70.198,-0.41 -307.666,-1.799 -377.5,-2.208c-10.77,-0.063 -19.468,-8.812 -19.468,-19.583c-0,-5.84 -0,-12.246 -0,-18.093c-0,-10.816 8.767,-19.584 19.583,-19.584l377.5,0Z">
      <animateTransform id="translate2a" attributeName="transform" type="translate" from="0 0" to="0 119.063" begin="3s;translate2b.end" dur="3s" fill="freeze" />
      <animateTransform id="rotate2a" attributeName="transform" type="rotate" from="0 208.5 208.5" to="-45 208.5 208.5" begin="translate2a.end" dur="3s" fill="freeze" additive="sum" />
      <animateTransform id="rotate2b" attributeName="transform" type="rotate" from="0 208.5 208.5" to="45 208.5 208.5" begin="rotate2a.end" dur="3s" fill="freeze" additive="sum" />
      <animateTransform id="translate2b" attributeName="transform" type="translate" from="0 0" to="0 -119.063" begin="rotate2b.end" dur="3s" fill="freeze" additive="sum" />
    </path>
    <path d="M324.194,178.542c10.816,-0 19.584,8.767 19.584,19.583c-0,6.555 -0,13.861 -0,20.417c-0,10.815 -8.768,19.583 -19.584,19.583c-49.957,0 -181.709,0 -231.666,0c-10.816,0 -19.584,-8.768 -19.584,-19.583c0,-6.556 0,-13.862 0,-20.417c0,-10.816 8.768,-19.583 19.584,-19.583c49.957,-0 181.709,-0 231.666,-0Z">
      <animate id="opacity3a" attributeType="CSS" attributeName="opacity" begin="6s;opacity3b.end+6s" from="1" to="0" dur="3s" fill="freeze" />
      <animate id="opacity3b" attributeType="CSS" attributeName="opacity" begin="opacity3a.end" from="0" to="1" dur="3s" fill="freeze" additive="sum" />
    </path>
    <path d="M251.278,297.604c10.815,0 19.583,8.768 19.583,19.583c-0,6.556 -0,13.862 -0,20.417c-0,10.816 -8.768,19.583 -19.583,19.584c-23.426,-0.001 -62.408,-0.001 -85.834,-0.001c-10.815,0 -19.583,-8.767 -19.583,-19.583c-0,-6.555 -0,-13.861 -0,-20.417c-0,-10.815 8.768,-19.583 19.583,-19.583c23.426,0 62.408,0 85.834,0Z">
      <animateTransform id="translate4a" attributeName="transform" type="translate" from="0 0" to="0 -119.062" begin="3s;translate4b.end" dur="3s" fill="freeze" />
      <animate id="opacity4a" attributeType="CSS" attributeName="opacity" begin="translate4a.end" from="1" to="0" dur="3s" fill="freeze" additive="sum" />
      <animate id="opacity4b" attributeType="CSS" attributeName="opacity" begin="opacity4a.end" from="0" to="1" dur="3s" fill="freeze" additive="sum" />
      <animateTransform id="translate4b" attributeName="transform" type="translate" from="0 0" to="0 119.062" begin="opacity4b.end" dur="3s" fill="freeze" additive="sum" />
    </path>
  </svg>
</template>

<style scoped>
  svg.snrg-menu-icon > path {
      fill: hsl( var( --snrg-text-hue ), var( --snrg-text-saturation ), var( --snrg-text-lightness ) );
    }
</style>