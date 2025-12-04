<?php
/**
 * Dedicated waitlist page template (Mode C).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="tfib-waitlist tfib-waitlist--page" role="region" aria-label="<?php echo esc_attr__( 'TFIB Waitlist', 'waitlist' ); ?>">
	<!-- Countdown will appear here when implemented -->
	<h1 class="tfib-waitlist__page-title"><?php esc_html_e( 'Join the TFIB Waitlist', 'waitlist' ); ?></h1>
	<p class="tfib-waitlist__page-description"><?php esc_html_e( 'Sign up to be notified when this product becomes available.', 'waitlist' ); ?></p>
	<form class="tfib-waitlist__form" method="post" novalidate>
		<p class="tfib-waitlist__field">
			<label for="tfib-waitlist-email-page"><?php esc_html_e( 'Email address', 'waitlist' ); ?> *</label>
			<input type="email" id="tfib-waitlist-email-page" name="email" required />
		</p>
		<p class="tfib-waitlist__field">
			<label for="tfib-waitlist-first-name-page"><?php esc_html_e( 'First name (optional)', 'waitlist' ); ?></label>
			<input type="text" id="tfib-waitlist-first-name-page" name="first_name" />
		</p>
		<button type="submit" class="tfib-waitlist__submit button"><?php esc_html_e( 'Join Waitlist', 'waitlist' ); ?></button>
		<div class="tfib-waitlist__message" aria-live="polite"></div>
	</form>
</div>
