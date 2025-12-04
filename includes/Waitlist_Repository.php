<?php

namespace TFIB\Waitlist;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Data layer for waitlist entries stored as tfib_waitlist_entry posts.
 */
class Waitlist_Repository {
	public const POST_TYPE = 'tfib_waitlist_entry';

	/**
	 * Create a waitlist entry.
	 *
	 * @param array $data {
	 *   @type string $email
	 *   @type string $first_name
	 *   @type int    $product_id
	 *   @type int    $variation_id
	 *   @type array  $attributes
	 * }
	 *
	 * @return int|\WP_Error Post ID on success.
	 */
	public function create( array $data ) {
		$email       = isset( $data['email'] ) ? sanitize_email( $data['email'] ) : '';
		$first_name  = isset( $data['first_name'] ) ? sanitize_text_field( $data['first_name'] ) : '';
		$product_id  = isset( $data['product_id'] ) ? absint( $data['product_id'] ) : 0;
		$variation_id = isset( $data['variation_id'] ) ? absint( $data['variation_id'] ) : 0;
		$attributes  = isset( $data['attributes'] ) && is_array( $data['attributes'] ) ? $data['attributes'] : [];

		if ( ! $email || ! $product_id ) {
			return new \WP_Error( 'invalid_data', __( 'Missing required waitlist fields.', 'waitlist' ) );
		}

		// Avoid duplicate entries for same email + product + variation + attributes.
		$existing = $this->find_existing( $email, $product_id, $variation_id, $attributes );
		if ( $existing ) {
			return $existing;
		}

		$title = sprintf( '%s – %s', $email, get_the_title( $variation_id ?: $product_id ) );

		$post_id = wp_insert_post( [
			'post_type'   => self::POST_TYPE,
			'post_status' => 'publish',
			'post_title'  => $title,
		], true );

		if ( is_wp_error( $post_id ) ) {
			return $post_id;
		}

		update_post_meta( $post_id, '_email', $email );
		update_post_meta( $post_id, '_first_name', $first_name );
		update_post_meta( $post_id, '_product_id', $product_id );
		update_post_meta( $post_id, '_variation_id', $variation_id );
		update_post_meta( $post_id, '_attributes', wp_json_encode( $attributes ) );

		/**
		 * Fires after a waitlist entry is created.
		 *
		 * @param int   $post_id
		 * @param array $data
		 */
		do_action( 'tfib_waitlist_entry_created', $post_id, $data );

		return $post_id;
	}

	/**
	 * Find an existing entry ID for the same logical subscription.
	 */
	public function find_existing( string $email, int $product_id, int $variation_id = 0, array $attributes = [] ) : int {
		$meta_query = [
			'relation' => 'AND',
			[
				'key'   => '_email',
				'value' => $email,
			],
			[
				'key'   => '_product_id',
				'value' => $product_id,
			],
		];

		$meta_query[] = [
			'key'   => '_variation_id',
			'value' => $variation_id,
		];

		$attr_value = $attributes ? wp_json_encode( $attributes ) : '';
		$meta_query[] = [
			'key'   => '_attributes',
			'value' => $attr_value,
		];

		$query = new \WP_Query( [
			'post_type'      => self::POST_TYPE,
			'fields'         => 'ids',
			'posts_per_page' => 1,
			'meta_query'     => $meta_query,
		] );

		return $query->posts ? (int) $query->posts[0] : 0;
	}
}
