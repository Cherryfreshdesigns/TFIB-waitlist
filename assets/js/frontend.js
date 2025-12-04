(function($){
	// Namespace guard
	window.TFIBWaitlist = window.TFIBWaitlist || {};

	function getContextFromVariation( variation ) {
		if ( ! variation ) {
			return null;
		}

		return {
			product_id: variation.variation_id ? variation.variation_id : variation.product_id,
			variation_id: variation.variation_id || 0,
			attributes: variation.attributes || {},
			is_in_stock: !! variation.is_in_stock,
			is_waitlist: !! variation.tfib_is_waitlist // custom flag we will add via PHP later
		};
	}

	function shouldShowWaitlist( ctx ) {
		if ( ! ctx ) {
			return false;
		}

		// For now: show waitlist when variation is not in stock.
		// Later we can differentiate coming-soon vs out-of-stock using custom flags.
		return ! ctx.is_in_stock;
	}

	function toggleAddToCart( $form, enabled ) {
		var $button = $form.find( '.single_add_to_cart_button' );
		if ( ! $button.length ) {
			return;
		}

		if ( enabled ) {
			$button.prop( 'disabled', false ).removeClass( 'disabled' );
		} else {
			$button.prop( 'disabled', true ).addClass( 'disabled' );
		}
	}

	function getSettingsFromContainer( $container ) {
		var raw = $container.data( 'tfib-settings' );
		if ( ! raw ) {
			return {};
		}

		// If it's a JSON string, parse it; if it's already an object, just return it.
		if ( typeof raw === 'string' ) {
			try {
				return JSON.parse( raw );
			} catch ( e ) {
				return {};
			}
		}

		return raw || {};
	}

	function renderInlineForm( $container, ctx ) {
		var settings = getSettingsFromContainer( $container );

		var emailLabel      = settings.email_label || 'Email address *';
		var firstNameLabel  = settings.first_name_label || 'First name (optional)';
		var sizeLabel       = ( settings.size_label || 'Size *' );
		var buttonText      = settings.button_text || 'Join Waitlist';
		var noticeTitle     = settings.notice_title || 'This product is coming soon.';
		var noticeDesc      = settings.notice_description || "Don't worry! Enter your email, and we'll notify you when it's available again.";
		var showNotice      = settings.show_notice !== 'no';
		var noticePosition  = settings.notice_position || 'before';

		// Render notice if enabled
		var noticeHtml = '';
		if ( showNotice ) {
			// Render icon: support Elementor ICONS control payload (object with value/library)
			var iconHtml = '📭';
			if ( settings.notice_icon ) {
				try {
					if ( typeof settings.notice_icon === 'string' ) {
						iconHtml = settings.notice_icon;
					} else if ( settings.notice_icon.value ) {
						// Most icon libraries use a CSS class (e.g., Font Awesome `fas fa-envelope`)
						// Render as an <i> element with that class. If the value looks like an SVG markup, use it directly.
						var val = settings.notice_icon.value;
						if ( val.trim().indexOf('<svg') === 0 ) {
							iconHtml = val;
						} else {
							iconHtml = '<i class="' + val + '" aria-hidden="true"></i>';
						}
					}
				} catch ( e ) {
					// fallback to emoji
					iconHtml = '📭';
				}
			}

			noticeHtml = '' +
				'<div class="tfib-waitlist__notice">' +
				'    <div class="tfib-waitlist__notice-icon">' + iconHtml + '</div>' +
				'    <div class="tfib-waitlist__notice-content">' +
				'        <h3 class="tfib-waitlist__notice-title">' + noticeTitle + '</h3>' +
				'        <p class="tfib-waitlist__notice-description">' + noticeDesc + '</p>' +
				'    </div>' +
				'</div>';
		}

		// Build the trigger button HTML
		var triggerHtml = '<button type="button" class="tfib-waitlist__trigger button">' + buttonText + '</button>';
		
		// Determine the layout based on notice position
		var layoutHtml = '';
		if ( noticePosition === 'after' ) {
			layoutHtml = triggerHtml + noticeHtml;
		} else {
			// Default is 'before'
			layoutHtml = noticeHtml + triggerHtml;
		}

		// Build (or replace) the modal markup.
		// NOTE: Size options are hard-coded for now. You can style/hide specific
		// options via CSS if needed.
		var html = layoutHtml + '' +
			'<div class="tfib-waitlist tfib-waitlist--modal" role="dialog" aria-modal="true" aria-label="Join the TFIB waitlist">' +
			'	<div class="tfib-waitlist__overlay"></div>' +
			'	<div class="tfib-waitlist__dialog">' +
			'		<button type="button" class="tfib-waitlist__close" aria-label="Close">&times;</button>' +
			'		<form class="tfib-waitlist__form" novalidate>' +
			'			<p class="tfib-waitlist__field">' +
			'				<label>' + emailLabel + '</label>' +
			'				<input type="email" name="email" required />' +
			'			</p>' +
			'			<p class="tfib-waitlist__field">' +
			'				<label>' + firstNameLabel + '</label>' +
			'				<input type="text" name="first_name" />' +
			'			</p>' +
			'			<p class="tfib-waitlist__field tfib-waitlist__field--size">' +
			'				<label>' + sizeLabel + '</label>' +
			'				<select name="size" required>' +
			'					<option value="">Select size</option>' +
			'					<option value="S">S</option>' +
			'					<option value="M">M</option>' +
			'					<option value="L">L</option>' +
			'					<option value="XL">XL</option>' +
			'					<option value="XXL">XXL</option>' +
			'					<option value="XXXL">XXXL</option>' +
			'				</select>' +
			'			</p>' +
			'			<div class="tfib-waitlist__message" aria-live="polite"></div>' +
			'			<button type="submit" class="tfib-waitlist__submit button">' + buttonText + '</button>' +
			'		</form>' +
			'	</div>' +
			'</div>';

		$container.find( '.tfib-waitlist' ).remove();
		$container.append( html );

		var $modal = $container.find( '.tfib-waitlist--modal' );
		var $form  = $modal.find( '.tfib-waitlist__form' );

		// Open modal when trigger is clicked.
		$container.off( 'click.tfib_waitlist', '.tfib-waitlist__trigger' );
		$container.on( 'click.tfib_waitlist', '.tfib-waitlist__trigger', function() {
			$modal.addClass( 'is-open' );
		});

		// Close handlers.
		$modal.on( 'click', '.tfib-waitlist__close, .tfib-waitlist__overlay', function() {
			$modal.removeClass( 'is-open' );
		});

		attachFormHandler( $form, ctx, settings );
	}

	function clearInlineForm( $container ) {
		$container.empty();
	}

	function attachFormHandler( $form, ctx, settings ) {
		$form.on( 'submit', function( e ) {
			e.preventDefault();

			var $message = $form.find( '.tfib-waitlist__message' );
			$message.removeClass( 'tfib-waitlist__message--error tfib-waitlist__message--success' ).text( '' );

			// Build attributes object. Start from context attributes (if any)
			// and then ensure the selected size is present.
			var attributes = ctx && ctx.attributes ? $.extend( {}, ctx.attributes ) : {};
			var sizeValue  = $form.find( '[name="size"]' ).val();
			if ( sizeValue ) {
				// Map to a Woo-style attribute key. Adjust this key if your
				// store uses a different attribute slug for size.
				attributes['attribute_pa_size'] = sizeValue;
			}

			var payload = {
				action: 'tfib_waitlist_submit',
				nonce: TFIBWaitlist.nonce,
				email: $form.find( 'input[name="email"]' ).val(),
				first_name: $form.find( 'input[name="first_name"]' ).val(),
				product_id: ctx ? ctx.product_id : $( 'form.variations_form' ).data( 'product_id' ),
				variation_id: ctx ? ctx.variation_id : 0,
				attributes: attributes
			};

			$.post( TFIBWaitlist.ajaxUrl, payload )
				.done( function( response ) {
					if ( response && response.success ) {
						var successMsg = ( response && response.data && response.data.message ) ? response.data.message : ( settings && settings.success_message ? settings.success_message : 'You have been added to the waitlist.' );
						$message.addClass( 'tfib-waitlist__message--success' ).text( successMsg );
						
						// Hide the modal and trigger button, show success message.
						var $modal = $form.closest( '.tfib-waitlist--modal' );
						var $container = $modal.closest( '.tfib-waitlist-container' );
						var $trigger = $container.find( '.tfib-waitlist__trigger' );
						
						$form.hide();
						$modal.removeClass( 'is-open' );
						$trigger.hide();
						
						// Show success message in the container.
						var $successDiv = $( '<div class="tfib-waitlist__success-message"><p></p></div>' );
						$successDiv.find( 'p' ).text( successMsg );
						$container.append( $successDiv );
					} else {
						var errMsg = ( response && response.data && response.data.message ) ? response.data.message : ( settings && settings.error_message ? settings.error_message : 'Something went wrong. Please try again.' );
						$message.addClass( 'tfib-waitlist__message--error' ).text( errMsg );
					}
				})
				.fail( function() {
					var errMsg = settings && settings.error_message ? settings.error_message : 'Something went wrong. Please try again.';
					$message.addClass( 'tfib-waitlist__message--error' ).text( errMsg );
				});
		});
	}
	function bindVariationHandlers() {
		// Use delegated binding so this survives Elementor/Woo re-renders.
		$( document )
			.off( 'found_variation.tfib_waitlist reset_data.tfib_waitlist' )
			.on( 'found_variation.tfib_waitlist', function( event, variation ) {
				// Try to locate the nearest relevant form from the event target.
				var $target = $( event.target );
				var $form   = $target.closest( 'form' );

				// Fallbacks: look for common Woo/Elementor forms if closest() failed.
				if ( ! $form.length ) {
					$form = $( 'form.variations_form' ).first();
				}
				if ( ! $form.length ) {
					$form = $( 'form.cart' ).first();
				}
				if ( ! $form.length ) {
					// Last resort: any form inside the main product / Elementor add-to-cart widget.
					$form = $( '.product, .elementor-widget-woocommerce-product-add-to-cart' ).find( 'form' ).first();
				}

				if ( ! $form.length ) {
					return;
				}

				var $container = $( '.tfib-waitlist-container' );
				if ( ! $container.length ) {
					return;
				}

				var ctx = getContextFromVariation( variation );
				if ( shouldShowWaitlist( ctx ) ) {
					// Disable Add to Cart, show waitlist.
					toggleAddToCart( $form, false );
					renderInlineForm( $container, ctx );
				} else {
					// Enable Add to Cart, hide waitlist.
					toggleAddToCart( $form, true );
					clearInlineForm( $container );
				}
			})
			.on( 'reset_data.tfib_waitlist', function( event ) {
				var $target = $( event.target );
				var $form   = $target.closest( 'form' );

				if ( ! $form.length ) {
					$form = $( 'form.variations_form' ).first();
				}
				if ( ! $form.length ) {
					$form = $( 'form.cart' ).first();
				}
				if ( ! $form.length ) {
					$form = $( '.product, .elementor-widget-woocommerce-product-add-to-cart' ).find( 'form' ).first();
				}

				if ( ! $form.length ) {
					return;
				}

				var $container = $( '.tfib-waitlist-container' );
				if ( ! $container.length ) {
					return;
				}

				clearInlineForm( $container );
				// Keep Add to Cart disabled until a valid variation is chosen again.
				toggleAddToCart( $form, false );
			});
	}

	$(function(){
		bindVariationHandlers();

		// Auto-render waitlist popup on load when there is a container
		// but no variation form (e.g. all variations are out of stock and
		// Add to Cart widget is hidden via visibility rules).
		var $container = $( '.tfib-waitlist-container' );
		if ( $container.length && ! $( 'form.variations_form' ).length && ! $( 'form.cart' ).length ) {
			// Build a minimal context using the product id from the container.
			var productId = $container.data( 'product-id' ) || $container.data( 'product_id' );
			var ctx = {
				product_id: productId,
				variation_id: 0,
				attributes: {},
				is_in_stock: false,
				is_waitlist: true
			};

			renderInlineForm( $container, ctx );
		}
	});
})(jQuery);
