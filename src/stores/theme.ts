import { ref, computed, watch } from 'vue'
import { defineStore } from 'pinia'
import constants from '@/constants'

export const useThemeStore = defineStore( 'theme', () => {

  const storedTheme = localStorage.getItem( constants.theme.storageKey )

  const theme = ref( storedTheme ? storedTheme : ( matchMedia( '( prefers-color-scheme : dark )' ).matches ? constants.theme.dark : constants.theme.light ) )
  
  const isLight = computed( () => theme.value === constants.theme.light )

  const onThemeChanged = ( theme : string ) => {
      localStorage.setItem( constants.theme.storageKey, theme )
      document.getElementById( 'snrg-app' )!.dataset.snrgTheme = theme
    }

  const doSwitch = () => theme.value = isLight.value ? constants.theme.dark : constants.theme.light

  watch( theme, async ( now ) => onThemeChanged( now ) )

  onThemeChanged( theme.value )

  return { isLight, doSwitch }
} )