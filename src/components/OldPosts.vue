<script setup lang="ts">
  import { ref, computed, watch, onMounted } from 'vue'
  import { RouterLink } from 'vue-router'
  import { storeToRefs } from 'pinia'
  import constants from '@/constants'
  import { useThemeStore } from '@/stores/theme'

  const themeStore = useThemeStore()
  //const { theme } = storeToRefs( themeStore )
  const postsPerPage = 5
  // Si le nb de posts sur la derniere page est paire et >=2, on rajoute dans la liste un poste qui est le même que
  // le premier de la liste: cela garanti qu'une page est toujours fait d'un nombre impair de poste : 0, 1, 3, 5, ou 7. 
  const delay = 8000

  const dataReady = ref( false )
  const lightBackground = ref( '' )
  const darkBackground = ref( '' )
  const background = ref( '' )
  const showExcerpt = ref( false )
  const categorySelection = ref( false )
  const categories = ref( [] as {id: number, name: string}[] )
  const posts = ref( [] as any[] )
  const postCount = ref( 0 )
  const pageCount = ref( 0 )
  const page = ref( 0 )
  const current = ref( 0 )
  const interval = ref( 0 )

  const cssStyle = computed( () => ( { '--snrg-news-image' : ! background.value ? 'none' : 'url( ' + background.value + ' )' } ) )
  const hasPreviousPage = computed( () => page.value >= 1 )
  const hasNextPage = computed( () => page.value < pageCount.value - 1 )
  const window = computed( () => Array.from( { length : posts.value.length }, ( value, index ) => ( current.value - ( index - Math.floor( posts.value.length / 2 ) ) % posts.value.length ) % posts.value.length ) )

  const onPreviousPage = () => page.value--
  const onNextPage = () => page.value++
  const nextPost = () => { if ( posts.value.length ) current.value = ( current.value + 1 ) % posts.value.length }
  const onPost = ( index : number ) => {
      current.value = index
      if ( interval.value ) {
        clearInterval( interval.value )
        interval.value = setInterval( nextPost, delay )
      }
    }

  const fetchBackground = async () => {
      try {
        [ lightBackground.value, darkBackground.value ] = await Promise.all( [
            fetch( import.meta.env.VITE_WP_REST_URL + 'synergia/v1/welcome/image/light' )
              .then( ( response ) => response.json() ),
            fetch( import.meta.env.VITE_WP_REST_URL + 'synergia/v1/welcome/image/dark' )
              .then( ( response ) => response.json() )
          ] )
        background.value = themeStore.isLight ? lightBackground.value : darkBackground.value
      } catch ( exception ) {
        console.error( 'Failed to fetch the background image' )
      }
    }
  const fetchPosts = async () => {
      try {
        const request = import.meta.env.VITE_WP_REST_URL + 'wp/v2/posts?per_page=' + postsPerPage + '&page=' + ( page.value + 1 ) + '&_embed=author,wp:featuredmedia&_fields=id,slug,date_gmt,excerpt.rendered,link,title.rendered,_embedded,_links'
        const response = await fetch( categories.value.length ? request + '&categories=' + categories.value.map( ( category ) => category.id ).join( ',' ) : request )
        postCount.value = parseInt( response.headers.get( 'x-wp-total' )!, 10 )
        pageCount.value = parseInt( response.headers.get( 'x-wp-totalPages' )!, 10 )
        posts.value = await response.json()
        posts.value.forEach( ( post ) =>
            fetch( import.meta.env.VITE_WP_REST_URL + 'wp/v2/comments?post=' + post.id )
              .then( ( response ) => post.commentCount = parseInt( response.headers.get( 'x-wp-total' )!, 10 ) )
          )
        dataReady.value = true
      } catch ( exception ) {
        console.error( 'Failed to fetch the most recent posts' )
        dataReady.value = false
      }
      return dataReady.value
    }

  watch( page, async () => fetchPosts() )
  //watch( theme, async () => { if ( lightBackground.value && darkBackground.value ) background.value = themeStore.isLight ? lightBackground.value : darkBackground.value } )

  onMounted( () => interval.value = setInterval( nextPost, delay ) )

  fetchBackground()
  fetchPosts()
</script>

<template>
  <nav class="snrg-news" :style="cssStyle">
    <template v-if="dataReady">
      <aside>
        <template v-for="( post, index ) in posts">
          <img v-if="post._embedded.hasOwnProperty( 'wp:featuredmedia' ) && post._embedded[ 'wp:featuredmedia' ][ 0 ].source_url" :src="post._embedded[ 'wp:featuredmedia' ][ 0 ].source_url"/>
          <div v-else></div>
        </template>
      </aside>
      <template v-for="( post, index ) in posts">
        <template v-if="index === current">
          <header v-if="post.title.rendered">
              <h2 v-html="post.title.rendered"></h2>
          </header>



          <div v-show="showExcerpt">
            <div v-if="post.excerpt.rendered" v-html="post.excerpt.rendered"></div>
            <footer>
              <address>{{ post._embedded.author[ 0 ].name }}</address>
              <time :datetime="post.date_gmt">{{ new Date( post.date_gmt ).toLocaleDateString( 'fr-FR' ) }}</time>
              <p>{{ post.commentCount }}&nbsp;commentaire{{ post.commentCount <= 1 ? '' : 's' }}</p>
              <RouterLink :to="constants.route.paddy.post.fullPath + post.slug">Lire</RouterLink>
            </footer>
          </div>
        </template>
      </template>
    </template>
  </nav>
</template>

<style scoped>
  nav.snrg-news {
    --snrg-news-height: 100vh;
    --snrg-news-controllers-eight: 2rem;
    position: relative;
    box-sizing: border-box;
    height: var( --snrg-news-height );
    padding: var( --snrg-header-height ) calc( 2 * var( --snrg-horizontal-body-padding ) ) var( --snrg-header-height ) calc( 2 * var( --snrg-horizontal-body-padding ) );
    display: flex;
    align-items: center;
    justify-content: center;
    /*
    background-size: cover;
	  background-position: center;
    background: hsl( var( --snrg-theme-hue ), var( --snrg-theme-saturation ), var( --snrg-theme-lightness ) );
    */
  }

  nav.snrg-news > button {
    position: absolute;
    left: var( --snrg-horizontal-body-padding );
    top: var( --snrg-header-height );
  }

  nav.snrg-news > aside {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
  }

  nav.snrg-news > article {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: stretch
  }

  nav.snrg-news > article > aside {
    width: 100%;
    height: 100%;
  }

  nav.snrg-news > article > aside > img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
  }

  nav.snrg-news > article > div {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    background: hsl( var( --snrg-background-hue ), var( --snrg-background-saturation ), calc( var( --snrg-background-lightness ) + ( -1 * var( --snrg-light-sign ) * 20% ) ), 0.6 );
    /*backdrop-filter: blur( 4px );*/
  }

  @media ( min-height: 40rem ) {
    nav.snrg-news {
      --snrg-news-height: 40rem;
    }
  }

  @media ( min-width: 40rem ) {
    nav.snrg-news > article {
      flex-direction: row;
      align-items: center;
    }

    nav.snrg-news > article > :is( aside, div ) {
      width: auto;
      max-width: 50%;
      height: 100%;
      max-height: none;
    }
  }
</style>