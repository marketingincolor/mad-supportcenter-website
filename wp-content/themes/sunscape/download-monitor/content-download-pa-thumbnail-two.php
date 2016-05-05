<?php
/**
 * Default output for a download via the [download] shortcode
 */

global $dlm_download, $dlm_page_addon;
?>
<a class="download-link" href="<?php echo $dlm_page_addon->get_download_info_link( $dlm_download ); ?>" rel="nofollow">
<?php echo $dlm_download->get_the_image( 'thumbnail' ); ?><br /><?php $dlm_download->the_title(); ?> 
</a>