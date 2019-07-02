<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<?php if ( strtolower($_SERVER['HTTP_HOST']) == '4sunscape.com') : ?>
<meta name="robots" content="noindex" />
<meta name="robots" content="nofollow" />
<?php endif; ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	//bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		//echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<!--<link rel="alternate" type="application/rss+xml" title="Sunscape Dealer Feed" href="/sunscape-dealer-support/?feed=custom_feed">-->
<!--<link rel="alternate" type="application/rss+xml" title="Sunscape Dealer Feed" href="feed://feeds.feedburner.com/SunscapeDealerSupportCenter">-->
<!--<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/mobile.css" />-->
<meta property='fb:app_id' content='234876769940410' />

<meta property="og:title" content="<?php the_title(); ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />

<!-- Facebook Open Graph meta to control default image -->
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); $url = $thumb['0']; ?>
<meta property="og:image" content="<?=$url?>" />

<!-- Facebook Open Graph meta to control default description -->
<meta property="og:description" content="" />


<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>

<script>

	jQuery(document).ready(function () {
		jQuery("#login-box").hide();

		jQuery("#login-link").click(function(){
			jQuery("#login-box").slideToggle();
		});
	});

</script>

</head>

<body <?php body_class(); ?>>
	
	<!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NGP823"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-NGP823');</script>
	<!-- End Google Tag Manager -->

<div id="wrapper" class="hfeed">
	<div id="madico-branding">

		<div class="madico-logo">
			<img src="/wp-content/themes/sunscape/images/madico-logo.png" alt="Madico Window Films" />
		</div><!-- close .madico-logo -->

		<div id="login-area">

			<?php if ( is_user_logged_in() ) : ?>
			    <a id="login-link" href="<?php echo wp_logout_url(); ?>">Log Out</a>
			<?php endif; ?>

			<?php if ( ! is_user_logged_in() ) : ?>
			    <a id="login-link" href="#">Login</a>
			<?php endif; ?>

			<?php if ( ! is_user_logged_in() ) : ?>
				<div id="login-box">
				    <?php echo wp_login_form(); ?>
				</div>
				<?php endif; ?>
		</div><!-- close #login-area -->

	</div><!-- #madico-branding -->

	<div id="header">
		<div id="masthead">
			<div id="branding" role="banner">
				<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
				<<?php echo $heading_tag; ?> id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				</<?php echo $heading_tag; ?>>

			</div><!-- #branding -->

			<div id="access" role="navigation">
			  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
				<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>"><?php _e( 'Skip to content', 'twentyten' ); ?></a></div>
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
				<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
			</div><!-- #access -->
		</div><!-- #masthead -->
	</div><!-- #header -->

	<div id="main">
