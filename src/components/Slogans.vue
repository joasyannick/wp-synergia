<script setup lang="ts">
  import { ref } from 'vue'

  const slogans = ref( [] as string[] )
  const current = ref( 0 )

  const fetchSlogans = async () => {
      try {
          const response = await fetch( import.meta.env.VITE_WP_REST_URL + '/synergia/v1/slogans' )
          slogans.value = await response.json()
          if ( slogans.value.length ) {
            setInterval( () => { for ( let before = current.value; before === current.value; ) current.value = Math.floor( Math.random() * slogans.value.length ) }, 12000 )
          }
        } catch ( exception ) {
          console.error( 'Failed to fetch slogans' )
        }
    }

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