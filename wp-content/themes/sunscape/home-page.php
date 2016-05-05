<?php
/*
Template Name: Home Page
*/
 
get_header(); ?>

		<div id="container">
			<div id="content" role="main">
 
<!-- Get the content of the blog article  -->
<?php  // get the content of our "my blog page"
if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
 
<?php endwhile; ?>
 
<?php  // get the articles of all categories
global $query_string; query_posts($query_string . "&posts_per_page=10");
rewind_posts();
 
get_template_part( 'loop', 'new' );
 ?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>