<?php

namespace TFIB\Waitlist\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Assets {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	public function enqueue() : void {
		if ( ! $this->should_load_assets() ) {
			return;
		}

		wp_register_style(
			'tfib-waitlist-frontend',
			TFIB_WAITLIST_PLUGIN_URL . 'assets/css/frontend.css',
			[],
			TFIB_WAITLIST_VERSION
		);

		wp_register_script(
			'tfib-waitlist-frontend',
			TFIB_WAITLIST_PLUGIN_URL . 'assets/js/frontend.js',
			[ 'jquery' ],
			TFIB_WAITLIST_VERSION,
			true
		);

		wp_enqueue_style( 'tfib-waitlist-frontend' );
		wp_enqueue_script( 'tfib-waitlist-frontend' );

		wp_localize_script( 'tfib-waitlist-frontend', 'TFIBWaitlist', [
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'tfib_waitlist_submit' ),
		] );
	}

	protected function should_load_assets() : bool {
		if ( is_product() ) {
			return true; // refine later when settings exist
		}

		// Dedicated waitlist page or shortcode detection will go here.
		return false;
	}
}
