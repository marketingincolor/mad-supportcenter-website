<?php
/*
* * Template Name: Marketing Downloads
* * */
get_header();?>

<style>
    .modal-box {
      display: none;
      position: fixed;
      z-index: 1000;
      width: 60%;
      background: white;
      border-bottom: 1px solid #aaa;
      border-radius: 4px;
      box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
      border: 1px solid rgba(0, 0, 0, 0.1);
      background-clip: padding-box;
    }

    .modal-box header,
    .modal-box .modal-header {
      padding: 1.25em 1.5em;
      border-bottom: 1px solid #ddd;
    }

    .modal-box header h3,
    .modal-box header h4,
    .modal-box .modal-header h3,
    .modal-box .modal-header h4 { margin:0; }

    .modal-box .modal-body { padding:2em 1.5em; }
    .modal-box .modal-image { padding-left:5px;}
    .modal-box .modal-image img { max-height:400px; width:auto; }
    .modal-box .modal-content-body { float:right; position:absolute; width:50%; right:1px; top:60px; padding-right: 20px; }
    .modal-box .modal-download-btn { margin-top:1.3em; }
    .modal-box .meta-title { font-size: 1.1em; font-weight: bold; line-height: 1.3; padding-bottom: 0.5em; }

    .modal-overlay {
      opacity: 0;
      filter: alpha(opacity=0);
      position: fixed;
      top: 0;
      left: 0;
      z-index: 900;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 1) !important;
    }

    a.close {
      line-height: 1;
      font-size: 1.5em;
      position: absolute;
      top: 4%;
      right: 2%;
      text-decoration: none;
      color: #bbb;
    }

    a.close:hover {
      color: #222;
      -webkit-transition: color 1s ease;
      -moz-transition: color 1s ease;
      transition: color 1s ease;
    }
</style>
<script>
    //$(function(){
    jQuery(function($){
    var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");
      $('a[data-modal-id]').click(function(e) {
        e.preventDefault();
        $("body").append(appendthis);
        $(".modal-overlay").fadeTo(500, 0.9);
        //$(".js-modalbox").fadeIn(500);
        var modalBox = $(this).attr('data-modal-id');
        $('#'+modalBox).fadeIn($(this).data());
      });  

    $(".js-modal-close, .modal-overlay").click(function() {
      $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
      });
    });

    $(window).resize(function() {
      $(".modal-box").css({
        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
      });
    });

    $(window).resize();

    });
</script>

<div id="container">
    <div id="full-content" role="main">
        <style type="text/css">
        #read-more-lnk {
            display: none;
        }
        </style>

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
        
            <?php 
                if (is_user_logged_in()) {
                    echo do_shortcode('[downloads template="mktg-lit" category="lit-'.$post->post_name.'" loop_start="<div class=\'dlm-downloads\'>" loop_end="</div>" before="<div class=\'mktg-d\'>" after="</div>" orderby="title" order="ASC"]');
                }
            ?>
    </div><!-- #content -->
    
</div><!-- #container -->

<?php //get_sidebar(); ?>

<?php get_footer(); ?>