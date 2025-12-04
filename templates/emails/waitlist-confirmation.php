<?php
/**
 * Waitlist confirmation email template.
 *
 * Available variables:
 * - $first_name
 * - $product_name
 * - $variation_attributes
 * - $launch_date
 * - $site_name
 * - $size
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?><p><?php printf( esc_html__( 'Hi %s,', 'waitlist' ), esc_html( $first_name ?: __( 'there', 'waitlist' ) ) ); ?></p>

<p><?php printf( esc_html__( 'You\'re on the waitlist for %s.', 'waitlist' ), esc_html( $product_name ) ); ?></p>

<?php if ( ! empty( $size ) ) : ?>
	<p><?php printf( esc_html__( 'Selected size: %s', 'waitlist' ), esc_html( $size ) ); ?></p>
<?php endif; ?>

<?php if ( ! empty( $variation_attributes ) ) : ?>
	<p><?php esc_html_e( 'Selected options:', 'waitlist' ); ?> <?php echo esc_html( $variation_attributes ); ?></p>
<?php endif; ?>

<?php if ( ! empty( $launch_date ) ) : ?>
	<p><?php printf( esc_html__( 'Estimated launch: %s', 'waitlist' ), esc_html( $launch_date ) ); ?></p>
<?php endif; ?>

<p><?php printf( esc_html__( 'Thank you from %s.', 'waitlist' ), esc_html( $site_name ) ); ?></p>
