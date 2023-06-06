<script setup lang="tsx">
  import { defineComponent, ref, computed, watch, onUnmounted } from 'vue'
  import type { Ref } from 'vue'
  import constants from '@/constants'
  import Graphic from '@/components/images/Graphic.vue'

  const props = defineProps< { starCount: number } >()

  const sky = defineComponent(
      ( props: { clipId: string } ) => {
          const image = ref( '' )

          const fetchSkyImage = async () => {
              try {
                const response = await fetch( import.meta.env.VITE_WP_REST_URL + 'synergia/v1/home/image' )
                image.value = await response.json()
              } catch ( exception ) {
                console.error( 'Failed to fetch the stary night image' )
              }
            }

          fetchSkyImage()

          return () => (
              <g class="snrg-sky" clip-path={ 'url(#' + props.clipId + ')' }>
                <defs>
                  <linearGradient id="snrg-starry-night-sky-gradient" gradientTransform="rotate(90)">
                    <stop offset="0%" style="stop-color:hsl(225,100%,25%)" />
                    <stop offset="44.6%" style="stop-color:hsl(200,100%,50%)" />
                    <stop offset="66.3%" style="stop-color:hsl(190,100%,50%)" />
                  </linearGradient>
                </defs>
                <image href={ image.value } width={ constants.starryNight.viewBoxWidth } height={ constants.starryNight.viewBoxHeight } />
                <rect class="snrg-overlay" x="0" y="0" width={ constants.starryNight.viewBoxWidth } height={ constants.starryNight.viewBoxHeight } style="fill:url(#snrg-starry-night-sky-gradient)" />
              </g>
            )
        },
      { props: ['clipId' ] }
    )

  const stars = defineComponent(
      ( props: { starCount: number, clipId: string } ) => {
          const stars: { x: number, y: number }[] = []
          for (let i = 0; i < props.starCount; i++) {
            stars.push( { x: Math.random() * constants.starryNight.viewBoxWidth, y: Math.random() * constants.starryNight.viewBoxHeight } )
          }
          const maxShootingStarY = 5070
          const shootingStarDistance = 7000
          const trailHalfHeight = 2/3 * constants.starryNight.twinklingStarRadius
          const trailLength = 0.25 * shootingStarDistance
          const shootingStarDelay = 10 // seconds
          const shootingStarDuration = 2 // seconds
          const shootingStarNow = ref( false )
          let shootingStarTimeout = 0

          const sleep = ( delay: number ) => new Promise( ( resolve ) => setTimeout( resolve, delay ) )
          const toRadians = ( degrees: number ) => degrees * ( Math.PI / 180 )

          const shootingStar: Ref< { x: number, y: number, angle: number } > = ref( { x: 0, y: 0, angle: 0 } )
          const shootingStarOpacityRef = ref< SVGAnimateElement | null >( null )
          const shootingStarMotionRef = ref< SVGAnimateMotionElement | null >( null )

          const shootingStarEnd = computed( () => {
              return { x: shootingStarDistance * Math.cos( toRadians( shootingStar.value.angle ) ), y: shootingStarDistance * Math.sin( toRadians( shootingStar.value.angle ) ) }
            } )

          watch(
              shootingStarNow,
              ( now, before ) => {
                  if ( ! now ) {
                    const delay = shootingStarDelay + ( Math.random() < 0.5 ? 1 : -1 ) * Math.random() * 0.8 * shootingStarDelay
                    shootingStarTimeout = setTimeout(
                        async () => {
                            shootingStarNow.value = true
                            const x = Math.random() * constants.starryNight.viewBoxWidth
                            const y = Math.random() * maxShootingStarY
                            let angle = Math.random() * 90
                            if ( x > constants.starryNight.viewBoxWidth / 2 ) {
                              angle += 90
                            }
                            const sign = y <= maxShootingStarY / 2 ? 1 : -1
                            shootingStar.value = { x: x, y: y, angle: sign * angle }
                            shootingStarOpacityRef.value?.beginElement()
                            shootingStarMotionRef.value?.beginElement()
                            await sleep( shootingStarDuration * 1000 )
                            shootingStarNow.value = false
                          },
                        delay * 1000
                      )
                  }
                },
              { immediate: true }
            )
          
          onUnmounted( () => clearTimeout( shootingStarTimeout ) )

          return () => (
              <g class="snrg-stars" clip-path={ 'url(#' + props.clipId + ')' }>
                <g class="snrg-shooting-star" transform={ 'rotate(' + ( shootingStar.value.angle + 180 ) + ',' + shootingStar.value.x + ',' + shootingStar.value.y + ')' } style="opacity:0">
                  <defs>
                    <linearGradient id="snrg-starry-night-trail-gradient">
                      <stop offset="0%" style="stop-color:hsl(210,100%,90%)" />
                      <stop offset="100%" style="stop-color:hsl(210,100%,90%,0%)" />
                    </linearGradient>
                  </defs>
                  <path id="snrg-starry-night-star-path" d={ 'M0,0l' + shootingStarEnd.value.x + ',' + shootingStarEnd.value.y } style="visibility:hidden" />
                  <circle cx={ shootingStar.value.x } cy={ shootingStar.value.y } r={ constants.starryNight.twinklingStarRadius } style="fill:hsl(210,100%,90%)" />
                  <rect x={ shootingStar.value.x } y={ shootingStar.value.y - trailHalfHeight } width={ trailLength } height={ 2 * trailHalfHeight } style="fill:url(#snrg-starry-night-trail-gradient)" />
                  <animate ref={ shootingStarOpacityRef } attributeType="CSS" attributeName="opacity" begin="indefinite" from="0" to="0" values="0;1;0" keyTimes="0;0.5;1" dur={ shootingStarDuration + 's' } />
                  <animateMotion ref={ shootingStarMotionRef } begin="indefinite" dur={ shootingStarDuration + 's' }>
                    <mpath href="#snrg-starry-night-star-path" />
                  </animateMotion>
                </g>
                { stars.map( ( { x, y }, index ) => (
                    <circle cx={ x } cy={ y } style="fill:hsl(210,100%,90%,66%)">
                      <animate  attributeName="r" from={ constants.starryNight.starRadius } to={ constants.starryNight.starRadius } values={ constants.starryNight.starRadius + ';' + constants.starryNight.twinklingStarRadius + ';' + constants.starryNight.starRadius } keyTimes="0;0.5;1" begin={ ( index % constants.starryNight.twinklingStarDuration ) + 's' } dur={ constants.starryNight.twinklingStarDuration + 's' } repeatCount="indefinite" />
                    </circle>
                  ) ) }
              </g>
            )
        },
      { props: [ 'starCount', 'clipId' ] }
    )
</script>

<template>
    <Graphic class="snrg-sky" :view-box-width="constants.starryNight.viewBoxWidth" :view-box-height="constants.starryNight.viewBoxHeight" clip-id="snrg-starry-night-stars-clip">
      <sky clip-id="snrg-starry-night-stars-clip" />
    </Graphic>
    <Graphic class="snrg-stars" :view-box-width="constants.starryNight.viewBoxWidth" :view-box-height="constants.starryNight.viewBoxHeight" clip-id="snrg-starry-night-stars-clip">
      <stars :star-count="props.starCount" clip-id="snrg-starry-night-stars-clip" />
    </Graphic>
</template>

<style scoped>
</style>