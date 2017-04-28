<?php
/*
Template Name: Biz Resources
*/

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<!-- Get the content of the blog article  -->

<?php  // get the content of our "my blog page"

global $post;
$category = get_post($post)->post_title;
$category_id = get_cat_ID( esc_attr($category) );

if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<?php endwhile; ?>

<?php  // get the articles of all categories
//global $query_string;
//global $post;
//$category = get_post($post)->post_title;
//$category_id = get_cat_ID('Sales & Marketing');

query_posts("cat=" . $category_id);
//var_dump($query_string);
var_dump($category);
var_dump($category_id);
rewind_posts();
get_template_part( 'loop', 'new' );

 ?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
