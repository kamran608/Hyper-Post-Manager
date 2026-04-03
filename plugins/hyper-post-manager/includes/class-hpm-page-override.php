<?php
/**
 * Page Override — Hyper Post Manager
 *
 * Intercepts WordPress's template-loading process and replaces the
 * configured page's theme template with the plugin's custom dashboard
 * template. Unauthorized visitors are redirected to the home page.
 *
 * @package HyperPostManager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class HPM_Page_Override
 *
 * Hooks into `template_include` (high priority) to serve the plugin's
 * dashboard template in place of the active theme's template whenever
 * the current page matches the administrator-configured dashboard page.
 *
 * @since 1.0.0
 */
class HPM_Page_Override {

	/**
	 * Constructor.
	 *
	 * Registers the template_include filter at priority 999 so it runs
	 * after most other theme and plugin template filters.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'template_include', array( $this, 'maybe_override_template' ), 999 );
	}

	/**
	 * Conditionally replace the active template with the HPM dashboard.
	 *
	 * Checks:
	 *  1. A dashboard page ID has been configured.
	 *  2. The current request is for that page.
	 *  3. The current user has 'manage_options' capability.
	 *
	 * Non-admin visitors on the dashboard page are redirected to home.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $template Absolute path to the template resolved by WordPress.
	 * @return string           Path to the HPM dashboard template, or the original template.
	 */
	public function maybe_override_template( string $template ): string {
		$dashboard_page_id = (int) get_option( 'hpm_dashboard_page_id' );

		if ( ! $dashboard_page_id || ! is_page( $dashboard_page_id ) ) {
			return $template;
		}

		// Redirect non-admins away from the dashboard.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		$dashboard_template = HPM_PATH . 'templates/dashboard-template.php';

		if ( file_exists( $dashboard_template ) ) {
			return $dashboard_template;
		}

		return $template;
	}
}
