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
              },
            session: {
                name: 'session',
                path: ':module/:session',
                fullPath: '/helikia/:module/:session'
              }
          },
        account: {
            name: 'compte',
            path: '/compte',
            fullPath: '/compte'
          }
      }
  } )

export default constants