const constants = Object.freeze( {
    animation: {
        menu: {
            duration: {
                onOpenOrClose: 2 // seconds
              }
          }
      },
    starryNight: {
        starCount: 300,
        viewBoxWidth: 16000,
        viewBoxHeight: 9000,
        starRadius: 5,
        twinklingStarRadius: 20,
        twinklingStarDuration: 4 // seconds
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
                name: 'biography',
                path: 'biography',
                fullPath: '/biography'
              },
            post: {
                name: 'post',
                path: ':post',
                fullPath: '/:post'
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
            name: 'account',
            path: '/account',
            fullPath: '/account'
          }
      }
  } )

export default constants