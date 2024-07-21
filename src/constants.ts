const constants = Object.freeze( {
    menu: {
        animation: 1 // second
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
            contact: 'contact',
            introduction: 'intro',
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
          }
      },
    function: {
        fetchPost: async ( url: string, postType: string, slug: string, withExcerpt: boolean, withContent: boolean, defaultPost: { id: number, title: string, excerpt: string, content: string } ): Promise< { id: number, title: string, excerpt: string, content: string } > => {
            try {
              const response = await fetch( url + '/wp/v2/' + postType + '?slug=' + slug + '&_fields=id,title.rendered' + ( withExcerpt ? ',excerpt.rendered' : '' ) + ( withContent ? ',content.rendered' : '' ) )
              const json = await response.json()
              if ( json.length ) {
                return { id: json[0].id, title: json[0].title.rendered, excerpt: withExcerpt ? json[0].excerpt.rendered : '', content: withContent ? json[0].content.rendered : '' }
              }
            } catch ( exception ) {
              console.error( 'Failed to fetch "' + slug  + '" in "' + postType + '": ' + exception )
            }
            return defaultPost
          },
        fetchAllPosts: async ( url: string, postType: string, withExcerpt: boolean, withContent: boolean, defaultPosts: { id: number, slug: string, title: string, excerpt: string, content: string }[] ): Promise< { id: number, slug: string, title: string, excerpt: string, content: string }[] > => {
            try {
              const posts = [] as { id: number, slug: string, title: string, excerpt: string, content: string }[]
              for ( let [ page, more ] = [ 1, true ]; more; page++ ) {
                const response = await fetch( url + '/wp/v2/' + postType +'?per_page=100&page=' + page + '&_fields=id,slug,title.rendered' + ( withExcerpt ? ',excerpt.rendered' : '' ) + ( withContent ? ',content.rendered' : '' ) )
                const json = await response.json()
                json.forEach( ( post: any ) => posts.push( { id: post.id, slug: post.slug, title: post.title.rendered, excerpt: withExcerpt ? post.excerpt.rendered : '', content: withContent ? post.content.rendered : '' } ) )
                more = page < parseInt( response.headers.get( 'X-WP-TotalPages' )! )
              }
              if ( posts.length ) {
                return posts
              }
            } catch ( exception ) {
              console.error( 'Failed to fetch "' + postType + '": ' + exception )
            }
            return defaultPosts
          }
      }
  } )

export default constants