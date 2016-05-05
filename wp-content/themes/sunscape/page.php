<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">
<style type="text/css">
#read-more-lnk {
	display: none;
}
</style>

			<?php
			/* Run the loop to output the page.
			 * If you want to overload this in a child theme then include a file
			 * called loop-page.php and that will be used instead.
			 */
			$access = get_post_meta(get_the_ID(), 'Public Access', true);
			if (is_user_logged_in() || !empty($access)) {
			    get_template_part( 'loop', 'page' );
			} else {
			    while (have_posts()) {
			        the_post();
				echo '<h2 class="entry-title">';
				the_title();
				echo '</h2>';
				the_excerpt();
			    }
			    echo 'You are required to login to view this page.<br/><br/>';
			    wp_login_form();
			}
			?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>