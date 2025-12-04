<?php
/**
 * Modal waitlist form template (Mode B).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="tfib-waitlist tfib-waitlist--modal" hidden>
	<button type="button" class="tfib-waitlist__close" aria-label="<?php echo esc_attr__( 'Close waitlist form', 'waitlist' ); ?>">&times;</button>
	<h2 class="tfib-waitlist__title"><?php esc_html_e( 'Join the TFIB Waitlist', 'waitlist' ); ?></h2>
	<p class="tfib-waitlist__description"><?php esc_html_e( 'We\'ll email you when this item is available.', 'waitlist' ); ?></p>
	<form class="tfib-waitlist__form" method="post" novalidate>
		<p class="tfib-waitlist__field">
			<label for="tfib-waitlist-email-modal"><?php esc_html_e( 'Email address', 'waitlist' ); ?> *</label>
			<input type="email" id="tfib-waitlist-email-modal" name="email" required />
		</p>
		<p class="tfib-waitlist__field">
			<label for="tfib-waitlist-first-name-modal"><?php esc_html_e( 'First name (optional)', 'waitlist' ); ?></label>
			<input type="text" id="tfib-waitlist-first-name-modal" name="first_name" />
		</p>
		<button type="submit" class="tfib-waitlist__submit button"><?php esc_html_e( 'Join Waitlist', 'waitlist' ); ?></button>
		<div class="tfib-waitlist__message" aria-live="polite"></div>
	</form>
</div>
