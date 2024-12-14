import { computed } from 'vue'
import { useStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import { DARK_THEME, LIGHT_THEME, THEME_KEY } from '@/constants'

export const useThemeStore = defineStore( 'theme', () => {
    const storedTheme = useStorage( THEME_KEY, DARK_THEME )
    const theme = computed( () => storedTheme.value )
    const toggle = () => storedTheme.value = theme.value === LIGHT_THEME ? DARK_THEME : LIGHT_THEME
    return { theme, toggle }
  } )