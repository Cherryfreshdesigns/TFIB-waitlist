<?php

namespace TFIB\Waitlist\Frontend;

use TFIB\Waitlist\Waitlist_CPT;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Woocommerce_Integration {
	public function __construct() {
		// Inject container for inline waitlist UI after add to cart form.
		add_action( 'woocommerce_single_product_summary', [ $this, 'render_waitlist_container' ], 35 );
	}

	public function render_waitlist_container() : void {
		if ( ! is_product() ) {
			return;
		}

		global $product;
		if ( ! $product instanceof \WC_Product ) {
			return;
		}

		// For now we only act on variable products.
		if ( ! $product->is_type( 'variable' ) ) {
			return;
		}

		// Container that JS will hydrate with inline or modal UI depending on mode and variation.
		echo '<div class="tfib-waitlist-container" data-product-id="' . esc_attr( $product->get_id() ) . '"></div>';
	}
}
