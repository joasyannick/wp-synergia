import * as constants from '@/constants'

const optionalParameters = ( options: Map< string, boolean > ): string => {
    const parameters = [] as string[]
    const embeddingRequested = options.get( constants.WP_FEATURED_MEDIA ) || options.get( constants.WP_TERM )
    if ( embeddingRequested ) {
      const toEmbed = [] as string[]
      if ( options.get( constants.WP_FEATURED_MEDIA ) ) {
        toEmbed.push( constants.WP_FEATURED_MEDIA )
      }
      if ( options.get( constants.WP_TERM ) ) {
        toEmbed.push( constants.WP_TERM )
      }
      parameters.push( '_embed=' + toEmbed.join( ',' ) )
    }
    const fields = [ constants.WP_ID, constants.WP_SLUG, constants.WP_DATE_GMT, constants.WP_TITLE_RENDERED ]
    if ( options.get( constants.WP_EXCERPT_RENDERED ) ) {
      fields.push( constants.WP_EXCERPT_RENDERED )
    }
    if ( options.get( constants.WP_CONTENT_RENDERED ) ) {
      fields.push( constants.WP_CONTENT_RENDERED )
    }
    if ( embeddingRequested ) {
      fields.push( constants.WP_LINKS )
      fields.push( constants.WP_EMBEDDED )
    }
    parameters.push( '_fields=' + fields.join( ',' ) )
    return '&' + parameters.join( '&' )
  }

const optionalData = ( options: Map< string, boolean >, post: any ): Map< string, any > => {
    const data = new Map() as Map< string, any >
    if ( options.get( constants.WP_EXCERPT_RENDERED ) && post.excerpt.rendered ) {
      data.set( constants.WP_EXCERPT_RENDERED, post.excerpt.rendered )
    }
    if ( options.get( constants.WP_CONTENT_RENDERED ) && post.content.rendered ) {
      data.set( constants.WP_CONTENT_RENDERED, post.content.rendered )
    }
    if ( options.get( constants.WP_FEATURED_MEDIA ) && post._embedded[ constants.WP_FEATURED_MEDIA ] && post._embedded[ constants.WP_FEATURED_MEDIA ].length && post._embedded[ constants.WP_FEATURED_MEDIA ][ 0 ].source_url ) {
      data.set( constants.WP_FEATURED_MEDIA, post._embedded[ constants.WP_FEATURED_MEDIA ][ 0 ].source_url )
    }
    if ( options.get( constants.WP_TERM ) && post._embedded[ constants.WP_TERM ] ) {
      data.set( constants.WP_TERM, post._embedded[ constants.WP_TERM ] )
    }
    return data
  }

export const fetchPost = async ( url: string, postType: string, slug: string, options: Map< string, boolean > ): Promise< null | { id: number, date_gmt: string, title: string, data: Map< string, any > } > => {
    try {
      const request = url + '/wp/v2/' + postType + '?slug=' + slug + optionalParameters( options )
      console.log( request )
      const response = await fetch( request )
      const json = await response.json()
      if ( json.length ) {        
        return { id: json[ 0 ].id, date_gmt: json[ 0 ].date_gmt, title: json[ 0 ].title.rendered, data: optionalData( options, json[ 0 ] ) }
      }
    } catch ( exception ) {
      console.error( `Failed to fetch /${ postType }/${ slug }: ${ exception }` )
    }
    return null
  }

export const fetchAllPosts = async ( url: string, postType: string, options: Map< string, boolean > ): Promise< { id: number, slug: string, date_gmt: string, title: string, data: Map< string, any > }[] > => {
    try {
      const posts = [] as { id: number, slug: string, date_gmt: string, title: string, data: Map< string, string > }[]
      for ( let [ page, more ] = [ 1, true ]; more; page++ ) {
        const request = url + '/wp/v2/' + postType + '?per_page=100&page=' + page + optionalParameters( options )
        console.log( request )
        const response = await fetch( request )
        const json = await response.json()
        json.forEach( ( post: any ) => posts.push( { id: post.id, slug: post.slug, date_gmt: post.date_gmt, title: post.title.rendered, data: optionalData( options, post ) } ) )
        more = page <= parseInt( response.headers.get( 'X-WP-TotalPages' )! )
      }
      return posts
    } catch ( exception ) {
      console.error( `Failed to fetch /${ postType }: ${ exception }` )
    }
    return []
  }

// URL example: https://paddyfontaine.fr/wp-json/wp/v2/posts?per_page=100&page=1&_embed=wp:featuredmedia,wp:term&_fields=id,slug,date_gmt,title.rendered,excerpt.rendered,content.rendered,_links,_embedded