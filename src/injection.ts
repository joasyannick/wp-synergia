import type { Ref, InjectionKey } from 'vue'

export type IMenu = { opened: Ref< boolean >, openOrClose: () => void }
export const iMenu = Symbol() as InjectionKey< IMenu >
export const iScrollDirection = Symbol() as InjectionKey< Ref< string > >