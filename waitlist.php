<?php
/**
 * Plugin Name:       TFIB Waitlist
 * Plugin URI:        https://thefocusisbetterment.com/
 * Description:       Enterprise-grade waitlist system for TFIB WooCommerce store (inline, popup, and page modes) with countdown and Mailchimp integration.
 * Version:           0.1.0
 * Author:            TFIB
 * Author URI:        https://thefocusisbetterment.com/
 * Text Domain:       waitlist
 * Domain Path:       /languages
 * Requires at least: 6.4
 * Requires PHP:      7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Simple PSR-4 style autoloader for the TFIB\Waitlist namespace.
spl_autoload_register( function ( $class ) {
	if ( 0 !== strpos( $class, 'TFIB\\Waitlist\\' ) ) {
		return;
	}

	$relative = str_replace( 'TFIB\\Waitlist\\', '', $class );
	$relative = str_replace( '\\', DIRECTORY_SEPARATOR, $relative );
	$file     = __DIR__ . '/includes/' . $relative . '.php';

	if ( file_exists( $file ) ) {
		require_once $file;
	}
} );

// Bootstrap the plugin.
add_action( 'plugins_loaded', function() {
	// Ensure WooCommerce is active.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	TFIB\Waitlist\Plugin::instance();
} );
