<?php
/**
 * Tab: Dashboard Overview — Hyper Post Manager
 *
 * Displays high-level statistics and a recent campaigns table.
 * Replace static values with dynamic queries as needed.
 *
 * @package HyperPostManager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// --- Metrics (replace with dynamic queries in production) ---
$total_posts   = (int) wp_count_posts()->publish;
$active_ads    = 13;
$pending_tasks = 5;

/**
 * Recent campaigns data.
 * In production, replace with a custom post type query or DB lookup.
 *
 * @var array<int, array{name: string, status: string, date: string}>
 */
$recent_campaigns = array(
	array(
		'name'   => __( 'Winter Sale Promo', 'hyper-post-manager' ),
		'status' => 'active',
		'date'   => '2024-01-10',
	),
	array(
		'name'   => __( 'Brand Awareness Ad', 'hyper-post-manager' ),
		'status' => 'scheduled',
		'date'   => '2024-01-15',
	),
);

/**
 * Badge colour map for campaign statuses.
 *
 * @var array<string, array{color: string, bg: string}>
 */
$status_styles = array(
	'active'    => array( 'color' => '#166534', 'bg' => '#dcfce7' ),
	'scheduled' => array( 'color' => '#854d0e', 'bg' => '#fef9c3' ),
	'paused'    => array( 'color' => '#6b7280', 'bg' => '#f3f4f6' ),
);
?>

<!-- Stats Grid -->
<div class="hpm-stats-grid">

	<div class="hpm-stat-card">
		<span class="hpm-stat-label"><?php esc_html_e( 'Total Posts', 'hyper-post-manager' ); ?></span>
		<span class="hpm-stat-value"><?php echo esc_html( number_format_i18n( $total_posts ) ); ?></span>
	</div>

	<div class="hpm-stat-card">
		<span class="hpm-stat-label"><?php esc_html_e( 'Active Ads', 'hyper-post-manager' ); ?></span>
		<span class="hpm-stat-value"><?php echo esc_html( number_format_i18n( $active_ads ) ); ?></span>
	</div>

	<div class="hpm-stat-card">
		<span class="hpm-stat-label"><?php esc_html_e( 'Pending Tasks', 'hyper-post-manager' ); ?></span>
		<span class="hpm-stat-value"><?php echo esc_html( number_format_i18n( $pending_tasks ) ); ?></span>
	</div>

</div>
<!-- /Stats Grid -->

<!-- Recent Campaigns Table -->
<div class="hpm-table-container">

	<div class="hpm-table-header">
		<h3 class="hpm-table-title"><?php esc_html_e( 'Recent Campaigns', 'hyper-post-manager' ); ?></h3>
	</div>

	<table class="hpm-table" aria-label="<?php esc_attr_e( 'Recent Campaigns', 'hyper-post-manager' ); ?>">
		<thead>
			<tr>
				<th scope="col"><?php esc_html_e( 'Campaign Name', 'hyper-post-manager' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Status', 'hyper-post-manager' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Date Created', 'hyper-post-manager' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if ( ! empty( $recent_campaigns ) ) : ?>
				<?php foreach ( $recent_campaigns as $campaign ) :
					$status = sanitize_key( $campaign['status'] );
					$style  = $status_styles[ $status ] ?? array( 'color' => '#374151', 'bg' => '#f3f4f6' );
				?>
					<tr>
						<td><?php echo esc_html( $campaign['name'] ); ?></td>
						<td>
							<span
								class="hpm-status-badge"
								style="color:<?php echo esc_attr( $style['color'] ); ?>;background:<?php echo esc_attr( $style['bg'] ); ?>;"
							>
								<?php echo esc_html( ucfirst( $status ) ); ?>
							</span>
						</td>
						<td><?php echo esc_html( $campaign['date'] ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td colspan="3"><?php esc_html_e( 'No campaigns found.', 'hyper-post-manager' ); ?></td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>

</div>
<!-- /Recent Campaigns Table -->
