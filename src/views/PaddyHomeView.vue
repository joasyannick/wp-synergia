<script setup lang="ts">
  import Welcome from '@/components/Welcome.vue'
  import Programs from '@/components/Programs.vue'
</script>

<template>
  <Welcome />
  <article class="snrg-introduction">
    <header>
      <h1>Et si on passait de croyant à vivant&nbsp;?</h1>
    </header>
    <p>J'ai trouvé cette porte étroite et arpenté ce chemin resserré — désencombré de toute tradition humaine ou religieuse — qui mène à la vie. Laissez-moi vous aider à y marcher.</p>
  </article>
  <Programs />
</template>

<style scoped>
  article.snrg-introduction {
      position: relative;
      margin-top: -10vh;
      background: hsl( var( --snrg-background-hue ), var( --snrg-background-saturation ), var( --snrg-background-lightness ) );
    }
  
  article.snrg-introduction > p:last-child {
    margin-bottom: 0;
  }

  article.snrg-introduction > header {
      min-height: 10vh;
    }

  article.snrg-introduction > header > h1 {
      margin: 0;
    }
</style>