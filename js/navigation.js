/* global ampScreenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

(function( $ ) {
    var masthead, menuToggle, siteNavContain, siteNavigation;

    function initMainNavigation( container ) {

        // Add dropdown toggle that displays child menu items.
        var dropdownToggle = $( '<button />', { 'class': 'dropdown-toggle', 'aria-expanded': false })
            .append( $( '<span />', { 'class': 'dropdown-symbol', text: '+' }) )
            .append( $( '<span />', { 'class': 'screen-reader-text', text: ampScreenReaderText.expand }) );

        container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( dropdownToggle );

        container.find( '.dropdown-toggle' ).click( function( e ) {
            var _this = $( this ),
                screenReaderSpan = _this.find( '.screen-reader-text' ),
                dropdownSymbol = _this.find( '.dropdown-symbol' );

            e.preventDefault();
            _this.toggleClass( 'toggled-on' );
            _this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );

            _this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );

            screenReaderSpan.text( screenReaderSpan.text() === ampScreenReaderText.expand ? ampScreenReaderText.collapse : ampScreenReaderText.expand );
            dropdownSymbol.text( dropdownSymbol.text() === '+' ? dropdownSymbol.text = '-' : dropdownSymbol.text = '+');
        });
    }

    initMainNavigation( $( '.main-navigation' ) );

    masthead       = $( '#masthead' );
    menuToggle     = masthead.find( '.menu-toggle' );
    siteNavContain = masthead.find( '.main-navigation' );
    siteNavigation = masthead.find( '.main-navigation > div > ul' );

    // Enable menuToggle.
    (function() {

        // Return early if menuToggle is missing.
        if ( ! menuToggle.length ) {
            return;
        }

        // Add an initial value for the attribute.
        menuToggle.attr( 'aria-expanded', 'false' );

        menuToggle.on( 'click.amp', function() {
            siteNavContain.toggleClass( 'toggled-on' );

            $( this ).attr( 'aria-expanded', siteNavContain.hasClass( 'toggled-on' ) );
        });
    })();

    // Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
    (function() {
        if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
            return;
        }

        // Toggle `focus` class to allow submenu access on tablets.
        function toggleFocusClassTouchScreen() {
            if ( 'none' === $( '.menu-toggle' ).css( 'display' ) ) {

                $( document.body ).on( 'touchstart.amp', function( e ) {
                    if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
                        $( '.main-navigation li' ).removeClass( 'focus' );
                    }
                });

                siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' )
                    .on( 'touchstart.amp', function( e ) {
                        var el = $( this ).parent( 'li' );

                        if ( ! el.hasClass( 'focus' ) ) {
                            e.preventDefault();
                            el.toggleClass( 'focus' );
                            el.siblings( '.focus' ).removeClass( 'focus' );
                        }
                    });

            } else {
                siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' ).unbind( 'touchstart.amp' );
            }
        }

        if ( 'ontouchstart' in window ) {
            $( window ).on( 'resize.amp', toggleFocusClassTouchScreen );
            toggleFocusClassTouchScreen();
        }

        siteNavigation.find( 'a' ).on( 'focus.amp blur.amp', function() {
            $( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
        });
    })();
})( jQuery );
