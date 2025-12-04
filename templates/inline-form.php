<?php
/**
 * Inline waitlist form template (Mode A).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="tfib-waitlist tfib-waitlist--inline" role="region" aria-label="<?php echo esc_attr__( 'Join the TFIB waitlist', 'waitlist' ); ?>">
	<!-- Countdown will render above form when implemented -->
	<form class="tfib-waitlist__form" method="post" novalidate>
		<p class="tfib-waitlist__field">
			<label for="tfib-waitlist-email"><?php esc_html_e( 'Email address', 'waitlist' ); ?> *</label>
			<input type="email" id="tfib-waitlist-email" name="email" required />
		</p>
		<p class="tfib-waitlist__field">
			<label for="tfib-waitlist-first-name"><?php esc_html_e( 'First name (optional)', 'waitlist' ); ?></label>
			<input type="text" id="tfib-waitlist-first-name" name="first_name" />
		</p>
		<button type="submit" class="tfib-waitlist__submit button"><?php esc_html_e( 'Join Waitlist', 'waitlist' ); ?></button>
		<div class="tfib-waitlist__message" aria-live="polite"></div>
	</form>
</div>
