import { fileURLToPath, URL } from 'node:url'

import { defineConfig, loadEnv } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'

// https://vitejs.dev/config/
export default defineConfig( {
    plugins: [
        vue( {
            template: {
                compilerOptions: {
                    isCustomElement: ( tag ) => [ 'feDropShadow' ].includes( tag )
                  }
              }
          } ),
        vueJsx()
      ],
    resolve: {
        alias: {
            '@': fileURLToPath( new URL( './src', import.meta.url ) )
          }
      },
    build: {
        rollupOptions: {
            output: {
                manualChunks: () => 'synergia',
                entryFileNames: `assets/[name].js`,
                chunkFileNames: `assets/[name].js`,
                assetFileNames: `assets/[name].[ext]`
              }
          }
      }
  } )