<script setup lang="ts">
  import { ref } from 'vue'

  const maxComments = 40

  const dataReady = ref ( false )
  const comments = ref( [] as any[] )

  const fetchComments = async () => {
      try {
        const response = await fetch( import.meta.env.VITE_WP_REST_URL + '/wp/v2/comments?per_page=' + maxComments + '&_fields=post,author_name,date_gmt,content.rendered,link' )
        const fetchedComments = await response.json()
        for ( let maxPosts = 3, posts = [] as any[], commentIndex = 0 ; posts.length < maxPosts && commentIndex < fetchedComments.length ; commentIndex++ ) {
          if ( ! posts.includes( fetchedComments[ commentIndex ].post ) ) {
            posts.push( fetchedComments[ commentIndex ].post )
            comments.value.push( fetchedComments[ commentIndex ] )
          }
        }
        const posts = await Promise.all( comments.value.map( ( comment ) =>
            fetch( import.meta.env.VITE_WP_REST_URL + '/wp/v2/posts/' + comment.post + '?_embed=wp:featuredmedia&_fields=title.rendered,_embedded,_links' )
              .then( ( response ) => response.json() )
          ) )
        comments.value.forEach( ( comment, index ) => comment.post = posts[ index ] )
        dataReady.value = true
      } catch ( exception ) {
        console.error( 'Failed to fetch the most recent comments' )
        dataReady.value = false
      }
      return dataReady.value
    }

  fetchComments()
</script>

<template>
  <nav class="snrg-most-recent-comments">
    <header>
      <h2>Ça discute</h2>
    </header>
    <template v-if="dataReady">
      <ul>
        <li v-for="comment in comments">
          <article>
            <img v-if="comment.post.hasOwnProperty( '_embedded' ) && comment.post._embedded.hasOwnProperty( 'wp:featuredmedia' )" :src="comment.post._embedded[ 'wp:featuredmedia' ][ 0 ].source_url"/>
            <p>{{ comment.author_name }}, le <time :datetime="comment.date_gmt">{{ new Date( comment.date_gmt ).toLocaleDateString( 'fr-FR' ) }}</time> dans <a :href="comment.link" v-html="comment.post.title.rendered"></a></p>
          </article>
        </li>
      </ul>
    </template>
  </nav>
</template>

<style scoped>
  aside.snrg-most-recent-comments {
    display: initial;
  }
</style>