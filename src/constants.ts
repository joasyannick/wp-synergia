import { throttle } from "throttle-debounce"

const buildRequestParameters = ( options: Map< string, boolean >, parameters: string[] ): void => {
    const embedded = options.get( 'wp:featuredmedia' ) || options.get( 'wp:term' )
    if ( embedded ) {
      parameters.push( '&_embed=' )
      const embed = [] as string[]
      if ( options.get( 'wp:featuredmedia' ) ) {
        embed.push( 'wp:featuredmedia' )
      }
      if ( options.get( 'wp:term' ) ) {
        embed.push( 'wp:term' )
      }
      parameters.push( embed.join( ',' ) )
    }
    parameters.push( '&_fields=id,slug,date_gmt,title.rendered' )
    if ( options.get( 'excerpt.rendered' ) ) {
      parameters.push( ',excerpt.rendered' )
    }
    if ( options.get( 'content.rendered' ) ) {
      parameters.push( ',content.rendered' )
    }
    if ( embedded ) {
      parameters.push( ',_links,_embedded' )
    }
  }

const buildPostData = ( options: Map< string, boolean >, post: any, data: Map< string, any > ): void => {
    if ( options.get( 'excerpt.rendered' ) && post.excerpt.rendered ) {
      data.set( 'excerpt.rendered', post.excerpt.rendered )
    }
    if ( options.get( 'content.rendered' ) && post.content.rendered ) {
      data.set( 'content.rendered', post.content.rendered )
    }
    if ( options.get( 'wp:featuredmedia' ) && post._embedded[ 'wp:featuredmedia' ] && post._embedded[ 'wp:featuredmedia' ].length && post._embedded[ 'wp:featuredmedia' ][ 0 ].source_url ) {
      data.set( 'wp:featuredmedia', post._embedded[ 'wp:featuredmedia' ][ 0 ].source_url )
    }
    if ( options.get( 'wp:term' ) && post._embedded[ 'wp:term' ] ) {
      data.set( 'wp:term', post._embedded[ 'wp:term' ] )
    }
  }

const constants = Object.freeze( {
    throttle: {
        period: 100 // milliseconds
      },
    starryNight: {
        starCount: 300,
        viewBoxWidth: 16000,
        viewBoxHeight: 9000,
        starRadius: 5,
        twinklingStarRadius: 15,
        twinklingStarDuration: 4, // seconds
        mountainGlowDuration: 4 // seconds
      },
    theme: {
        light : 'light',
        dark : 'dark',
        storageKey: 'snrg.theme'
      },
    route: {
        paddy: {
            name: 'paddy',
            path: '/',
            fullPath: '/',
            biography: {
                name: 'bio',
                path: 'bio',
                fullPath: '/bio'
              },
            post: {
                name: 'post',
                path: ':post',
                fullPath: '/blog/:post'
              }
          },
        helikia: {
            name: 'helikia',
            path: '/helikia',
            fullPath: '/helikia',
            synergia: {
                name: 'synergia',
                path: 'synergia',
                fullPath: '/helikia/synergia'
              },
            module: {
                name: 'module',
                path: ':module',
                fullPath: '/helikia/:module'
              }
          },
        account: {
            name: 'compte',
            path: '/compte',
            fullPath: '/compte'
          },
        error: {
            name: '404',
            path: '/404',
            fullpath: '/404'
          }
      },
    page: {
        biography: 'snrg-bio',
        helikia: 'snrg-helikia',
        introduction: 'snrg-intro',
        error: 'snrg-404'
      },
    function: {
        fetchPost: async ( url: string, postType: string, slug: string, options: Map< string, boolean > ): Promise< null | { id: number, date_gmt: string, title: string, data: Map< string, any > } > => {
            try {
              const request = [ url, '/wp/v2/', postType, '?slug=', slug ]
              buildRequestParameters( options, request )
              console.log( request.join( '' ) )
              const response = await fetch( request.join( '' ) )
              const json = await response.json()
              if ( json.length ) {
                const data = new Map() as Map< string, string >
                buildPostData( options, json[0], data )
                return { id: json[0].id, date_gmt: json[0].date_gmt, title: json[0].title.rendered, data }
              }
            } catch ( exception ) {
              console.error( `Failed to fetch "${ slug }" in "${ postType }": ${ exception }` )
            }
            return null
          },
        fetchAllPosts: async ( url: string, postType: string, options: Map< string, boolean > ): Promise< { id: number, slug: string, date_gmt: string, title: string, data: Map< string, any > }[] > => {
            try {
              const posts = [] as { id: number, slug: string, date_gmt: string, title: string, data: Map< string, string > }[]
              for ( let [ page, more ] = [ 1, true ]; more; page++ ) {
                const request = [ url, '/wp/v2/', postType, '?per_page=100&page=', page.toString() ]
                buildRequestParameters( options, request )
                console.log( request.join( '' ) )
                const response = await fetch( request.join( '' ) )
                const json = await response.json()
                json.forEach( ( post: any ) =>  {
                    const data = new Map() as Map< string, any >
                    buildPostData( options, post, data )
                    posts.push( { id: post.id, slug: post.slug, date_gmt: json[0].date_gmt, title: post.title.rendered, data } )
                  } )
                more = page < parseInt( response.headers.get( 'X-WP-TotalPages' )! )
              }
              if ( posts.length ) {
                return posts
              }
            } catch ( exception ) {
              console.error( `Failed to fetch "${ postType }": ${ exception }` )
            }
            return []
          }
      }
  } )

// https://paddyfontaine.fr/wp-json/wp/v2/posts?per_page=100&page=1&_embed=wp:featuredmedia,wp:term&_fields=id,slug,date_gmt,title.rendered,excerpt.rendered,content.rendered,_links,_embedded

export default constants