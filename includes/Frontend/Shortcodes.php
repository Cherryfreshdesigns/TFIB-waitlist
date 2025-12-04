<?php

namespace TFIB\Waitlist\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Shortcodes {
	public function __construct() {
		add_shortcode( 'tfib_waitlist', [ $this, 'render_waitlist' ] );
		add_shortcode( 'tfib_waitlist_page', [ $this, 'render_waitlist_page' ] );
	}

	public function render_waitlist( $atts = [], $content = '' ) : string {
		if ( ! is_product() ) {
			return '';
		}

		global $product;
		if ( ! $product instanceof \WC_Product ) {
			return '';
		}

		// For now we only render the inline waitlist container for variable products.
		if ( ! $product->is_type( 'variable' ) ) {
			return '';
		}

		$atts = shortcode_atts(
			[
				'class' => '',
			],
			$atts,
			'tfib_waitlist'
		);

		$classes   = [ 'tfib-waitlist-container' ];
		$extra_cla = trim( (string) $atts['class'] );
		if ( $extra_cla !== '' ) {
			$classes[] = $extra_cla;
		}

		$wrapper_class = implode( ' ', array_map( 'sanitize_html_class', $classes ) );
		$product_id    = $product->get_id();

		ob_start();
		?>
		<div class="<?php echo esc_attr( $wrapper_class ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>"></div>
		<?php
		return ob_get_clean();
	}

	public function render_waitlist_page( $atts = [], $content = '' ) : string {
		ob_start();
		echo '<!-- tfib_waitlist_page shortcode placeholder -->';
		return ob_get_clean();
	}
}
