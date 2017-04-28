<?php
/**
 * Template Name: One column Full Page, no sidebar
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<div id="container">
			<div id="full-content" role="main">

			<?php
			/* Run the loop to output the page.
			 * If you want to overload this in a child theme then include a file
			 * called loop-page.php and that will be used instead.
			 */
			if (is_user_logged_in()) {
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

<?php get_footer(); ?>
