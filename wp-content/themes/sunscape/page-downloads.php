<?php
/*
* * Template Name: Downloads get
* * */
get_header();
global $cat,$blog_id,$wpdb,$dl;
$cat = !empty($wp_query->query_vars['cat']) ? $wp_query->query_vars['cat'] : 999;
$categories = $wpdb->get_results("SELECT * FROM wp_download_monitor_taxonomies ORDER BY NAME");
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#download-selector').change(function() {
            var url = '<?= get_permalink() ?>';
            var category = jQuery(this).val();
            window.location = url + '?cat=' + category;
        });
    });
</script>

	<div id="page-content" style="width:460px; float:left; margin-left:20px;">

        <?php if (is_user_logged_in()) : ?>

            <?php $dl = get_downloads("category={$cat}") ?>

            <article class="post" style="border-bottom: none;">

                <h2 class="entry-title">Downloads</h2>

                <div align="right" style="margin-bottom: 5px;">
                    <select id="download-selector" name="category">
                        <option value="0">Choose A Category</option>
                        <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category->id ?>" <?= $cat == $category->id ? 'selected' : '' ?>><?= $category->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <style type="text/css">
                        /* Select */
                    #download-selector {
                        width: 285px;
                    }

                        /* Img */
                    img {
                        padding-top: 40px;
                    }

                        /* Table */
                    #downloads-table {
                        border: 1px solid #DDDDDD;
                    }

                    #content tr td {
                        border-top: 1px solid #E7E7E7;
                        padding: 6px 10px;
                        vertical-align: top;
                    }

                    table, tbody, tr, td {
                        vertical-align: middle;
                    }
                    td img {
                        height: 122px;
                        width: 122px;
                    }

                    td button {
                        height: 55px;
                        width: 120px;
                    }

                    td span.desc {
                        color: #686868;
                        font-size: 14px;
                    }
                    td a:visited, td a:link {
                        color: #777;
                        text-decoration: none;
                    }
                        /* Buttons */
                    .btn-generic {
                        cursor: pointer;
                        -moz-box-shadow: inset 0px 1px 0px 0px #ffffff;
                        -webkit-box-shadow: inset 0px 1px 0px 0px #ffffff;
                        box-shadow: inset 0px 1px 0px 0px #ffffff;
                        background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf));
                        background: -moz-linear-gradient(center top, #ededed 5%, #dfdfdf 100%);
                        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr = '#ededed', endColorstr = '#dfdfdf');
                        background-color: #ededed;
                        -moz-border-radius: 6px;
                        -webkit-border-radius: 6px;
                        border-radius: 6px;
                        border: 1px solid #dcdcdc;
                        display: inline-block;
                        color: #777777;
                        font-family: arial;
                        font-size: 15px;
                        font-weight: bold;
                        padding: 6px 24px;
                        text-decoration: none;
                        text-shadow: 1px 1px 0px #ffffff;
                    }

                    .btn-generic:hover {
                        background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed));
                        background: -moz-linear-gradient(center top, #dfdfdf 5%, #ededed 100%);
                        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr = '#dfdfdf', endColorstr = '#ededed');
                        background-color: #dfdfdf;
                    }

                    .btn-generic:active {
                        position: relative;
                        top: 1px;
                    }
                </style>

                <?php if (!empty($dl)) : ?>

                <table id="downloads-table" class="table table-striped">
                    <tbody>

                        <?php foreach ($dl as $d) : ?>
                    <tr>
                        <td><img src="<?= $d->thumbnail ?>"/></td>
                        <td>
                            <a class="btn-generic lightbox" href="<?= $d->thumbnail ?>" style="margin-bottom: 10px;margin-right: 30px; margin-top: 30px;">Preview</a>
                            <a class="btn-generic" href="<?= $d->filename ?>">Download</a>
                            <span class="desc">Description: <?= $d->title ?></span></td>
                    </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

                <?php else : ?>

                <img src="http://www.4sunscape.com/wp-content/themes/sunscape/images/download_arrow.jpg"/>

                <?php endif; ?>

            </article>

        <?php else : ?>

        <div id="page-content" style="width:460px; float:left; margin-left:20px;">

            <article class="post" style="border-bottom: none;">
                <h2 class="entry-title">Downloads</h2>
                <p>You are required to login to view this page.</p>
                <?php echo wp_login_form(); ?>
            </article>

        </div>

        <?php endif; ?>

    </div>

    <div style="float:right; font-size:14px; margin-right:20px; width:380px;">
        <?php get_sidebar(); ?>
    </div>
  
<?php get_footer(); ?>
