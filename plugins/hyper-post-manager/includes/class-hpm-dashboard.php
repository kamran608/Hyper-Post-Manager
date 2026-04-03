<?php
/**
 * Dashboard AJAX Handler — Hyper Post Manager
 *
 * Registers and handles the AJAX action that loads individual tab
 * content into the SPA-style dashboard without a full page reload.
 *
 * @package HyperPostManager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class HPM_Dashboard
 *
 * Maps tab slugs to their corresponding template files and serves
 * each template's output via WordPress AJAX.
 *
 * @since 1.0.0
 */
class HPM_Dashboard {

	/**
	 * AJAX action name.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const AJAX_ACTION = 'hpm_load_tab';

	/**
	 * Map of tab slugs to absolute template file paths.
	 *
	 * @since 1.0.0
	 * @var array<string, string>
	 */
	private array $tabs = array();

	/**
	 * Constructor.
	 *
	 * Populates the tab map and registers the AJAX action.
	 * Only authenticated users (admins) may load tab content.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->tabs = array(
			'dashboard'        => HPM_PATH . 'templates/tabs/dashboard.php',
			'account'          => HPM_PATH . 'templates/tabs/account.php',
			'social-publisher' => HPM_PATH . 'templates/tabs/social-publisher.php',
		);

		add_action( 'wp_ajax_' . self::AJAX_ACTION, array( $this, 'handle_load_tab' ) );
	}

	/**
	 * AJAX callback — output the requested tab's HTML.
	 *
	 * Validates the nonce, sanitizes the tab slug, resolves the
	 * corresponding template, and streams its buffered output.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function handle_load_tab(): void {
		// Capability check — only admins may use this endpoint.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Insufficient permissions.', 'hyper-post-manager' ), 403 );
		}

		// Nonce verification.
		if ( ! check_ajax_referer( 'hpm_ajax_nonce', 'nonce', false ) ) {
			wp_send_json_error( __( 'Security check failed.', 'hyper-post-manager' ), 403 );
		}

		$tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : '';

		if ( empty( $tab ) ) {
			wp_send_json_error( __( 'No tab specified.', 'hyper-post-manager' ), 400 );
		}

		if ( ! array_key_exists( $tab, $this->tabs ) ) {
			wp_send_json_error( __( 'Invalid tab.', 'hyper-post-manager' ), 400 );
		}

		$template_file = $this->tabs[ $tab ];

		if ( ! file_exists( $template_file ) ) {
			/* translators: %s: tab slug */
			wp_send_json_error( sprintf( __( 'Template for "%s" not found.', 'hyper-post-manager' ), $tab ), 404 );
		}

		ob_start();
		require $template_file;
		$html = ob_get_clean();

		// Output raw HTML (not JSON) so jQuery can inject it directly.
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		wp_die();
	}
}
