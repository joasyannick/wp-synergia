import { ref } from 'vue'
import { defineStore } from 'pinia'
import constants from '@/constants'

export const useMenuStore = defineStore( 'menu', () => {
  const opened = ref( false )
  const enoughSpace = ref( false )

  const open = () => opened.value = true
  const close = () => opened.value = false
  const openOrClose = () => opened.value = ! opened.value

  const mediaQueryList = matchMedia( '( min-width : ' + constants.menu.minScreenWidth + constants.menu.unit + ' )' )
  enoughSpace.value = mediaQueryList.matches
  mediaQueryList.addEventListener( 'change', ( event ) => enoughSpace.value = event.matches )

  return { opened, enoughSpace, open, close, openOrClose }
} )