<?php
/**
 * Dashboard Template — Hyper Post Manager
 *
 * Full-page, theme-independent template that renders the HPM SaaS dashboard.
 * Replaces the standard WordPress theme template for the configured page.
 *
 * @package HyperPostManager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_user = wp_get_current_user();

/**
 * Dashboard tab definitions.
 * Keys must match the slugs registered in HPM_Dashboard::$tabs.
 *
 * @var array<string, array{label: string, icon: string}>
 */
$dashboard_tabs = array(
	'dashboard'        => array( 'label' => __( 'Dashboard', 'hyper-post-manager' ),        'icon' => 'layout-dashboard' ),
	'account'          => array( 'label' => __( 'Account', 'hyper-post-manager' ),           'icon' => 'user-circle' ),
	'social-publisher' => array( 'label' => __( 'Social Publisher', 'hyper-post-manager' ),  'icon' => 'megaphone' ),
);

$user_avatar_letter = ! empty( $current_user->display_name )
	? mb_strtoupper( mb_substr( $current_user->display_name, 0, 1 ) )
	: 'U';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex, nofollow">
	<title><?php echo esc_html( get_bloginfo( 'name' ) . ' — ' . __( 'Dashboard', 'hyper-post-manager' ) ); ?></title>
	<?php wp_head(); ?>
	<style>
		/* Suppress WP Admin Bar on this full-page template */
		html { margin-top: 0 !important; }
		body { margin: 0; padding: 0; overflow: hidden; }
		#wpadminbar { display: none !important; }
	</style>
</head>
<body class="hpm-dashboard-active">

	<div class="hpm-wrapper">

		<!-- ===================== Sidebar ===================== -->
		<aside class="hpm-sidebar" id="hpm-sidebar" role="navigation" aria-label="<?php esc_attr_e( 'Dashboard navigation', 'hyper-post-manager' ); ?>">

			<!-- Logo / Brand -->
			<div class="hpm-logo">
				<div class="hpm-logo-icon" aria-hidden="true">
					<i data-lucide="zap"></i>
				</div>
				<span class="hpm-brand">
					<?php esc_html_e( 'Hyper', 'hyper-post-manager' ); ?><span><?php esc_html_e( 'Post', 'hyper-post-manager' ); ?></span>
				</span>
			</div>

			<!-- Primary Navigation -->
			<nav class="hpm-nav" role="menubar">
				<?php foreach ( $dashboard_tabs as $slug => $tab_data ) : ?>
					<a
						href="#"
						class="hpm-nav-item<?php echo 'dashboard' === $slug ? ' active' : ''; ?>"
						data-tab="<?php echo esc_attr( $slug ); ?>"
						role="menuitem"
						aria-current="<?php echo 'dashboard' === $slug ? 'page' : 'false'; ?>"
					>
						<i data-lucide="<?php echo esc_attr( $tab_data['icon'] ); ?>" aria-hidden="true"></i>
						<?php echo esc_html( $tab_data['label'] ); ?>
					</a>
				<?php endforeach; ?>
			</nav>

			<!-- Logout Link -->
			<a
				href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"
				class="hpm-nav-item hpm-nav-logout"
				role="menuitem"
			>
				<i data-lucide="log-out" aria-hidden="true"></i>
				<?php esc_html_e( 'Logout', 'hyper-post-manager' ); ?>
			</a>

		</aside>
		<!-- /Sidebar -->

		<!-- ===================== Main Area ===================== -->
		<main class="hpm-main" id="hpm-main" role="main">

			<!-- Top Header Bar -->
			<header class="hpm-topbar">
				<h2 class="hpm-topbar-title" id="hpm-tab-title">
					<?php esc_html_e( 'Dashboard', 'hyper-post-manager' ); ?>
				</h2>

				<div class="hpm-user-panel">
					<div class="hpm-user-info">
						<span class="hpm-user-name"><?php echo esc_html( $current_user->display_name ); ?></span>
						<span class="hpm-user-role"><?php esc_html_e( 'Administrator', 'hyper-post-manager' ); ?></span>
					</div>
					<div class="hpm-avatar" aria-hidden="true"><?php echo esc_html( $user_avatar_letter ); ?></div>
				</div>
			</header>

			<!-- Tab Content Area -->
			<div class="hpm-content" id="hpm-main-content">
				<div class="hpm-loader" id="hpm-loader" role="status" aria-live="polite">
					<div class="hpm-spinner" aria-label="<?php esc_attr_e( 'Loading…', 'hyper-post-manager' ); ?>"></div>
				</div>
			</div>

		</main>
		<!-- /Main Area -->

	</div><!-- .hpm-wrapper -->

	<?php wp_footer(); ?>

</body>
</html>
