<?php
/**
 * The /friends/ header
 *
 * @version 1.0
 * @package Friends
 */

$_search = '';
if ( isset( $_GET['s'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$_search = sanitize_text_field( wp_unslash( $_GET['s'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
}

add_filter(
	'document_title_parts',
	function ( $title ) use ( $args ) {
		if ( isset( $args['title'] ) ) {
			$title['title'] = $args['title'];
		}
		return $title;
	}
);

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'off-canvas off-canvas-sidebar-show' ); ?>>
	<div id="friends-sidebar" class="off-canvas-sidebar">
		<div class="friends-brand">
			<a class="friends-logo" href="<?php echo esc_url( home_url( '/friends/' ) ); ?>">
			<img src="<?php echo esc_url( plugins_url( 'img/logo.png', dirname( __DIR__ ) ) ); ?>" width="36" height="36">
				<h2>Fedipress</h2>
			</a>
			<a class="friends-sidebar-customize" href="<?php echo esc_url( add_query_arg( 'url', home_url( '/friends/' ), admin_url( 'customize.php?autofocus[section]=sidebar-widgets-friends-sidebar' ) ) ); ?>"><?php esc_html_e( 'customize sidebar', 'friends' ); ?></a>
		</div>
		<div class="friends-nav accordion-container">
			<div class="friends-widget">
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" class="friends-post-inline" style="text-align: right;">
					<?php wp_nonce_field( 'friends_publish' ); ?>
					<input type="hidden" name="action" value="friends_publish" />
					<input class="form-input" type="text" name="title" value=""  />
					<textarea class="form-input"  name="content" rows="5" cols="70"></textarea>
					<button class="btn btn-primary input-group-btn"><?php _e( 'Publish', 'friends' ); ?></button>
				</form>
			</div>
			<div class="friends-widget">
				<h5>
					<span class="dashicons dashicons-update"></span>
					<a href="<?php echo esc_url( home_url( '/friends/?refresh' ) ); ?>">
						<?php echo esc_html_e( 'Refresh Feed', 'friends' );?>
					</a>
				</h5>
			</div>
			<div class="friends-widget">
				<h5>
					<a class="followers" href="<?php echo esc_url( home_url( '/friends/followers/' ) ); ?>">
						<span class="dashicons dashicons-admin-users"></span>
						<?php echo esc_html_e( "Followers", 'friends' ); ?>
					</a>
				</h5>
			</div>
			<div class="friends-widget">
				<h5>
					<a class="followers" href="<?php echo esc_url( home_url( '/friends/following/' ) ); ?>">
						<span class="dashicons dashicons-admin-users"></span>
						<?php echo esc_html_e( "Following", 'friends' ); ?>
					</a>
				</h5>
			</div>
			<div class="friends-widget">
				<h5>
					<a href="<?php echo esc_url( home_url( '/friends/reaction2b50/' ) ); ?>">
						<i class="dashicons dashicons-star-filled"></i> <?php echo esc_attr_e( "Starred", 'friends' ); ?>
					</a>
				</h5>
			</div>
			<div class="friends-widget">
				<h5>Search</h5>
				<form action="<?php echo esc_url( self_admin_url( 'admin.php?page=add-friend' ) ); ?>" method="post" class="input-group input-inline form-autocomplete">
					<?php wp_nonce_field( 'add-friend' ); ?>
					<div class="form-autocomplete-input form-input">
						<div class="has-icon-right">
							<input class="form-input" type="text"  tabindex="2" name="friend_url" placeholder="<?php echo esc_attr_e( "@user@url", 'friends' ); ?>" />
							<i class="form-icon"></i>
						</div>
					</div>
						<button class="btn btn-primary input-group-btn">
							<span class="dashicons dashicons-search"></span>
						</button>
				</form>
			</div>
			<div class="friends-widget">
				<h5>
					<a href="/wp-admin">
						<i class="dashicons dashicons-wordpress"></i> <?php echo esc_html_e( "Dashboard", 'friends' ); ?>
					</a>
				</h5>
			</div>
			<?php // dynamic_sidebar( 'friends-sidebar' ); ?>
		</div>
	</div>

	<a class="off-canvas-overlay" href="#close"></a>

	<div class="off-canvas-content">
		<header class="<?php echo is_single() ? '' : 'navbar'; ?><?php echo ( isset( $args['no-bottom-margin'] ) && $args['no-bottom-margin'] ) ? ' no-bottom-margin' : ''; ?>">
			<section class="navbar-section author">
			<a class="off-canvas-toggle btn btn-primary bt-action" href="#friends-sidebar">
				<span class="ab-icon dashicons dashicons-menu-alt2"></span>
			</a>
			<?php
			if ( $args['friend_user'] && $args['friend_user'] instanceof Friends\User && is_singular() ) {
				Friends\Friends::template_loader()->get_template_part(
					'frontend/single-header',
					$args['post_format'],
					$args
				);
			} elseif ( $args['friend_user'] && $args['friend_user'] instanceof Friends\User ) {
				Friends\Friends::template_loader()->get_template_part(
					'frontend/author-header',
					$args['post_format'],
					$args
				);
			} elseif ( isset( $args['title'] ) ) {
				?>
				<div id="main-header" class="mb-2">
					<h2 id="page-title"><a href="<?php echo esc_url( home_url( '/friends/' ) ); ?>">
						<?php echo esc_html( $args['title'] ); ?>
					</a></h2>
				</div>
				<?php
			} else {
				Friends\Friends::template_loader()->get_template_part(
					'frontend/main-feed-header',
					$args['post_format'],
					$args
				);
			}
			?>

			</section>

			<dialog class="search-dialog">
			</dialog>


			<section class="navbar-section search<?php echo esc_attr( is_singular() ? ' d-hide' : '' ); ?>">
				<form class="input-group input-inline form-autocomplete" action="<?php echo esc_url( home_url( '/friends/' ) ); ?>">
					<div class="form-autocomplete-input form-input">
						<div class="has-icon-right">
							<input class="form-input" type="text" tabindex="2" name="s" placeholder="<?php /* phpcs:ignore WordPress.WP.I18n.MissingArgDomain */ esc_attr_e( 'Search or paste URL' ); ?>" value="<?php echo esc_attr( $_search ); ?>" id="master-search" autocomplete="off" data-nonce="<?php echo esc_attr( wp_create_nonce( 'friends-autocomplete' ) ); ?>" />
							<i class="form-icon"></i>
						</div>
					</div>
					<ul class="menu" style="display: none">
					</ul>
					<button class="btn btn-primary input-group-btn"><?php /* phpcs:ignore WordPress.WP.I18n.MissingArgDomain */ esc_html_e( 'Search' ); ?></button>
				</form>
			</section>
		</header>
	<?php
	do_action( 'friends_after_header', $args );
