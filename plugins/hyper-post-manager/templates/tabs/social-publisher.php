<?php
/**
 * Tab: Social Publisher — Hyper Post Manager
 *
 * Modern social media post composer with live preview,
 * character counting, and platform selection.
 *
 * @package HyperPostManager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Supported publishing platforms.
 *
 * @var array<int, array{id: string, label: string, icon_svg: string}>
 */
$publish_platforms = array(
	array(
		'id'       => 'facebook',
		'label'    => 'Facebook',
		'icon_svg' => '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>',
	),
	array(
		'id'       => 'instagram',
		'label'    => 'Instagram',
		'icon_svg' => '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c.796 0 1.441.645 1.441 1.44s-.645 1.44-1.441 1.44c-.795 0-1.439-.645-1.439-1.44s.644-1.44 1.439-1.44z"/>',
	),
	array(
		'id'       => 'linkedin',
		'label'    => 'LinkedIn',
		'icon_svg' => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.225 0z"/>',
	),
);
?>

<div class="hpm-social-container">

	<!-- ======== Composer Panel ======== -->
	<section class="hpm-social-composer" aria-labelledby="hpm-composer-title">

		<h2 class="hpm-social-title" id="hpm-composer-title">
			<?php esc_html_e( 'Compose Post', 'hyper-post-manager' ); ?>
		</h2>

		<!-- Platform Selector -->
		<span class="hpm-social-label"><?php esc_html_e( 'Platform', 'hyper-post-manager' ); ?></span>
		<div class="hpm-social-platforms" role="group" aria-label="<?php esc_attr_e( 'Select platform', 'hyper-post-manager' ); ?>">
			<?php foreach ( $publish_platforms as $index => $platform ) : ?>
				<button
					class="hpm-social-platform-btn<?php echo 0 === $index ? ' active' : ''; ?>"
					data-platform="<?php echo esc_attr( $platform['label'] ); ?>"
					type="button"
					aria-label="<?php echo esc_attr( $platform['label'] ); ?>"
					aria-pressed="<?php echo 0 === $index ? 'true' : 'false'; ?>"
				>
					<svg viewBox="0 0 24 24" aria-hidden="true"><?php echo $platform['icon_svg']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></svg>
				</button>
			<?php endforeach; ?>
		</div>

		<!-- Content Textarea -->
		<span class="hpm-social-label"><?php esc_html_e( 'Content', 'hyper-post-manager' ); ?></span>
		<div class="hpm-social-content-box">
			<textarea
				class="hpm-social-textarea"
				id="hpm-post-content"
				placeholder="<?php esc_attr_e( "What's on your mind? Use @ to tag products…", 'hyper-post-manager' ); ?>"
				maxlength="280"
				rows="6"
				aria-label="<?php esc_attr_e( 'Post content', 'hyper-post-manager' ); ?>"
			></textarea>
			<div class="hpm-social-content-footer">
				<span class="hpm-social-char-count" aria-live="polite">
					<span id="hpm-char-count">0</span> / 280 <?php esc_html_e( 'characters', 'hyper-post-manager' ); ?>
				</span>
				<button class="hpm-social-ai-btn" type="button" id="hpm-ai-enhance">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M12 3l1.912 5.813a2 2 0 001.275 1.275L21 12l-5.813 1.912a2 2 0 00-1.275 1.275L12 21l-1.912-5.813a2 2 0 00-1.275-1.275L3 12l5.813-1.912a2 2 0 001.275-1.275L12 3z"></path>
					</svg>
					<?php esc_html_e( 'Enhance with AI', 'hyper-post-manager' ); ?>
				</button>
			</div>
		</div>

		<!-- Action Boxes -->
		<div class="hpm-social-actions-grid">
			<button class="hpm-social-action-box" type="button" aria-label="<?php esc_attr_e( 'Add Media', 'hyper-post-manager' ); ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<line x1="12" y1="5" x2="12" y2="19"></line>
					<line x1="5" y1="12" x2="19" y2="12"></line>
				</svg>
				<span><?php esc_html_e( 'Add Media', 'hyper-post-manager' ); ?></span>
			</button>
			<button class="hpm-social-action-box" type="button" aria-label="<?php esc_attr_e( 'Schedule Time', 'hyper-post-manager' ); ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
					<line x1="16" y1="2" x2="16" y2="6"></line>
					<line x1="8" y1="2" x2="8" y2="6"></line>
					<line x1="3" y1="10" x2="21" y2="10"></line>
				</svg>
				<span><?php esc_html_e( 'Schedule Time', 'hyper-post-manager' ); ?></span>
			</button>
		</div>

		<!-- Publish Button -->
		<button class="hpm-social-publish-btn" id="hpm-publish-btn" type="button" disabled>
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
				<path d="M4 12v8a2 2 0 002 2h12a2 2 0 002-2v-8"></path>
				<polyline points="16 6 12 2 8 6"></polyline>
				<line x1="12" y1="2" x2="12" y2="15"></line>
			</svg>
			<?php esc_html_e( 'Publish Now', 'hyper-post-manager' ); ?>
		</button>

	</section>
	<!-- /Composer Panel -->

	<!-- ======== Live Preview Panel ======== -->
	<aside class="hpm-social-preview-pane" aria-label="<?php esc_attr_e( 'Post preview', 'hyper-post-manager' ); ?>">

		<span class="hpm-social-label"><?php esc_html_e( 'Live Preview', 'hyper-post-manager' ); ?></span>

		<div class="hpm-social-preview-card">

			<div class="hpm-social-preview-header">
				<div class="hpm-social-preview-avatar" aria-hidden="true"></div>
				<div class="hpm-social-preview-user">
					<span class="hpm-social-preview-platform-name" id="hpm-preview-platform">Facebook</span>
					<div class="hpm-social-preview-meta">
						<?php esc_html_e( 'Just now', 'hyper-post-manager' ); ?> &bull;
						<svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
							<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
						</svg>
					</div>
				</div>
			</div>

			<div class="hpm-social-preview-body">
				<p class="hpm-social-preview-text hpm-social-preview-text--empty" id="hpm-preview-content">
					<?php esc_html_e( 'Your post preview will appear here as you type…', 'hyper-post-manager' ); ?>
				</p>
			</div>

			<div class="hpm-social-preview-footer">
				<div class="hpm-social-preview-icons" aria-hidden="true">
					<div class="hpm-skeleton-icon"></div>
					<div class="hpm-skeleton-icon"></div>
					<div class="hpm-skeleton-icon"></div>
				</div>
				<div class="hpm-skeleton-btn" aria-hidden="true"></div>
			</div>

		</div>

	</aside>
	<!-- /Live Preview Panel -->

</div>
