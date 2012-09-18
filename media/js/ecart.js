$(document).ready( function() {
	$( '.subtleDropdown' ).each( function() {
		var container = $('<span class="subtleDropdown"></span>');
		var formElement = $('<input type="hidden">').attr( 'name', $(this).attr( 'name' ) ).appendTo( container );
		var selected = $('<span class="subtleDropdownCurrent"></span>').appendTo( container );
		var list = $('<ul></ul>').hide().appendTo( container );
		$('<span class="arrow">&#x25BC;</span>').appendTo( container );
		
		var tickCode = '&#10003;&nbsp;';
		var untickCode = '&nbsp;';
		
		var updateSelection = function( newValue ) {
			//$(this).is( ':selected' )
			selected.text( $(newValue).find( '.text' ).text() );
			formElement.val( $(newValue).data( 'value' ) );
			
			list.find('.icon').html( untickCode );
			$(newValue).find('.icon').html( tickCode );
		}
		
		$(this).find( 'option' ).each( function() {
			var listItem = $('<li></li>');
			var listItemIcon = $('<span class="icon"></span>').appendTo( listItem ).html( untickCode );
			var listItemText = $('<span class="text"></span>').appendTo( listItem );
			listItemText.text( $(this).text( ) );
			listItem.data( 'value', $(this).val( ) );
			listItem.click( function() {
				updateSelection( this );
			} );
			listItem.appendTo( list );
			
			if ( $(this).is( ':selected' ) ) {
				updateSelection( listItem );
			}
		} );
		
		container.click( function() {
			list.slideToggle( 'fast' );
		} );
		
		$(this).replaceWith( container );
	} );
	
	$("a.lightbox").fancybox( {
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'fade',
	} );
} );

function doAddCart( form ) {
	if ( $(form).find('input').is(':disabled') ) {
		$(form).find('input').removeAttr( 'disabled' );
		return true;
	}
	
	$(form).find('input').attr( 'disabled', true );
	
	var overlaySpinner = $('<div style="position: absolute; top: 0px; right: -20px;"><span class="spinner"></span></div>');
	var buyButton = $(form).find('.buyButton');
	buyButton.val( 'Adding...' );
	
	buyButton.after( overlaySpinner );
	
	$.ajax( 'cart', {
		type: 'POST',
		dataType: 'text',
		data: {
			//format: 'json',
			//csrfmiddlewaretoken: $(form).find('[name="csrfmiddlewaretoken"]').val( ),
			product: $(form).find('[name="pid"]').val( ),
			//quantity: $(form).find('[name="quantity"]').val( ),
			//variation: $(form).find('[name="variation"]').val( )
		},
		error: function( jqXHR, textStatus, errorThrown ) {
			$(form).submit( );
		},
		success: function( data ) {
			console.log( "success!" );
			console.log( data );
			
			buyButton.val( 'More' );
			buyButton.addClass( 'noRight' );
			$(form).find('input').removeAttr( 'disabled' );
			if ( $('.buyTrolleyButton').length == 0 ) {
				var checkoutButton = $('<input type="button" class="buyTrolleyButton noLeft" value="Checkout">');
				buyButton.after( checkoutButton );
				checkoutButton.click( function() {
					$('#trolleyButton').attr('form').submit( );
				} );
			}
			overlaySpinner.replaceWith( '' );
			
			$('#trolleyButton').val( 'Trolley ('+data['trolleyCount']+' items)' ).show( );
		}
	} );
	
	return false;
}
