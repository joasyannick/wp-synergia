<script lang="ts">
  export default {
    data() {
      return {
        posts: [] as any
      }
    },
    created() {
      fetch(import.meta.env.VITE_WP_REST_URL + 'wp/v2/posts?_embed=author,wp:term,wp:featuredmedia&_fields=date_gmt,excerpt.rendered,slug,title.rendered,_embedded,_links')
        .then(response => response.json())
        .then(posts => 
          this.posts = posts
            .filter((post: any) =>
              post._embedded['wp:term'].some((taxonomy: any) =>
                taxonomy.some((term: any) =>
                  'snrg_post_tag' === term.taxonomy && 'Paddy News' === term.name))))
    }
  }
</script>

<template>
  <h1>Paddy Fontaine</h1>
  <nav id="snrg-paddy-news">
    <article v-for="post in posts">
      <header>
        <img v-if="post._embedded.hasOwnProperty('wp:featuredmedia')" :src="post._embedded['wp:featuredmedia'][0].source_url"/>
        <h2 v-html="post.title.rendered"></h2>
      </header>
      <div v-html="post.excerpt.rendered"></div>
      <footer>
        <address>{{ post._embedded.author[0].name }}</address>
        <time :datetime="post.date_gmt">{{ post.date_gmt }}</time>
      </footer>
    </article>
  </nav>
</template>

<style>
</style>
