<?php
/**
 * Tab: Connected Accounts — Hyper Post Manager
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Social platform definitions.
 */
$platforms = [
	[
		'id'          => 'facebook',
		'name'        => 'Facebook',
		'handle'      => '@Main Brand Page',
		'status'      => 'Active',
		'status_type' => 'success',
		'icon_bg'     => '#4267B2',
		'icon_svg'    => '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>',
	],
	[
		'id'          => 'instagram',
		'name'        => 'Instagram',
		'handle'      => '@brand_insta',
		'status'      => 'Active',
		'status_type' => 'success',
		'icon_bg'     => '#E1306C',
		'icon_svg'    => '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c.796 0 1.441.645 1.441 1.44s-.645 1.44-1.441 1.44c-.795 0-1.439-.645-1.439-1.44s.644-1.44 1.439-1.44z"/>',
	],
	[
		'id'          => 'twitter',
		'name'        => 'X / Twitter',
		'handle'      => 'Not connected',
		'status'      => 'Disconnected',
		'status_type' => 'danger',
		'icon_bg'     => '#f1f5f9',
		'icon_svg'    => '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.045 4.126H5.078z"/>',
	],
	[
		'id'          => 'linkedin',
		'name'        => 'LinkedIn',
		'handle'      => '@Brand Corp',
		'status'      => 'Expired',
		'status_type' => 'warning',
		'icon_bg'     => '#0077B5',
		'icon_svg'    => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.225 0z"/>',
	],
];
?>

<div class="hpm-container">

	<!-- Section Header -->
	<header class="hpm-section-header">
		<div class="hpm-section-header-text">
			<h1><?php esc_html_e( 'Connected Accounts', 'hyper-post-manager' ); ?></h1>
			<p><?php esc_html_e( 'Manage your social platform OAuth authorizations.', 'hyper-post-manager' ); ?></p>
		</div>
		<button class="hpm-btn-add" type="button">
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
				<line x1="12" y1="5" x2="12" y2="19"></line>
				<line x1="5" y1="12" x2="19" y2="12"></line>
			</svg>
			<?php esc_html_e( 'Add Organization', 'hyper-post-manager' ); ?>
		</button>
	</header>

	<!-- Platform Cards Grid -->
	<div class="hpm-accounts-grid">
		<?php foreach ( $platforms as $platform ) :
			$is_connected = ( 'Disconnected' !== $platform['status'] );
		?>
			<div class="hpm-platform-card" data-platform="<?php echo esc_attr( $platform['id'] ); ?>">

				<!-- Card Top -->
				<div class="hpm-platform-card-top">
					<div class="hpm-platform-info">
						<div
							class="hpm-platform-icon<?php echo ( 'twitter' === $platform['id'] ) ? ' hpm-platform-icon--gray' : ''; ?>"
							style="background-color:<?php echo esc_attr( $platform['icon_bg'] ); ?>;"
						>
							<svg viewBox="0 0 24 24" aria-label="<?php echo esc_attr( $platform['name'] ); ?>" role="img">
								<?php echo $platform['icon_svg']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</svg>
						</div>
						<div class="hpm-platform-meta">
							<h3><?php echo esc_html( $platform['name'] ); ?></h3>
							<span><?php esc_html_e( 'OAuth 2.0 Integration', 'hyper-post-manager' ); ?></span>
						</div>
					</div>
					<span class="hpm-status-badge hpm-status-badge--<?php echo esc_attr( $platform['status_type'] ); ?>">
						<?php echo esc_html( $platform['status'] ); ?>
					</span>
				</div>

				<!-- Card Bottom -->
				<div class="hpm-platform-card-bottom">
					<span class="hpm-platform-handle<?php echo ! $is_connected ? ' hpm-platform-handle--empty' : ''; ?>">
						<?php echo esc_html( $platform['handle'] ); ?>
					</span>

					<?php if ( $is_connected ) : ?>
						<button class="hpm-btn hpm-btn--outline js-disconnect" type="button">
							<?php esc_html_e( 'Disconnect', 'hyper-post-manager' ); ?>
						</button>
					<?php else : ?>
						<button class="hpm-btn hpm-btn--solid js-connect" type="button">
							<?php esc_html_e( 'Connect Account', 'hyper-post-manager' ); ?>
						</button>
					<?php endif; ?>
				</div>

			</div>
		<?php endforeach; ?>
	</div>
	<!-- /Platform Cards Grid -->
</div>