<script setup lang="ts">
  import { ref } from 'vue'
  import constants from '@/constants'
  import Welcome from '@/components/Welcome.vue'
  import Programs from '@/components/Programs.vue'

  const introduction = ref( { title: 'Bienvenue', content: '<p>Présenter le site.</p>' } )

  const fetchIntroduction = async ( postType: string ) => {
    try {
        const response = await fetch( import.meta.env.VITE_WP_REST_URL + 'wp/v2/' + postType + '?slug=' + constants.route.paddy.introduction + '&_fields=title.rendered,content.rendered' )
        const json = await response.json()
        if ( json.length ) {
          introduction.value = { title: json[0].title.rendered, content: json[0].content.rendered }
        }
      } catch ( exception ) {
        console.error( 'Failed to fetch the introduction in ' + postType + ': ' + exception )
      }
    }

  Promise.all( [ fetchIntroduction( 'pages' ), fetchIntroduction( 'posts' ) ] )
</script>

<template>
  <Welcome />
  <article class="snrg-introduction">
    <header>
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