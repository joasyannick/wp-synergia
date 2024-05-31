<script setup lang="ts">
  import { ref } from 'vue'
  import Welcome from '@/components/Welcome.vue'
  import Programs from '@/components/Programs.vue'

  const introduction = ref( null as null | { title: string, content: string } )

  const fetchIntroductionPage = async () => {
      try {
        let response = await fetch( import.meta.env.VITE_WP_REST_URL + 'synergia/v1/introduction-page' )
        let json = await response.json()
        const pageId = parseInt( json )
        response = await fetch( import.meta.env.VITE_WP_REST_URL + 'wp/v2/pages/' + pageId + '?_fields=title.rendered,content.rendered' )
        if ( ! response.ok ) {
          introduction.value = { title: 'Et si on passait de croyant à vivant&nbsp;?', content: '<p>Nous avons trouvé cette porte étroite et arpenté ce chemin resserré, désencombré de toute tradition religieuse ou culturelle, qui mène à la vie. Laissez-nous vous aider à y marcher.</p>' }
          return
        }
        json = await response.json()
        introduction.value = { title: json.title.rendered, content: json.content.rendered }
      } catch ( exception ) {
        console.error( exception )
      }
    }

  fetchIntroductionPage()
</script>

<template>
  <Welcome />
  <article class="snrg-introduction">
    <header v-if="introduction">
      <h1 v-html="introduction.title"></h1>
    </header>
    <div v-if="introduction" v-html="introduction.content"></div>
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