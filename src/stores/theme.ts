import { computed } from 'vue'
import { useStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import constants from '@/constants'

export const useThemeStore = defineStore( 'theme', () => {
  const storedTheme = useStorage( constants.theme.storageKey, constants.theme.dark )
  const theme = computed( () => storedTheme.value )
  const toggle = () => storedTheme.value = theme.value === constants.theme.light ? constants.theme.dark : constants.theme.light
  return { theme, toggle }
} )