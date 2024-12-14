<script setup lang="ts">
  import { ref } from 'vue'
  import * as constants from '@/constants'
  import { fetchAllPosts } from '@/wordpress'

  const defaultImage = ref( '' )
  const posts = ref( [] as { id: number, slug: string, title: string, data: Map< string, any > }[] )
  const current = ref( undefined as undefined | number)

  const onClick = ( index: number ) => {
      current.value = index
    }

  const fetchDefaultImage = async () => {
      try {
        const response = await fetch( import.meta.env.VITE_WP_REST_URL + '/synergia/v1/default-image' )
        defaultImage.value = await response.json()
      } catch ( exception ) {
        console.error( 'Failed to fetch the default featured image' )
      }
    }
  
  fetchDefaultImage()
  const options = new Map()
  options.set( 'excerpt.rendered', true )
  options.set( constants.WP_FEATURED_MEDIA, true )
  fetchAllPosts( 'https://paddyfontaine.fr/wp-json', 'posts', options ).then( results => {
      if ( results.length ) {
        posts.value = results
        current.value = 0
      }
    } )

</script>

<template>
  <nav class="snrg-posts">
    <header>
      <h1 v-if="current !== undefined" v-html="posts[ current ].title"></h1>
    </header>
    <aside>
      <Transition name="snrg">
        <img v-if="current !== undefined && posts[ current ].data.get( constants.WP_FEATURED_MEDIA )" :src="posts[ current ].data.get( constants.WP_FEATURED_MEDIA )" />
        <img v-else-if="current !== undefined" :src="defaultImage" />
      </Transition>
    </aside>
    <div v-if="posts.length">
      <article v-for="( post, index ) in posts" :key="post.id">
        <header v-if="current !== undefined && current !== index">
          <h1 v-html="post.title"></h1>
        </header>
        <aside>
          <img v-if="post.data.get( constants.WP_FEATURED_MEDIA )" :src="post.data.get( constants.WP_FEATURED_MEDIA )" style="width:400px; height:auto" />
          <img v-else :src="defaultImage" style="width:400px; height:auto" />
        </aside>
        <div v-if="current !== undefined && current === index && post.data.get( 'excerpt.rendered' )" v-html="post.data.get( 'excerpt.rendered' )"></div>
      </article>
    </div>
  </nav>
</template>

<style scoped>
  nav.snrg-posts {
    position: relative;
    box-sizing: border-box;
    width: 100vw;
    height: 100vh;
    overflow: clip;
    padding: var(--snrg-outer-margin);
    background-color: black;
  }

  nav.snrg-posts.snrg-enter-active {
    transition: opacity var(--SNRG-HEADER-TRANSITION-DURATION) var(--SNRG-HEADER-TRANSITION-TIMING) var(--SNRG-HEADER-TRANSITION-DURATION);
  }

  nav.snrg-posts.snrg-leave-active {
    transition: opacity var(--SNRG-HEADER-TRANSITION-DURATION) var(--SNRG-HEADER-TRANSITION-TIMING);
  }

  nav.snrg-posts.snrg-enter-from,
  nav.snrg-posts.snrg-leave-to {
    opacity: 0;
  }

  nav.snrg-posts > header > h1 {
    margin: 0;
  }

  nav.snrg-posts > aside {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    z-index: -1;
  }

  nav.snrg-posts > aside::after {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    content: '';
    background-color: grey;
    mix-blend-mode: darken;
  }

  nav.snrg-posts > aside > img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: blur(15px)
  }

  nav.snrg-posts > div {
    display: flex;
  }
</style>