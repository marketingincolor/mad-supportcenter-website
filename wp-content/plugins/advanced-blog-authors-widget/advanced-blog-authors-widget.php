<?php
/*
Plugin Name: Advanced Blog Authors Widget
Description: Provides a widget to list blog authors, including gravatars, post counts, and bios
Version: 1.0
Author: Pippin Williamson
Author URI: http://pippinsplugins.com
*/

/**
 * Authors Widget Class
 */
class pippin_advanced_authors_widget extends WP_Widget {


    /** constructor */
    function pippin_advanced_authors_widget() {
        parent::WP_Widget(false, $name = 'Advanced Authors Widget');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {	
        extract( $args );
		global $wpdb;
		
        $title = apply_filters('widget_title', $instance['title']);
		$gravatar = $instance['gravatar'];
		$gravatar_size = $instance['gravatar_size'];
		$count = $instance['count'];
		$bio = $instance['bio'];
		$float = $instance['float'];
		$clear = $instance['clear'];
		$url = $instance['url'];
		
		if(!$gravatar_size)
			$gravatar_size = 40;

        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<ul>
							<?php

								$authors = $wpdb->get_results("SELECT ID FROM $wpdb->users ORDER BY ID");

								foreach($authors as $author) {
									
									$author_info = get_userdata($author->ID);
									
									echo '<li style="padding-bottom: 10px;">';
									
										if($float != 'none') {
											if($float == 'left') { $margin = 'right'; } else { $margin = 'left'; }
											echo '<div style="float: ' . $float . '; margin-' . $margin . ': 5px;">';
										}
										echo get_avatar($author->ID, $gravatar_size);
										if($float != 'none') {
											echo '</div>';
										}
										if($url == 'Author Archive') {
											$author_url = get_author_posts_url($author->ID);
										} else {
											$author_url = get_the_author_meta('user_url', $author->ID);
										} 
										if($url != 'None') { echo '<a href="' . $author_url .'" title="View author archive">'; }
											echo $author_info->display_name;
											if($count) {
												echo '(' . count_user_posts($author->ID) . ')';
											}
										if($url != 'None') { echo '</a>'; }
										
										if($bio) {
											echo '<div'; if($clear) { echo ' style="clear: left;"'; } echo '>' . get_the_author_meta('description', $author->ID) . '</div>';
										}

									echo '</li>';
								}							
							?>
							</ul>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['gravatar'] = strip_tags($new_instance['gravatar']);
		$instance['gravatar_size'] = strip_tags($new_instance['gravatar_size']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['bio'] = strip_tags($new_instance['bio']);
		$instance['float'] = strip_tags($new_instance['float']);
		$instance['clear'] = strip_tags($new_instance['clear']);
		$instance['url'] = strip_tags($new_instance['url']);
		
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {	

        $title = esc_attr($instance['title']);
		$gravatar = esc_attr($instance['gravatar']);
		$gravatar_size = esc_attr($instance['gravatar_size']);
		$count = esc_attr($instance['count']);
		$bio = esc_attr($instance['bio']);
		$float = esc_attr($instance['float']);
		$clear = esc_attr($instance['clear']);
		$url = esc_attr($instance['url']);
		
        ?>
		<style type="text/css">
		.abaw-tooltip {
			border-bottom: 1px dotted #000000; outline: none; cursor: help; text-decoration: none; position: relative; color: #0777b3;
		}
		.abaw-tooltip span {
			position: absolute; background: #f0f0f0;
			background-image: -webkit-gradient(
			    linear,
			    left bottom,
			    left top,
			    color-stop(0.44, rgb(7,119,179)),
			    color-stop(0.86, rgb(49,152,204))
			);
			background-image: -moz-linear-gradient(
			    center bottom,
			    rgb(7,119,179) 44%,
			    rgb(49,152,204) 86%
			);
			padding: 10px;width: 100px;display: block;color: #fff;left: 10px; top: -50px;display: none;
			-webkit-transition: all 0.2s ease-in-out;
			-moz-transition: all 0.2s ease-in-out;
			-o-transition: all 0.2s ease-in-out;
			-ms-transition: all 0.2s ease-in-out;
			transition: all 0.2s ease-in-out;
		}
		.abaw-tooltip:hover span {
			border-radius: 5px 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; 
			box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.1); -moz-box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.1);
			font-family: Calibri, Tahoma, Geneva, sans-serif;position: absolute; z-index: 99;display: block;
		}
		</style>
		
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

		<p>
          <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="checkbox" value="1" <?php checked( '1', $count ); ?>/>
          <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Display Post Count?'); ?></label> 
        </p>

		<p>
          <input id="<?php echo $this->get_field_id('bio'); ?>" name="<?php echo $this->get_field_name('bio'); ?>" type="checkbox" value="1" <?php checked( '1', $bio ); ?>/>
          <label for="<?php echo $this->get_field_id('bio'); ?>"><?php _e('Display Author Bio?'); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('clear'); ?>" name="<?php echo $this->get_field_name('clear'); ?>" type="checkbox" value="1" <?php checked( '1', $clear ); ?>/>
          <label for="<?php echo $this->get_field_id('clear'); ?>"><?php _e('Clear author bio'); ?><a class="abaw-tooltip" href="#">?<span class="classic">Checking this will force the author bio to display beneath the gravatar, instead of next to it.</span></a>
		</label> 
        </p>

		<p>
          <input id="<?php echo $this->get_field_id('gravatar'); ?>" name="<?php echo $this->get_field_name('gravatar'); ?>" type="checkbox" value="1" <?php checked( '1', $gravatar ); ?>/>
          <label for="<?php echo $this->get_field_id('gravatar'); ?>"><?php _e('Display Author Gravatar?'); ?></label> 
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('gravatar_size'); ?>"><?php _e('Gravatar size in pixels. <em>Default: 40</em>'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('gravatar_size'); ?>" name="<?php echo $this->get_field_name('gravatar_size'); ?>" type="text" value="<?php echo $gravatar_size; ?>" />
        </p>
		<p>	
			<label for="<?php echo $this->get_field_id('float'); ?>"><?php _e('Float the gravatar?'); ?></label> 
			<select name="<?php echo $this->get_field_name('float'); ?>" id="<?php echo $this->get_field_id('float'); ?>" class="widefat">
				<?php
				$floats = array('left', 'right', 'none');
				foreach ($floats as $option) {
					echo '<option value="' . $option . '" id="' . $option . '"', $float == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				?>
			</select>		
		</p>
		
		<p>	
			<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Link author name to:'); ?></label> 
			<select name="<?php echo $this->get_field_name('url'); ?>" id="<?php echo $this->get_field_id('url'); ?>" class="widefat">
				<?php
				$urls = array('Author Archive', 'Author URL', 'None');
				foreach ($urls as $option) {
					echo '<option value="' . $option . '" id="' . $option . '"', $url == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				?>
			</select>		
		</p>
		
        <?php 
    }


} 
// register authors widget
add_action('widgets_init', create_function('', 'return register_widget("pippin_advanced_authors_widget");'));
