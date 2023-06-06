<template>
  <svg class="snrg-contact-icon" viewBox="0 0 417 417">
    <path d="M416.694,62.5l0,291.682l-250.159,0l-77.884,62.485l-26.177,-62.485l-62.474,0l0,-291.682l416.694,0Z" />
    <path d="M62.5,112.5l145.875,145.833l145.792,-145.833" style="fill:none; stroke-width:37.5px" />
  </svg>
</template>

<style scoped>
  svg.snrg-contact-icon > path:nth-of-type(2) {
      stroke: hsl(var(--snrg-header-hue), 70%, calc(var(--snrg-header-lightness-1)));
    }

  svg.snrg-contact-icon > path:not(:nth-of-type(2)) {
      fill: hsl(var(--snrg-header-hue), 70%, calc(var(--snrg-header-lightness-2)));
    }
</style>