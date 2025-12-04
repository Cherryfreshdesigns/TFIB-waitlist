<?php

namespace TFIB\Waitlist\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Stock_Status {
	/**
	 * Check if the current product is a variable product where all variations are out of stock.
	 *
	 * @return bool
	 */
	public static function all_variations_out_of_stock() : bool {
		if ( ! is_product() ) {
			return false;
		}

		global $product;

		if ( ! $product instanceof \WC_Product_Variable ) {
			return false;
		}

		$available = $product->get_available_variations();
		if ( empty( $available ) ) {
			return false;
		}

		foreach ( $available as $variation_data ) {
			if ( ! empty( $variation_data['is_in_stock'] ) ) {
				// At least one variation is in stock.
				return false;
			}
		}

		// All variations are not in stock.
		return true;
	}
}
