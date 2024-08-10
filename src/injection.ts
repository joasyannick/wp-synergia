import type { Ref, InjectionKey } from 'vue'

export type IMenu = { opened: Ref< boolean >, openOrClose: () => void }
export const iMenu = Symbol() as InjectionKey< IMenu >

export type IApp = { element: Ref< null | HTMLDivElement > }
export const iApp = Symbol() as InjectionKey< IApp >