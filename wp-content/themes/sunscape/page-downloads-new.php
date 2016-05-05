<?php
/*
* * Template Name: Downloads New
* * */
get_header();
global $cat, $blog_id, $wpdb, $download_monitor, $dlm_download, $dlm_page_addon;
$cat = !empty($wp_query->query_vars['cat']) ? $wp_query->query_vars['cat'] : 999;
$categories = get_terms( 'dlm_download_category' );

?>
<style type="text/css">
#download-selector { width: 285px; }
#download-page .download_category { clear:left; float:left;  width:100% !important; }
.download-information aside { float: left; width:38% !important; }
.download-information article { width:60% !important; margin-top:20px; }
.download_group { display: none; border: 0 none !important }
.download_group ol { list-style: none !important; }
#downloads-table { border: 0; }
table, tbody, tr, td { vertical-align: middle; padding: 4px !important; }
img { padding-top: 40px; }
</style>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#download-selector').change(function() {
            //var url = '<?= get_permalink() ?>';
            //var category = jQuery(this).val();
            //window.location = url + '?cat=' + category;
        });
		
		jQuery( '.download_group' ).addClass(function( index ) {
			return "item-" + (index + 1);
		});
		
		var $targets = jQuery('.download_group');
		jQuery('#download-selector').change(function(){
			var i = jQuery('option:selected', this).index()-1;
			$targets.hide().eq(i).show();
			jQuery( '#downimg' ).hide();
		});
    });
</script>

    <div class="container">
    <?php if (is_user_logged_in()) : ?>
        <div id="content" role="main" style="width:460px; float:left; margin-left:20px; margin-right:0;">
            <h1 class="entry-title">Downloads</h1>
            <div class="entry-content">
                <p>From case studies to installation techniques, a wide variety of marketing and informational materials are available for you to download.</p>
                <div align="left" style="margin-bottom: 5px;">
                    <select id="download-selector" name="category">
                        <option value="0">Choose A Category</option> 
                        <?php $num = '1'; ?>
                        <?php foreach ($categories as $category) : ?>
                        <option value="item-<?= $num ?>" <?= $cat == $category->term_id ? 'selected' : '' ?>><?= $category->name ?></option>
                        <?php $num++; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php echo do_shortcode('[download_page format=pa-single-two show_search=false show_featured=false show_tags=false category_limit=999 featured_limit=999]'); ?>

                <img id="downimg" src="<?= get_template_directory_uri(); ?>/images/download_arrow.jpg" style="display:inline;" />
            </div>
        </div>
        <div style="float:right; font-size:14px; margin-right:20px; width:380px;">
            <?php get_sidebar(); ?>
        </div>
    <?php else : ?>
        <div id="content" role="main" style="width:460px; float:left; margin-left:20px; margin-right:0;">
            <article class="post" style="border-bottom: none;">
                <h1 class="entry-title">Downloads</h1>
                <div class="entry-content">                              
                    <p>From case studies to installation techniques, a wide variety of marketing and informational materials are available for you to download. You are required to login to view this page.</p>
                    <?php echo wp_login_form(); ?>
                </div>
            </article>
        </div>
        <div style="float:right; font-size:14px; margin-right:20px; width:380px;">
            <?php get_sidebar(); ?>
        </div>

    <?php endif; ?>

    </div>
  
<?php get_footer(); ?>
