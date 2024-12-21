<script setup lang="ts">
  import { ref, onUnmounted } from 'vue'

  const slogans = ref( [] as string[] )
  const current = ref( 0 )
  let interval = 0

  const fetchSlogans = async () => {
      try {
        const response = await fetch( import.meta.env.VITE_WP_REST_URL + '/synergia/v1/settings/slogans' )
        slogans.value = await response.json()
        if ( slogans.value.length ) {
          interval = setInterval( () => { for ( let before = current.value; before === current.value; ) current.value = Math.floor( Math.random() * slogans.value.length ) }, 12000 )
        }
      } catch ( exception ) {
        console.error( 'Failed to fetch slogans' )
      }
    }

  onUnmounted( () => clearInterval( interval ) )

  fetchSlogans()
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
    --snrg-slogan-transition: 2s;
    display: flex;
    flex-flow: column nowrap;
    align-items: center;
    /*transform: translateZ(-60px) scale(1.6);*/
  }

  div.snrg-slogans > blockquote {
    /*position: absolute;*/
    /*top: calc(var(--snrg-top-margin) + 25%);*/
    margin: 0;
    font-family: 'Roboto Condensed';
    font-size: calc(var(--snrg-h1-size));
    max-width: 50%;
    max-height: calc(2 * var(--snrg-h1-size) * var(--SNRG-LINE-HEIGHT));
    font-weight: 300;
    text-align: center;
  }

  div.snrg-slogans > blockquote.snrg-enter-active {
    transition: opacity var(--snrg-slogan-transition) ease var(--snrg-slogan-transition);
  }

  div.snrg-slogans > blockquote.snrg-leave-active {
    transition: opacity var(--snrg-slogan-transition) ease;
  }

  div.snrg-slogans > blockquote.snrg-enter-from,
  div.snrg-slogans > blockquote.snrg-leave-to {
    opacity: 0;
  }
</style>