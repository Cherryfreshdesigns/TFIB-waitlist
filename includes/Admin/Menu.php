<?php

namespace TFIB\Waitlist\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Menu {
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_menu' ], 60 );
	}

	public function register_menu() : void {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		add_submenu_page(
			'woocommerce',
			__( 'TFIB Waitlist', 'waitlist' ),
			__( 'TFIB Waitlist', 'waitlist' ),
			'manage_woocommerce',
			'tfib-waitlist',
			[ $this, 'render_page' ]
		);
	}

	public function render_page() : void {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_die( esc_html__( 'You do not have permission to access this page.', 'waitlist' ) );
		}

		echo '<div class="wrap"><h1>' . esc_html__( 'TFIB Waitlist', 'waitlist' ) . '</h1>';
		echo '<p>' . esc_html__( 'Settings and entries management UI will appear here.', 'waitlist' ) . '</p>';
		echo '</div>';
	}
}
