( function ( $ ) {
    function snrgRefreshIndices() {
      $( document ).find( 'input[id^=snrg-slogan-]' ).each( function( index ) {
          $( this ).attr( 'id', 'snrg-slogan-' + index )
        } )
    }
    function snrgRefreshEventListeners() {
      $( 'button.snrg-remove-slogan' ).off()
      $( 'button.snrg-remove-slogan' ).on( 'click', function( event ) {
        event.preventDefault()
        $( event.target ).parents( 'div.snrg-slogan' ).css( 'visibility', 'hidden' ).slideUp( 'normal', function () {
            $( this ).remove()
            snrgRefreshIndices()
          } )
      } )
    }
    $( document ).ready( function() {
        snrgRefreshEventListeners()
        $( 'button#snrg-add-slogan' ).on( 'click', function( event ) {
            event.preventDefault()
            $( '<div>' ).addClass( 'snrg-slogan' ).html(
                '<input type="text" id="snrg-slogan-' + ( $( 'div.snrg-slogan' ).length ) + '" name="snrg_settings[slogans][]"  value="" placeholder="Example" required />' +
                '<button type="button" class="snrg-remove-slogan">-</button>'
              ).insertBefore( 'button#snrg-add-slogan' )
            snrgRefreshEventListeners()
          } )
      } )
  } )( jQuery )