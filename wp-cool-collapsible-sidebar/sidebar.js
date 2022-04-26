jQuery( 'document' ).ready( function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $( function() {
	 *
	 * } );
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load( function() {
	 *
	 * } );
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	if( !!document.getElementById( 'primary' ) ) {

		document.getElementById( 'middle-wrapper' ).insertBefore( 
			document.getElementById( 'sidebar' ), 
			document.getElementById( 'primary' ) 
		);
		
		document.getElementById( 'middle-wrapper' ).insertBefore( 
			document.getElementById( 'primary' ),
			document.getElementById( 'sidebar-right' )
		);

	}

	$( document ).on( 'click', '.nav-dropdown-expand', function( event ) {
		event.preventDefault();

		if( $( this ).siblings().hasClass( 'show' ) ){

			$( this ).parent().siblings().removeClass( 'active' );
			$( this ).parent().siblings('.nav-dropdown-expand').removeClass( 'active' );
			$( this ).siblings( 'ul' ).hide();
			$( this ).siblings().removeClass( 'show' );
			$( this ).siblings().removeClass( 'active' );
			$( this ).removeClass( 'show' );
			$( this ).removeClass( 'active' );
			$( this ).html( '<i class="bi bi-caret-down-fill"></i>' );

		} else {

			$( this ).siblings( 'ul' ).show();
			$( this ).siblings().addClass( 'show' );
			$( this ).siblings().addClass( 'active' );
			$( this ).addClass( 'show' );
			$( this ).addClass( 'active' );
			$( this ).html( '<i class="bi bi-caret-up-fill"></i>' );

		}
		
	} );

	let _href;

	$( document ).on( 'click', '.sidebar-drawer-toggle', function( event ) {
		event.preventDefault();
		$( '.open-drawer, .close-drawer' ).toggleClass( 'show' );
		$( '#sidebar-drawers, #primary' ).toggleClass( 'open' );
	} );

	$( document ).on( 'click', '#sidebar-nav .sidebar-nav-item a.gollcdt-funnels', function( event ) {
		event.preventDefault();

		let href = $( this ).attr( 'href' );
		
		if( _href == href ) {

			$( '.open-drawer, .close-drawer' ).toggleClass( 'show' );
			$( '#sidebar-drawers, #primary' ).toggleClass( 'open' );

		} else {

			$( '.open-drawer' ).removeClass( 'show' );
			$( '.close-drawer' ).addClass( 'show' );
			$( '#sidebar-drawers, #primary' ).addClass( 'open' );
			
		}

		$( '#sidebar-nav .sidebar-nav-item a.gollcdt-funnels' ).removeClass( 'selected' );
		$( '#sidebar-nav .sidebar-nav-item a.gollcdt-funnels' ).removeClass( 'active' );

		$( '.sidebar-drawer' ).removeClass( 'selected' );
		$( '.sidebar-drawer' ).removeClass( 'active' );

		$( this ).addClass( 'selected' );
		$( this ).addClass( 'active' );

		find_sidebar_drawer( this ).addClass( 'selected' );
		find_sidebar_drawer( this ).addClass( 'active' );

		_href = $( this ).attr( 'href' );

	} );

	function find_sidebar_drawer( selector ) {

		selector = $( selector ).attr( 'href' ).replace( '###', '#' ).replace( '##', '#' );

		if( selector.includes( '.default' ) ) {

			return $( $( selector ).attr( 'href' ) );

		}

		return $( selector.replace( '-anchor', '' ).replace( '###', '#' ).replace( '##', '#' ) );

	}

} );