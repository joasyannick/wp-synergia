<script setup lang="ts">
  import { ref } from 'vue'

  const slogans = [
      'Je ne crois pas en Dieu, je le vis.',
      'Je vis, non plus moi, Christ vit en moi.',
      "Christ ne se croit pas seulement, il s'expérimente.",
      "L'évangile ne se prêche pas seulement, il se démontre."
    ]
  const current = ref( 0 )

  setInterval( () => { for ( let before = current.value; before === current.value; ) current.value = Math.floor( Math.random() * slogans.length ) }, 12000 )
</script>

<template>
  <div class="snrg-slogans">
    <TransitionGroup name="snrg">
      <template v-for="( slogan, index ) in slogans" :key="slogan">
        <blockquote v-if="index === current" v-html="slogan"></blockquote>
      </template>
    </TransitionGroup>
  </div>
</template>

<style scoped>
  div.snrg-slogans {
    display: flex;
    flex-flow: column nowrap;
    align-items: center;
    transform: translateZ( -60px ) scale( 1.6 );
  }

  div.snrg-slogans > blockquote {
    position: absolute;
    top: calc(var(--snrg-menu-top) + var(--snrg-menu-height) + 25%);
    font-family: 'Roboto';
    font-size: calc(var(--snrg-roboto-size));
    font-weight: 100;
  }

  div.snrg-slogans > blockquote.snrg-enter-active {
    transition: all 2s ease 2s;
  }

  div.snrg-slogans > blockquote.snrg-leave-active {
    transition: all 2s ease;
  }

  div.snrg-slogans > blockquote.snrg-enter-from,
  div.snrg-slogans > blockquote.snrg-leave-to {
    opacity: 0;
  }
</style>