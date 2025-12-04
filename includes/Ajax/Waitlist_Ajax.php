<?php

namespace TFIB\Waitlist\Ajax;

use TFIB\Waitlist\Waitlist_Repository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Waitlist_Ajax {
	/** @var Waitlist_Repository */
	protected $repository;

	public function __construct() {
		$this->repository = new Waitlist_Repository();
		add_action( 'wp_ajax_tfib_waitlist_submit', [ $this, 'handle_submit' ] );
		add_action( 'wp_ajax_nopriv_tfib_waitlist_submit', [ $this, 'handle_submit' ] );
	}

	public function handle_submit() : void {
		check_ajax_referer( 'tfib_waitlist_submit', 'nonce' );

		$email       = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$first_name  = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
		$product_id  = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
		$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
		$attributes  = isset( $_POST['attributes'] ) && is_array( $_POST['attributes'] )
			? array_map( 'sanitize_text_field', wp_unslash( $_POST['attributes'] ) )
			: [];

		// Extract size explicitly for convenience (it will still be included in $attributes and stored).
		$size = isset( $attributes['attribute_pa_size'] ) ? $attributes['attribute_pa_size'] : '';

		if ( ! $email || ! is_email( $email ) ) {
			wp_send_json_error( [
				'message' => __( 'Please enter a valid email address.', 'waitlist' ),
			], 400 );
		}

		if ( ! $product_id ) {
			wp_send_json_error( [
				'message' => __( 'Product is required for waitlist.', 'waitlist' ),
			], 400 );
		}

		$result = $this->repository->create( [
			'email'        => $email,
			'first_name'   => $first_name,
			'product_id'   => $product_id,
			'variation_id' => $variation_id,
			'attributes'   => $attributes,
		] );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( [
				'message' => $result->get_error_message(),
			], 500 );
		}

		// Optionally, you might trigger an email here or via the tfib_waitlist_entry_created action.

		wp_send_json_success( [
			'message' => __( 'You have been added to the waitlist.', 'waitlist' ),
			'entryId' => $result,
		] );
	}
}
