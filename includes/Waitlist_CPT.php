<?php

namespace TFIB\Waitlist;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Waitlist_CPT {
	public function __construct() {
		add_action( 'init', [ $this, 'register_cpt' ] );
	}

	public function register_cpt() : void {
		$labels = [
			'name'               => __( 'Waitlist Entries', 'waitlist' ),
			'singular_name'      => __( 'Waitlist Entry', 'waitlist' ),
			'menu_name'          => __( 'Waitlist Entries', 'waitlist' ),
		];

		$args = [
			'labels'             => $labels,
			'public'             => false,
			'show_ui'            => false,
			'show_in_menu'       => false,
			'supports'           => [ 'title' ],
			'capability_type'    => 'shop_order',
			'map_meta_cap'       => true,
			'show_in_rest'       => false,
		];

		register_post_type( 'tfib_waitlist_entry', $args );
	}
}
