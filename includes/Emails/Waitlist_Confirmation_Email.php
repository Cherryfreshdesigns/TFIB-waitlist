<?php

namespace TFIB\Waitlist\Emails;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Waitlist_Confirmation_Email {
	public function __construct() {
		add_action( 'tfib_waitlist_entry_created', [ $this, 'send_confirmation' ], 10, 2 );
	}

	/**
	 * Send a confirmation email to the customer when they join the waitlist.
	 *
	 * @param int   $entry_id Waitlist entry post ID.
	 * @param array $data     Raw data used to create the entry.
	 */
	public function send_confirmation( int $entry_id, array $data ) : void {
		$email       = $data['email'] ?? '';
		$first_name  = $data['first_name'] ?? '';
		$product_id  = isset( $data['product_id'] ) ? (int) $data['product_id'] : 0;
		$variation_id = isset( $data['variation_id'] ) ? (int) $data['variation_id'] : 0;

		if ( ! $email || ! is_email( $email ) ) {
			return;
		}

		// Determine product/variation name.
		$product_name = $variation_id ? get_the_title( $variation_id ) : get_the_title( $product_id );

		// Decode stored attributes (JSON) including size.
		$attributes_raw = get_post_meta( $entry_id, '_attributes', true );
		$attributes     = $attributes_raw ? json_decode( $attributes_raw, true ) : [];

		$size = '';
		if ( isset( $attributes['attribute_pa_size'] ) && $attributes['attribute_pa_size'] !== '' ) {
			$size = $attributes['attribute_pa_size'];
		}

		// Build a simple "Selected options" string from attributes.
		$variation_attributes = '';
		if ( ! empty( $attributes ) ) {
			$parts = [];
			foreach ( $attributes as $key => $value ) {
				if ( $value === '' ) {
					continue;
				}

				// Strip leading "attribute_" for label resolution when applicable.
				$attr_key = str_replace( 'attribute_', '', $key );
				$label    = function_exists( 'wc_attribute_label' ) ? wc_attribute_label( $attr_key ) : $attr_key;
				$parts[]  = sprintf( '%s: %s', $label, $value );
			}

			$variation_attributes = implode( ', ', $parts );
		}

		$site_name   = get_bloginfo( 'name' );
		$launch_date = ''; // Optional: populate from settings/meta if available.

		ob_start();
		wc_get_template(
			'emails/waitlist-confirmation.php',
			[
				'first_name'           => $first_name,
				'product_name'         => $product_name,
				'variation_attributes' => $variation_attributes,
				'launch_date'          => $launch_date,
				'site_name'            => $site_name,
				'size'                 => $size,
			],
			'waitlist/',
			plugin_dir_path( __DIR__ ) . 'templates/emails/'
		);
		$message = ob_get_clean();

		$subject = sprintf(
			/* translators: %s is product name. */
			__( 'You are on the waitlist for %s', 'waitlist' ),
			$product_name
		);

		wp_mail( $email, $subject, $message, [ 'Content-Type: text/html; charset=UTF-8' ] );
	}
}
