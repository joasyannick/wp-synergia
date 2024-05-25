<script setup lang="ts">
  import { ref } from 'vue'
  import Welcome from '@/components/Welcome.vue'
  import Programs from '@/components/Programs.vue'

  const introduction = ref( null as any )

  const fetchIntroductionPage = async () => {
      try {
        let response = await fetch( import.meta.env.VITE_WP_REST_URL + 'synergia/v1/introduction-page' )
        let pageId = await response.json()
        pageId = parseInt( pageId )
        console.log( pageId )
        if ( pageId === 0 ) {
          return
        }
        response = await fetch( import.meta.env.VITE_WP_REST_URL + 'wp/v2/pages/' + pageId + '?_fields=title.rendered,content.rendered' )
        if ( ! response.ok ) {
          return
        }
        introduction.value = await response.json()
      } catch ( exception ) {
        console.error( 'Failed to fetch the stary night image' )
      }
    }

    fetchIntroductionPage()
</script>

<template>
  <Welcome />
  <article class="snrg-introduction">
    <header>
      <h1 v-if="introduction">{{ introduction.title.rendered }}</h1>
      <h1 v-else>Et si on passait de croyant à vivant&nbsp;?</h1>
    </header>
    <div v-if="introduction" v-html="introduction.content.rendered"></div>
    <div v-else><p>Nous avons trouvé cette porte étroite et arpenté ce chemin resserré, désencombré de toute tradition humaine ou religieuse, qui mène à la vie. Laissez-nous vous aider à y marcher.</p></div>
  </article>
  <Programs />
</template>

<style scoped>
  article.snrg-introduction {
      position: relative;
      margin-top: -10vh;
      background: hsl( var( --snrg-background-hue ), var( --snrg-background-saturation ), var( --snrg-background-lightness ) );
    }
  
  article.snrg-introduction > div > p:last-child {
    margin-bottom: 0;
  }

  article.snrg-introduction > header {
      min-height: 10vh;
    }

  article.snrg-introduction > header > h1 {
      margin: 0;
    }
</style>