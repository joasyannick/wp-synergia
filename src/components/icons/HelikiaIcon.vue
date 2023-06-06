<template>
  <svg class="snrg-helikia-icon" viewBox="0 0 417 417">
    <path d="M291.667,0c69.035,0 125,55.964 125,125l-0,166.667c-0,69.035 -55.965,125 -125,125l-166.667,-0c-69.036,-0 -125,-55.965 -125,-125l0,-166.667c0,-69.036 55.964,-125 125,-125l166.667,0Z" />
    <path d="M333.657,208.333l-192.591,125l0,-250l192.591,125Z" />
  </svg>
</template>

<style scoped>
  svg.snrg-helikia-icon > path:nth-of-type(2) {
      fill: hsl(var(--snrg-header-helikia-hue), 70%, calc(var(--snrg-header-lightness-1)));
    }

  svg.snrg-helikia-icon > path:not(:nth-of-type(2)) {
      fill: hsl(var(--snrg-header-helikia-hue), 70%, calc(var(--snrg-header-lightness-2)));
    }
</style>