<?php

namespace TFIB\Waitlist\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings {
	public function __construct() {
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	public function register_settings() : void {
		// Placeholder for full settings implementation.
		register_setting( 'tfib_waitlist_general', 'tfib_waitlist_options', [
			'sanitize_callback' => [ $this, 'sanitize_options' ],
		] );
	}

	public function sanitize_options( $options ) {
		$options = is_array( $options ) ? $options : [];
		// Minimal sanitization placeholder.
		if ( isset( $options['enabled'] ) ) {
			$options['enabled'] = (bool) $options['enabled'];
		}
		return $options;
	}
}
