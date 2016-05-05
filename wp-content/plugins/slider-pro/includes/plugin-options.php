<div class="wrap slider-pro">
	<div class="slider-icon"></div>
	<h2><?php _e('Plugin Options', 'slider_pro'); ?></h2>
	
	<?php
	if (isset($_POST['plugin_options_update']))
    	echo '<div id="message" class="updated below-h2"><p>' . __('Plugin options updated.', 'slider_pro') . '</p></div>';
	?>
	
    <form class="plugin-options" name="plugin_options" method="post" action="">
    <?php wp_nonce_field('plugin-options-update', 'plugin-options-nonce'); ?>
    	
        <div class="option">
        	<input type="checkbox" name="slider_pro_enable_timthumb" <?php echo get_option('slider_pro_enable_timthumb') == 1 ? 'checked="checked"' : ''; ?>>
            <p style="display: inline"><span>Enable TimThumb</span> - This option needs to be enabled if you want the images to be dynamically resized. </p>
        </div>
        
        <div class="option">
        	<input type="checkbox" name="slider_pro_use_compressed_scripts" <?php echo get_option('slider_pro_use_compressed_scripts') == 1 ? 'checked="checked"' : ''; ?>>
            <p style="display: inline"><span>Use Compressed Scripts</span> - You can disable this option if you want to use the uncompressed scripts, for debugging or other reasons. </p>
        </div>
        
        <div class="option">
        	<input type="checkbox" name="slider_pro_progress_animation" <?php echo get_option('slider_pro_progress_animation') == 1 ? 'checked="checked"' : ''; ?>>
            <p style="display: inline"><span>Progress Animation</span> - If you have problems with the 'progress' animation, usually occurring when you have an older version of WordPress installed, you can disable this option.</p>
        </div>
		
		<div class="option">
        	<input type="checkbox" name="slider_pro_visual_editor" <?php echo get_option('slider_pro_visual_editor') == 1 ? 'checked="checked"' : ''; ?>>
            <p style="display: inline"><span>Visual Editor</span> - This option will enable the TinyMCE visual editor for the Caption and Inline HTML sections. If you disable it, only a simple text area will be displayed.</p>
        </div>
        
        <div class="option">
        	<input type="checkbox" name="slider_pro_show_admin_bar_links" <?php echo get_option('slider_pro_show_admin_bar_links') == 1 ? 'checked="checked"' : ''; ?>>
            <p style="display: inline"><span>Show Admin Bar Links</span> - If you don't want the Slider PRO links to be displayed in the admin bar, you can disable this option.</p>
        </div>
        
		<div class="option">
        	<input type="checkbox" name="slider_pro_enqueue_jquery" <?php echo get_option('slider_pro_enqueue_jquery') == 1 ? 'checked="checked"' : ''; ?>>
            <p style="display: inline"><span>Enqueue jQuery</span> - The slider will need the jQuery library but if you already load it in your theme you can disable this option.</p>
        </div>
		        
        <div class="option">
        	<input type="checkbox" name="slider_pro_enqueue_bundled_jquery" <?php echo get_option('slider_pro_enqueue_bundled_jquery') == 1 ? 'checked="checked"' : ''; ?>>
            <p style="display: inline"><span>Enqueue jQuery 1.7.2</span> - You can enable this option if you have an older version of WordPress, which doesn't include at least jQuery 1.4.</p>
        </div>
        
        <div class="option">
        	<input type="checkbox" name="slider_pro_enqueue_jquery_easing" <?php echo get_option('slider_pro_enqueue_jquery_easing') == 1 ? 'checked="checked"' : ''; ?>>
            <p style="display: inline"><span>Enqueue jQuery Easing</span> - If you only use the default easing type you can disable this option.</p>
        </div>
        
        <div class="option">
        	<input type="checkbox" name="slider_pro_enqueue_jquery_mousewheel" <?php echo get_option('slider_pro_enqueue_jquery_mousewheel') == 1 ? 'checked="checked"' : ''; ?>>
            <p style="display: inline"><span>Enqueue jQuery MouseWheel</span> - If you use a different plugin for handling the mouse wheel input you can disable this option.</p>
        </div>
        
        <div class="option">
        	<input type="checkbox" name="slider_pro_generate_xml_file" <?php echo get_option('slider_pro_generate_xml_file') == 1 ? 'checked="checked"' : ''; ?>>
            <p style="display: inline"><span>Generate XML File</span> - This feature will generate an XML file for each of your sliders allowing you to export/import sliders. If your server doesn't have the DOM XML extension installed, you can disable the feature.</p>
        </div>
        
         <div class="option">
        	<select name="slider_pro_role_access">
				<?php
					global $sliderpro_role_access;
                    foreach ($sliderpro_role_access as $key => $value) {
                        $selected = get_option('slider_pro_role_access') == $key ? 'selected="selected"' : '';
                        echo "<option $selected>" . $key . "</option>";
                    }
                ?>
            </select>
            <p style="display: inline"><span>Role Access</span> - Select which role you want to have access to the Slider PRO plugin.</p>
        </div>
		
		<!--
		<div class="option">
        	<input type="checkbox" name="slider_pro_update_notification" <?php/* echo get_option('slider_pro_update_notification') == 1 ? 'checked="checked"' : ''; */?>>
            <p style="display: inline"><span>Update Notification</span> - You can disable the update notifications by unchecking this uption. If enabled, you will get update notifications and you will be able to update manually or automatically. For automatic updates you need to fill in the form below.</p>
        </div>
		-->
		
        <input type="submit" name="plugin_options_update" class="button-primary" value="Update Options"/>
    </form>
	
	
	<?php
	if (SLIDERPRO_AUTOMATIC_UPDATE === true) {
	?>
		<form class="automatic-update" name="automatic_update" method="post" action="">
		<?php wp_nonce_field('automatic-update-submit', 'automatic-update-nonce'); ?>
		
			<fieldset>
				<legend><?php _e('Enable Automatic Update', 'slider_pro'); ?></legend>
				
				<table>
					<tr>
						<td><label><?php _e('Your marketplace username', 'slider_pro'); ?></label></td>
						<td><input name="slider_pro_client_username" type="text" value="<?php echo get_option('slider_pro_client_username'); ?>"/></td>
					<tr>
					
					</tr>	
						<td><label><?php _e('Your marketplace API key', 'slider_pro'); ?></label></td>
						<td><input name="slider_pro_client_api_key" type="text" value="<?php echo get_option('slider_pro_client_api_key'); ?>"/></td>
					</tr>
					
					<tr>	
						<td><label><?php _e('Purchase code', 'slider_pro'); ?></label></td>
						<td><input name="slider_pro_item_purchase_code" type="text" value="<?php echo get_option('slider_pro_item_purchase_code'); ?>"/></td>
					</tr>
				</table>
				
				<div class="status clearfix">
					<p>
						<?php
							switch (get_option('slider_pro_automatic_update_status')) {
								case 'enabled':
									echo '* Automatic update is enabled.';
								break;
								
								case 'disabled':
									echo '* Automatic update is disabled.';
								break;
								
								case 'invalid-data':
									echo '* Automatic update is disabled. Provided data is incorrect.';
								break;
								
								default:
									echo '* Automatic update is disabled.';
								break;
							}
						?>
					</p>
					
					<input type="submit" name="automatic_update_submit" class="button-secondary" value="Submit"/>
				</div>
				
			</fieldset>
		</form>
	<?php
	}
	?>
	
</div>