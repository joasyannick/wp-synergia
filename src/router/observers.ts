import constants from '@/constants'

const observers = Object.freeze( {
    isPaddyView: ( route: string ) => [ constants.route.paddy.name, constants.route.paddy.biography.name, constants.route.paddy.post.name ].includes( route ),
    isBiographyView: ( route: string ) => route === constants.route.paddy.biography.name,
    isHelikiaView: ( route: string ) => [ constants.route.helikia.name, constants.route.helikia.synergia.name, constants.route.helikia.module.name, constants.route.helikia.session.name ].includes( route ),
    isSynergiaView: ( route: string ) => route === constants.route.helikia.synergia.name
  } )

export default observers