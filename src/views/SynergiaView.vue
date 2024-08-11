<script setup lang="ts">
  import "leaflet/dist/leaflet.css"
  import { LMap, LTileLayer } from "@vue-leaflet/vue-leaflet"
</script>

<script lang="ts">
  export default {
    components: {
      LMap,
      LTileLayer,
    }
  }
</script>

<template>
  <article class="snrg-synergia">
    <header>
      <h2>Synergia</h2>
    </header>
    <div class="snrg-synergia-map">
      <l-map ref="snrg-synergia-leaflet-map" :min-zoom="3" :zoom="3" :center="[ 48.8534, 2.3487 ]">
        <l-tile-layer
            url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            layer-type="base"
            name="OpenStreetMap"
          >
        </l-tile-layer>
      </l-map>
    </div>
  </article>
</template>
  
<style>

  section.snrg-synergia > header {
    display: none;
  }

  section.snrg-synergia > div.snrg-synergia-map {
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    z-index: -1;
  }

  div#snrg-app[data-snrg-theme='dark'] section.snrg-synergia > div.snrg-synergia-map {
    filter: var(--SNRG-DARK-FILTER);
  }
</style>
  