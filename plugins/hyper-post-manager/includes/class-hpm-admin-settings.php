<?php
/**
 * Admin Settings — Hyper Post Manager
 *
 * Registers and renders the plugin's admin configuration page,
 * allowing administrators to choose which WordPress page serves
 * as the SaaS-style dashboard.
 *
 * @package HyperPostManager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class HPM_Admin_Settings
 *
 * Handles admin menu registration, settings form rendering,
 * and option persistence with nonce verification.
 *
 * @since 1.0.0
 */
class HPM_Admin_Settings {

	/**
	 * Option key for storing the selected dashboard page ID.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const OPTION_PAGE_ID = 'hpm_dashboard_page_id';

	/**
	 * Nonce action for settings form.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const NONCE_ACTION = 'hpm_save_settings_action';

	/**
	 * Nonce field name for settings form.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const NONCE_FIELD = 'hpm_settings_nonce';

	/**
	 * Constructor.
	 *
	 * Registers the admin_menu hook.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
	}

	/**
	 * Register the plugin settings page in the WordPress admin sidebar.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function register_admin_menu(): void {
		add_menu_page(
			__( 'HPM Configuration', 'hyper-post-manager' ),
			__( 'HPM Settings', 'hyper-post-manager' ),
			'manage_options',
			'hpm-settings',
			array( $this, 'render_settings_page' ),
			'dashicons-performance',
			80
		);
	}

	/**
	 * Render the settings page.
	 *
	 * Handles form submission with nonce verification and sanitization,
	 * then outputs the settings UI.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function render_settings_page(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Handle form submission.
		if (
			isset( $_POST['hpm_save_settings'] ) &&
			check_admin_referer( self::NONCE_ACTION, self::NONCE_FIELD )
		) {
			$page_id = absint( $_POST['hpm_dashboard_page_id'] ?? 0 );
			update_option( self::OPTION_PAGE_ID, $page_id );

			add_settings_error(
				'hpm_settings',
				'hpm_settings_saved',
				__( 'Settings saved successfully. Your dashboard page has been configured.', 'hyper-post-manager' ),
				'updated'
			);
		}

		$current_page_id = (int) get_option( self::OPTION_PAGE_ID );
		$all_pages       = get_pages( array( 'sort_column' => 'post_title', 'sort_order' => 'ASC' ) );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Hyper Post Manager — Settings', 'hyper-post-manager' ); ?></h1>
			<p class="description">
				<?php esc_html_e( 'Select the WordPress page that will be replaced with the professional SaaS Dashboard.', 'hyper-post-manager' ); ?>
			</p>

			<?php settings_errors( 'hpm_settings' ); ?>

			<div class="card" style="max-width:640px; padding:24px; margin-top:24px;">
				<form method="post" action="">
					<?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD ); ?>

					<table class="form-table" role="presentation">
						<tr>
							<th scope="row">
								<label for="hpm_dashboard_page_id">
									<?php esc_html_e( 'Dashboard Page', 'hyper-post-manager' ); ?>
								</label>
							</th>
							<td>
								<select
									name="hpm_dashboard_page_id"
									id="hpm_dashboard_page_id"
									class="regular-text"
								>
									<option value="0">
										<?php esc_html_e( '— Select a WordPress Page —', 'hyper-post-manager' ); ?>
									</option>
									<?php foreach ( $all_pages as $page ) : ?>
										<option
											value="<?php echo esc_attr( $page->ID ); ?>"
											<?php selected( $current_page_id, $page->ID ); ?>
										>
											<?php echo esc_html( $page->post_title ); ?>
										</option>
									<?php endforeach; ?>
								</select>
								<p class="description">
									<?php esc_html_e( 'The selected page\'s original content will be replaced by the HPM Dashboard for administrators.', 'hyper-post-manager' ); ?>
								</p>
							</td>
						</tr>
					</table>

					<?php submit_button( __( 'Save Configuration', 'hyper-post-manager' ), 'primary', 'hpm_save_settings' ); ?>
				</form>
			</div>

			<?php if ( $current_page_id ) : ?>
				<p style="margin-top:16px;">
					<a
						href="<?php echo esc_url( get_permalink( $current_page_id ) ); ?>"
						target="_blank"
						rel="noopener noreferrer"
						class="button button-secondary"
					>
						<span class="dashicons dashicons-external" style="vertical-align:middle;margin-top:3px;"></span>
						<?php esc_html_e( 'Preview Dashboard', 'hyper-post-manager' ); ?>
					</a>
				</p>
			<?php endif; ?>
		</div>
		<?php
	}
}
