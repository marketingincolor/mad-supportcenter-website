<?php
/**
 * Default output for a download via the [download] shortcode
 */

global $dlm_download, $dlm_page_addon;
$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

?>
<section class="download-information">
	<aside>
		<?php do_action( 'dlm_page_addon_aside_start' ); ?>

		<?php 
		$content = '<a href="' . $large_image_url[0] . '"> '.  $dlm_download->get_the_image( 'full' ) . '</a>';
		if ( function_exists('slb_activate') )
			$content = slb_activate($content);
		echo $content;
		?>

		<a class="aligncenter download-button" href="<?php $dlm_download->the_download_link(); ?>" rel="nofollow">
			<?php _e( 'Download', 'dlm_page_addon' ); ?>
		</a>

		<?php do_action( 'dlm_page_addon_aside_end' ); ?>
	</aside>
	<article>
		<table class="download-meta">
			<?php
				// Get formatted list of tags
				$terms = wp_get_post_terms( $dlm_download->id, 'dlm_download_tag' );
				$tags  = array();
				foreach ( $terms as $term )
					$tags[] = '<a href="' . $dlm_page_addon->get_tag_link( $term ) . '">' . $term->name . '</a>';

				// Get formatted list of categories
				$terms = wp_get_post_terms( $dlm_download->id, 'dlm_download_category' );
				$cats  = array();
				foreach ( $terms as $term )
					$cats[] = '<a href="' . $dlm_page_addon->get_category_link( $term ) . '">' . $term->name . '</a>';


				$download_meta = array(
					'filename' => array(
						'name'     => __( 'Filename', 'dlm_page_addon' ),
						'value'    => $dlm_download->get_the_filename(),
						'priority' => 1
					),
					//'filesize' => array(
					//	'name'     => __( 'Filesize', 'dlm_page_addon' ),
					//	'value'    => $dlm_download->get_the_filesize(),
					//	'priority' => 2
					//),
					'description' => array(
						'name'     => __( 'Description', 'dlm_page_addon' ),
						//'value'    => $dlm_download->get_the_short_description(),
						'value'    =>  wpautop( wptexturize( do_shortcode( $dlm_download->post->post_content ) ) ),
						'priority' => 2
					),

					'date' => array(
						'name'     => __( 'Date added', 'dlm_page_addon' ),
						'value'    => date_i18n( get_option( 'date_format' ), strtotime( $dlm_download->post->post_date ) ),
						'priority' => 4
					),
					//'downloaded' => array(
					//	'name'     => __( 'Downloaded', 'dlm_page_addon' ),
					//	'value'    => sprintf( _n( '1 time', '%d times', $dlm_download->get_the_download_count(), 'dlm_page_addon' ), $dlm_download->get_the_download_count() ),
					//	'priority' => 5
					//),
					//'categories' => array(
					//	'name'     => __( 'Category', 'dlm_page_addon' ),
					//	'value'    => implode( ', ', $cats ),
					//	'priority' => 6
					//),
					'tags' => array(
						'name'     => __( 'Tags', 'dlm_page_addon' ),
						'value'    => implode( ', ', $tags ),
						'priority' => 7
					)
				);

				$priority = sizeof( $download_meta );

				foreach ( get_post_custom( $dlm_download->id ) as $key => $meta ) {
					if ( strpos( $key, '_' ) === 0 )
						continue;

					$download_meta[ $key ] = array(
						'name'     => $key,
						'value'    => do_shortcode( make_clickable( $meta[0] ) ),
						'priority' => $priority
					);

					$priority++;
				}

				$download_meta = apply_filters( 'dlm_page_addon_download_meta', $download_meta );

				foreach ( $download_meta as $meta ) :
					if ( empty( $meta['value'] ) )
						continue;
					?>
					<tr>
						<td class="name"><?php echo $meta['name']; ?></td>
						<td class="value"><?php echo $meta['value']; ?></td>
					</tr>
				<?php endforeach;
			?>
		</table>

		<?php //the_content(); ?>
		
	</article>

</section>