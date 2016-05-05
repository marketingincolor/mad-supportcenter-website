<?php
/**
 * Custom output for Marketing Literature Downloads via the [download] shortcode
 */
global $dlm_download, $dlm_page_addon;
?>
<section class="download-information">
	<article>

        <div class="download-meta">
            <div class="meta-image">
                <a class="js-open-modal" href="#" data-modal-id="popup-<?php echo $dlm_download->id; ?>"><?php echo $dlm_download->get_the_image( 'medium' ); ?></a>
            </div>
            <div class="meta-title">
                <?php $dlm_download->the_title(); ?>
            </div>

            <div class="download-btn">
                <?php if( !is_page('promotional-accessories') ) { ?>
                <a class="aligncenter download-button" href="<?php $dlm_download->the_download_link(); ?>" rel="nofollow">
                    <?php _e( 'Download', 'dlm_page_addon' ); ?>
                </a>
                <?php } ; ?>
            </div>
        </div>
        
        <div id="popup-<?php echo $dlm_download->id; ?>" class="modal-box">  
            <a href="#" class="js-modal-close close">×</a>
            <div class="modal-image">
                <?php echo $dlm_download->get_the_image( 'full' ); ?>
            </div>
            <div class="modal-content-body">
                <div class="meta-title">
                    <?php $dlm_download->the_title(); ?>
                </div>
                <?php echo wptexturize( do_shortcode( $dlm_download->post->post_content ) ); ?>
                <div class="modal-download-btn">
                    <?php if( !is_page('promotional-accessories') ) { ?>
                    <a class="aligncenter download-button" href="<?php $dlm_download->the_download_link(); ?>" rel="nofollow">
                        <?php _e( 'Download', 'dlm_page_addon' ); ?>
                    </a>
                    <?php } ; ?>
                </div>
            </div>
        </div>
		
	</article>
</section>