import * as constants from '@/constants'

export const isPaddyView = ( route: string ) => [ constants.PADDY_ROUTE, constants.BIOGRAPHY_ROUTE, constants.POST_ROUTE ].includes( route )
export const isPaddyHomeView = ( route: string ) => route === constants.PADDY_ROUTE
export const isBiographyView = ( route: string ) => route === constants.BIOGRAPHY_ROUTE
export const isHelikiaView = ( route: string ) => [ constants.HELIKIA_ROUTE, constants.SYNERGIA_ROUTE, constants.MODULE_ROUTE ].includes( route )
export const isHelikiaHomeView = ( route: string ) => route === constants.HELIKIA_ROUTE
export const isSynergiaView = ( route: string ) => route === constants.SYNERGIA_ROUTE
export const isAccountView = ( route: string ) => route === constants.ACCOUNT_ROUTE
export const isErrorView = ( route: string ) => route === constants.ERROR_ROUTE