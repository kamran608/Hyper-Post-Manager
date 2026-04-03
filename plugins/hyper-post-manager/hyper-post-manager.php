<?php
/**
 * Plugin Name:       Hyper Post Manager
 * Plugin URI:        https://swrice.com/hyper-post-manager
 * Description:       A professional SaaS-style dashboard for managing posts, social accounts, and publishing — directly within WordPress.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Swrice
 * Author URI:        https://swrice.com
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       hyper-post-manager
 * Domain Path:       /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Hyper_Post_Manager
 *
 * Main plugin class. Implements Singleton pattern.
 * Manages initialization, dependency loading, hooks, and asset enqueuing.
 *
 * @package HyperPostManager
 * @since   1.0.0
 */
final class Hyper_Post_Manager {

	/**
	 * Plugin version.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public const VERSION = '1.0.0';

	/**
	 * Single instance of this class.
	 *
	 * @since 1.0.0
	 * @var Hyper_Post_Manager|null
	 */
	private static ?Hyper_Post_Manager $instance = null;

	/**
	 * Returns the singleton instance.
	 *
	 * @since  1.0.0
	 * @return Hyper_Post_Manager
	 */
	public static function get_instance(): Hyper_Post_Manager {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * Private to enforce singleton usage.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		$this->define_constants();
		$this->load_dependencies();
		$this->register_hooks();
	}

	/**
	 * Define plugin-wide constants.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function define_constants(): void {
		define( 'HPM_VERSION',  self::VERSION );
		define( 'HPM_PATH',     plugin_dir_path( __FILE__ ) );
		define( 'HPM_URL',      plugin_dir_url( __FILE__ ) );
		define( 'HPM_BASENAME', plugin_basename( __FILE__ ) );
	}

	/**
	 * Load required plugin dependencies.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function load_dependencies(): void {
		require_once HPM_PATH . 'includes/class-hpm-admin-settings.php';
		require_once HPM_PATH . 'includes/class-hpm-page-override.php';
		require_once HPM_PATH . 'includes/class-hpm-dashboard.php';

		new HPM_Admin_Settings();
		new HPM_Page_Override();
		new HPM_Dashboard();
	}

	/**
	 * Register WordPress action and filter hooks.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function register_hooks(): void {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
	}

	/**
	 * Enqueue frontend CSS and JS assets.
	 *
	 * Assets are only loaded on the configured dashboard page.
	 * PHP data is passed to JavaScript via wp_localize_script().
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_frontend_assets(): void {
		$dashboard_page_id = (int) get_option( 'hpm_dashboard_page_id' );

		if ( ! $dashboard_page_id || ! is_page( $dashboard_page_id ) ) {
			return;
		}

		// Core dependency.
		wp_enqueue_script( 'jquery' );

		// Google Fonts — Inter.
		wp_enqueue_style(
			'hpm-google-fonts',
			'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
			array(),
			null
		);

		// Lucide icons library.
		wp_enqueue_script(
			'hpm-lucide-icons',
			'https://unpkg.com/lucide@latest',
			array(),
			null,
			true
		);

		// Main dashboard stylesheet.
		wp_enqueue_style(
			'hpm-dashboard',
			HPM_URL . 'assets/css/dashboard.css',
			array( 'hpm-google-fonts' ),
			HPM_VERSION
		);

		// Main dashboard script.
		wp_enqueue_script(
			'hpm-dashboard',
			HPM_URL . 'assets/js/dashboard.js',
			array( 'jquery', 'hpm-lucide-icons' ),
			HPM_VERSION,
			true
		);

		// Pass data to JS.
		wp_localize_script(
			'hpm-dashboard',
			'hpmVars',
			array(
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'nonce'      => wp_create_nonce( 'hpm_ajax_nonce' ),
				'userName'   => esc_js( wp_get_current_user()->display_name ),
				'logoutUrl'  => esc_url( wp_logout_url( home_url() ) ),
				'defaultTab' => 'dashboard',
			)
		);
	}
}

/**
 * Returns the main plugin instance.
 *
 * @since  1.0.0
 * @return Hyper_Post_Manager
 */
function hpm(): Hyper_Post_Manager {
	return Hyper_Post_Manager::get_instance();
}

// Boot the plugin.
hpm();
