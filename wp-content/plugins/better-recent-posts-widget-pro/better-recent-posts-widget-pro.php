<?php
/*
Plugin Name: Better Recent Posts Widget Pro
Plugin URI: http://pippinsplugins.com/better-recent-posts-widget
Description: Provides a better recent posts widget, including thumbnails, taxonomy, post type, and number options
Version: 2.0.2
Author: Pippin Williamson
Author URI: http://pippinsplugins.com
*/


/**
 * Recent Posts Widget Class
 */
class brpwp_wrapper extends WP_Widget {


    /** constructor */
    function brpwp_wrapper() {
        parent::WP_Widget(false, $name = 'Better Recent Posts Pro');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {	
        extract( $args );
        $title 			= apply_filters('widget_title', $instance['title']);
        $post_title		= apply_filters('widget_title', $instance['post_title']);
        $author			= apply_filters('widget_title', $instance['author']);
        $time			= apply_filters('widget_title', $instance['time']);
        $comments		= apply_filters('widget_title', $instance['comments']);
        $excerpt		= apply_filters('widget_title', $instance['excerpt']);
        $excerpt_length	= apply_filters('widget_title', $instance['excerpt_length']);
        $order 			= apply_filters('widget_title', $instance['order']);
        $sortby 		= apply_filters('widget_title', $instance['sortby']);
        $number 		= apply_filters('widget_title', $instance['number']);
        $offset 		= apply_filters('widget_title', $instance['offset']);
        $cat 			= apply_filters('widget_title', $instance['cat']);
        $cat_ids		= apply_filters('widget_title', $instance['cat_ids']);
        $thumbnail_size = apply_filters('widget_title', $instance['thumbnail_size']);
        $thumbnail 		= $instance['thumbnail'];
        $posttype 		= $instance['posttype'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<ul class="no-bullets">
							<?php
								global $post;
								$tmp_post = $post;
								$args = array( 'numberposts' => $number, 'offset'=> $offset, 'post_type' => $posttype, 'orderby' => $sortby, 'order' => $order );
								if($cat != 'All') {
									$cats = explode(',', $cat_ids);
									$args['tax_query'] = array(
										array(
											'taxonomy' 	=> $cat,
											'field' 	=> 'id',
											'terms'		=> $cats,
											'operator'	=> 'IN'
										)
									);
								}
									
								$myposts = get_posts( $args );
								foreach( $myposts as $post ) : setup_postdata($post); ?>
									<li <?php if(!empty($thumbnail_size) && has_post_thumbnail()) { $size = $thumbnail_size + 8; echo 'style="min-height: ' . $size . 'px; height: auto!important; height: 100%;"'; } ?> >
										<?php if($thumbnail == true) { ?>
											<a href="<?php the_permalink(); ?>" style="float: left; margin: 0 5px 0 0;"><?php the_post_thumbnail(array($thumbnail_size));?></a>
										<?php } ?>
										<?php if($post_title == true) { ?>
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										<?php } ?>
										<?php if($comments == true) { ?> (<a href="<?php comments_link(); ?>" title="View comments on <?php echo $post->post_title; ?>"><?php comments_number('0', '1', '%'); ?></a>)<?php } ?>
										<?php if($author == true) { ?>
											by <?php the_author(); ?> -
										<?php } ?>
										<?php if($time == true) { ?>
											<span class="time"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?></span>
										<?php } ?>
										<?php if($excerpt == true) { 
											$content_excerpt = $post->post_excerpt;
											if($content_excerpt == '') {
												$content_excerpt = $post->post_content;
											}
											$content_excerpt = strip_tags(stripslashes($content_excerpt), '<a><em><strong>');
											if (!isset($excerpt_length)) { $excerpt_length = 10; }
											$content_excerpt = preg_split('/\b/', $content_excerpt, $excerpt_length*2+1);
											$body_excerpt_waste = array_pop($content_excerpt);
											$content_excerpt = implode($content_excerpt);
											$content_excerpt .= '...';
											echo apply_filters('the_content',$content_excerpt);
											
										} ?>
										
									</li>
								<?php endforeach; ?>
								<?php $post = $tmp_post; ?>
							</ul>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['post_title'] 	= strip_tags($new_instance['post_title']);
		$instance['author'] 		= strip_tags($new_instance['author']);
		$instance['time'] 			= strip_tags($new_instance['time']);
		$instance['comments'] 		= strip_tags($new_instance['comments']);
		$instance['excerpt'] 		= strip_tags($new_instance['excerpt']);
		$instance['excerpt_length'] = strip_tags($new_instance['excerpt_length']);
		$instance['order'] 			= strip_tags($new_instance['order']);
		$instance['sortby'] 		= strip_tags($new_instance['sortby']);
		$instance['number']	 		= strip_tags($new_instance['number']);
		$instance['offset'] 		= strip_tags($new_instance['offset']);
		$instance['cat'] 			= strip_tags($new_instance['cat']);
		$instance['cat_ids']		= strip_tags($new_instance['cat_ids']);
		$instance['thumbnail_size'] = strip_tags($new_instance['thumbnail_size']);
		$instance['thumbnail'] 		= $new_instance['thumbnail'];
		$instance['posttype'] 		= $new_instance['posttype'];
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {	

		$posttypes = get_post_types('', 'objects');
	
        $title 			= esc_attr($instance['title']);
        $post_title		= esc_attr($instance['post_title']);
        $author			= esc_attr($instance['author']);
        $time			= esc_attr($instance['time']);
        $excerpt		= esc_attr($instance['excerpt']);
        $excerpt_length	= esc_attr($instance['excerpt_length']);
        $comments		= esc_attr($instance['comments']);
        $order			= esc_attr($instance['order']);
        $sortby			= esc_attr($instance['sortby']);
        $number 		= esc_attr($instance['number']);
        $offset 		= esc_attr($instance['offset']);
        $cat 			= esc_attr($instance['cat']);
        $cat_ids		= esc_attr($instance['cat_ids']);
        $thumbnail_size = esc_attr($instance['thumbnail_size']);
        $thumbnail 		= esc_attr($instance['thumbnail']);
		$posttype		= esc_attr($instance['posttype']);
        ?>

        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('post_title'); ?>" name="<?php echo $this->get_field_name('post_title'); ?>" type="checkbox" value="1" <?php checked( '1', $post_title ); ?>/>
          <label for="<?php echo $this->get_field_id('post_title'); ?>"><?php _e('Display Post Title?'); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('author'); ?>" name="<?php echo $this->get_field_name('author'); ?>" type="checkbox" value="1" <?php checked( '1', $author ); ?>/>
          <label for="<?php echo $this->get_field_id('author'); ?>"><?php _e('Display Post Author?'); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('time'); ?>" name="<?php echo $this->get_field_name('time'); ?>" type="checkbox" value="1" <?php checked( '1', $time ); ?>/>
          <label for="<?php echo $this->get_field_id('time'); ?>"><?php _e('Display Post Date?'); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('comments'); ?>" name="<?php echo $this->get_field_name('comments'); ?>" type="checkbox" value="1" <?php checked( '1', $comments ); ?>/>
          <label for="<?php echo $this->get_field_id('comments'); ?>"><?php _e('Display Comment Count?'); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="checkbox" value="1" <?php checked( '1', $excerpt ); ?>/>
          <label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e('Display Post Excerpt?'); ?></label> 
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e('Excerpt length in words'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('excerpt_length'); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" type="text" value="<?php echo $excerpt_length; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Choose the Order to Display Posts'); ?></label> 
			<select name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>" class="widefat">
				<?php
				$orders = array('ASC', 'DESC');
				foreach ($orders as $post_order) {
					echo '<option value="' . $post_order . '" id="' . $post_order . '"', $order == $post_order ? ' selected="selected"' : '', '>', $post_order, '</option>';
				}
				?>
			</select>	
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('sortby'); ?>"><?php _e('Choose the Post Sorting Method'); ?></label> 
			<select name="<?php echo $this->get_field_name('sortby'); ?>" id="<?php echo $this->get_field_id('sortby'); ?>" class="widefat">
				<?php
				$sort_options = array('title', 'post_date', 'rand');
				foreach ($sort_options as $sort) {
					echo '<option id="' . $sort . '"', $sortby == $sort ? ' selected="selected"' : '', '>', $sort, '</option>';
				}
				?>
			</select>	
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number to Show:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('offset'); ?>"><?php _e('Offset (the number of posts to skip):'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" type="text" value="<?php echo $offset; ?>" />
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('thumbnail'); ?>" name="<?php echo $this->get_field_name('thumbnail'); ?>" type="checkbox" value="1" <?php checked( '1', $thumbnail ); ?> class="extra-options-thumb"/>
          <label for="<?php echo $this->get_field_id('thumbnail'); ?>"><?php _e('Display Thumbnails?'); ?></label> 
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('thumbnail_size'); ?>" class="disabled-thumb-fields" ><?php _e('Size of the thumbnails, e.g. <em>80</em> = 80px x 80px'); ?></label> 
          <input class="widefat disabled-thumb-fields" id="<?php echo $this->get_field_id('thumbnail_size'); ?>" name="<?php echo $this->get_field_name('thumbnail_size'); ?>" type="text" value="<?php echo $thumbnail_size; ?>"  />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('Choose the Taxonomy to Display Posts From'); ?></label> 
			<select name="<?php echo $this->get_field_name('cat'); ?>" id="<?php echo $this->get_field_id('cat'); ?>" class="widefat extra-options-select">
				<?php
				$cats = get_taxonomies('','names'); 
				echo '<option id="cats-all"', $cat == 'cats-all' ? ' selected="selected"' : '', '>All</option>';
				foreach ($cats as $tax) {
					echo '<option id="' . $tax . '"', $cat == $tax ? ' selected="selected"' : '', '>', $tax, '</option>';
				}
				?>
			</select>	
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('cat_ids'); ?>" class="disabled-select-fields" ><?php _e('Taxonomy Term IDs to Display Posts From'); ?></label> 
          <input class="widefat disabled-select-fields" id="<?php echo $this->get_field_id('cat_ids'); ?>" name="<?php echo $this->get_field_name('cat_ids'); ?>" type="text" value="<?php echo $cat_ids; ?>" />
        </p>
		<p>	
			<label for="<?php echo $this->get_field_id('posttype'); ?>"><?php _e('Choose the Post Type to Display'); ?></label> 
			<select name="<?php echo $this->get_field_name('posttype'); ?>" id="<?php echo $this->get_field_id('posttype'); ?>" class="widefat">
				<?php
				foreach ($posttypes as $option) {
					echo '<option id="' . $option->name . '"', $posttype == $option->name ? ' selected="selected"' : '', '>', $option->name, '</option>';
				}
				?>
			</select>		
		</p>
        <?php 
    }


} // class brpwp_wrapper
// register Recent Posts widget
add_action('widgets_init', create_function('', 'return register_widget("brpwp_wrapper");'));

?>