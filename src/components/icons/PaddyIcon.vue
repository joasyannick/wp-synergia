<template>
  <svg class="snrg-paddy-icon" viewBox="0 0 417 417">
    <path d="M291.667,-0c69.035,0 125,55.964 125,125l-0,166.667c-0,69.035 -55.965,125 -125,125l-166.667,-0c-69.036,-0 -125,-55.965 -125,-125l0,-166.667c0,-69.036 55.964,-125 125,-125l166.667,-0Z" />
    <rect x="169.542" y="243.333" width="75.833" height="110.833" />
    <path d="M106.25,148.25l0,205.917l72.917,-0l-0,-102.084l58.333,0l0,102.084l72.917,-0l-0,-205.917l-102.084,-85.75l-102.083,85.75Z" />
    <path d="M208.333,108.437l-102.083,76.563l-43.75,-0.131l145.833,-122.369l145.834,122.369l-43.75,0.131l-102.084,-76.563Z" />
  </svg>
</template>

<style scoped>
  svg.snrg-paddy-icon > :is(path:is(:nth-of-type(2), :nth-of-type(3))) {
      fill: hsl(var(--snrg-header-paddy-hue), 70%, calc(var(--snrg-header-lightness-1)));
    }

  svg.snrg-paddy-icon > :not(:is(path:is(:nth-of-type(2), :nth-of-type(3)))) {
      fill: hsl(var(--snrg-header-paddy-hue), 70%, calc(var(--snrg-header-lightness-2)));
    }
</style>