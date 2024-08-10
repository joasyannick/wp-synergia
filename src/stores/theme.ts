import { inject, ref, computed, watch } from 'vue'
import { defineStore } from 'pinia'
import constants from '@/constants'
import type { IApp } from '@/injection'
import { iApp } from '@/injection'

export const useThemeStore = defineStore( 'theme', () => {

  const app = inject( iApp ) as IApp

  const storedTheme = localStorage.getItem( constants.theme.storageKey )

  const theme = ref( storedTheme ? storedTheme : ( matchMedia( '( prefers-color-scheme : dark )' ).matches ? constants.theme.dark : constants.theme.light ) )
  
  const isLight = computed( () => theme.value === constants.theme.light )

  const toggle = () => theme.value = isLight.value ? constants.theme.dark : constants.theme.light

  //watch( theme, async ( now ) => { localStorage.setItem( constants.theme.storageKey, now ); document.getElementById( 'snrg-app' )!.dataset.snrgTheme = now }, { immediate: true } )
  watch( theme, async ( now ) => {
      localStorage.setItem( constants.theme.storageKey, now );
      if ( app.element.value ) {
        app.element.value.dataset.snrgTheme = now
      }
    }, { immediate: true } )

  return { isLight, toggle }
} )