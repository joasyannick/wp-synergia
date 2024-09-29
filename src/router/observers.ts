import constants from '@/constants'

const observers = Object.freeze( {
    isPaddyView: ( route: string ) => [ constants.route.paddy.name, constants.route.paddy.biography.name, constants.route.paddy.post.name ].includes( route ),
    isPaddyHomeView: ( route: string ) => route === constants.route.paddy.name,
    isBiographyView: ( route: string ) => route === constants.route.paddy.biography.name,
    isHelikiaView: ( route: string ) => [ constants.route.helikia.name, constants.route.helikia.synergia.name, constants.route.helikia.module.name ].includes( route ),
    isHelikiaHomeView: ( route: string ) => route === constants.route.helikia.name,
    isSynergiaView: ( route: string ) => route === constants.route.helikia.synergia.name,
    isAccountView: ( route: string ) => route === constants.route.account.name,
    isErrorView: ( route: string ) => route === constants.route.error.name
  } )

export default observers