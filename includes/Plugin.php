<?php

namespace TFIB\Waitlist;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin {
	/** @var Plugin */
	protected static $instance;

	public static function instance() : Plugin {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct() {
		$this->define_constants();
		$this->init_hooks();
	}

	protected function define_constants() : void {
		define( 'TFIB_WAITLIST_VERSION', '0.1.0' );
		define( 'TFIB_WAITLIST_PLUGIN_FILE', dirname( __DIR__ ) . '/waitlist.php' );
		define( 'TFIB_WAITLIST_PLUGIN_DIR', plugin_dir_path( TFIB_WAITLIST_PLUGIN_FILE ) );
		define( 'TFIB_WAITLIST_PLUGIN_URL', plugin_dir_url( TFIB_WAITLIST_PLUGIN_FILE ) );
	}

	protected function init_hooks() : void {
		// Core components.
		new Admin\Menu();
		new Admin\Settings();
		new Admin\Entries_List();

		new Frontend\Assets();
		new Frontend\Woocommerce_Integration();
		new Frontend\Shortcodes();
		new Frontend\Countdown();

		new Ajax\Waitlist_Ajax();
		new Mailchimp\Integration();

		new Waitlist_CPT();

		// Data layer.
		new Waitlist_Repository();

		// Emails.
		new Emails\Waitlist_Confirmation_Email();

		// Make helper functions available early.
		add_action( 'init', [ $this, 'register_helpers' ] );

		// Elementor integration.
		if ( did_action( 'elementor/loaded' ) ) {
			add_action( 'elementor/widgets/register', [ $this, 'register_elementor_widgets' ] );
		} else {
			add_action( 'elementor/loaded', function () {
				add_action( 'elementor/widgets/register', [ $this, 'register_elementor_widgets' ] );
			} );
		}
	}

	/**
	 * Register global helper functions/shortcodes.
	 */
	public function register_helpers() : void {
		// Shortcode: [tfib_all_variations_oos]
		add_shortcode( 'tfib_all_variations_oos', function () {
			return Helpers\Stock_Status::all_variations_out_of_stock() ? '1' : '0';
		} );
	}

	/**
	 * Register custom Elementor widgets.
	 */
	public function register_elementor_widgets( \Elementor\Widgets_Manager $widgets_manager ) : void {
		// Ensure WooCommerce is active and we're on front-end or editor context where products make sense.
		if ( ! class_exists( '\\WooCommerce' ) ) {
			return;
		}

		$widgets_manager->register( new Elementor\WaitlistWidget() );
	}
}
