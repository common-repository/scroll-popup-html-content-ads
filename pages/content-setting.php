<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php _e('Scroll popup html content ad', 'scroll-popup'); ?></h2>
	<h3><?php _e('Plugin Setting', 'scroll-popup'); ?></h3>
    <?php
	$sphca_On_Homepage = get_option('sphca_On_Homepage');
	$sphca_On_Posts = get_option('sphca_On_Posts');
	$sphca_On_Pages = get_option('sphca_On_Pages');
	$sphca_On_Archives = get_option('sphca_On_Archives');
	$sphca_On_Search = get_option('sphca_On_Search');
	$sphca_option = get_option('sphca_option');
	
	if (isset($_POST['sphca_form_submit']) && $_POST['sphca_form_submit'] == 'yes')
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('sphca_form_setting');
		
		$sphca_On_Homepage = stripslashes(trim(sanitize_text_field($_POST['sphca_On_Homepage'])));
		$sphca_On_Posts = stripslashes(trim(sanitize_text_field($_POST['sphca_On_Posts'])));
		$sphca_On_Pages = stripslashes(trim(sanitize_text_field($_POST['sphca_On_Pages'])));
		$sphca_On_Archives = stripslashes(trim(sanitize_text_field($_POST['sphca_On_Archives'])));
		$sphca_On_Search = stripslashes(trim(sanitize_text_field($_POST['sphca_On_Search'])));
		$sphca_option = stripslashes(trim(sanitize_text_field($_POST['sphca_option'])));
		
		if($sphca_On_Homepage != "YES" && $sphca_On_Homepage != "NO")
		{
			$sphca_On_Homepage = "YES";
		} 
		
		if($sphca_On_Posts != "YES" && $sphca_On_Posts != "NO")
		{
			$sphca_On_Posts = "YES";
		} 
		
		if($sphca_On_Pages != "YES" && $sphca_On_Pages != "NO")
		{
			$sphca_On_Pages = "YES";
		} 
		
		if($sphca_On_Archives != "YES" && $sphca_On_Archives != "NO")
		{
			$sphca_On_Archives = "YES";
		} 
		
		if($sphca_On_Search != "YES" && $sphca_On_Search != "NO")
		{
			$rigwppz_title_yes = "YES";
		} 
		
		if($sphca_option != "showalways" && $sphca_option != "oncepersession")
		{
			$sphca_option = "showalways";
		} 
		
		update_option('sphca_On_Homepage', $sphca_On_Homepage );
		update_option('sphca_On_Posts', $sphca_On_Posts );
		update_option('sphca_On_Pages', $sphca_On_Pages );
		update_option('sphca_On_Archives', $sphca_On_Archives );
		update_option('sphca_On_Search', $sphca_On_Search );
		update_option('sphca_option', $sphca_option );
		
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'scroll-popup'); ?></strong></p>
		</div>
		<?php
	}
	?>
	<form name="sphca_form" method="post" action="">
		
		<label for="tag-title"><?php _e('Display mode (Global setting)', 'scroll-popup'); ?></label>
		<select name="sphca_option" id="sphca_option">
			<option value='showalways' <?php if($sphca_option == 'showalways') { echo "selected='selected'" ; } ?>>Show always</option>
			<option value='oncepersession' <?php if($sphca_option == 'oncepersession') { echo "selected='selected'" ; } ?>>Once per session</option>
		</select>
		<p><?php _e('Display popup Always (or) Once per session', 'scroll-popup'); ?></p>
		
		<label for="tag-title"><?php _e('Display on home page', 'scroll-popup'); ?></label>
		<select name="sphca_On_Homepage" id="sphca_On_Homepage">
			<option value='YES' <?php if($sphca_On_Homepage == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($sphca_On_Homepage == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p><?php _e('This option is to display the popup on home page.', 'scroll-popup'); ?></p>
		
		<label for="tag-title"><?php _e('Display on wp posts', 'scroll-popup'); ?></label>
		<select name="sphca_On_Posts" id="sphca_On_Posts">
			<option value='YES' <?php if($sphca_On_Posts == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($sphca_On_Posts == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p><?php _e('This option is to display the popup on wp posts', 'scroll-popup'); ?></p>
		
		<label for="tag-title"><?php _e('Display on wp pages', 'scroll-popup'); ?></label>
		<select name="sphca_On_Pages" id="sphca_On_Pages">
			<option value='YES' <?php if($sphca_On_Pages == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($sphca_On_Pages == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p><?php _e('This option is to display the popup on wp pages.', 'scroll-popup'); ?></p>
		
		<label for="tag-title"><?php _e('Display on wp archives', 'scroll-popup'); ?></label>
		<select name="sphca_On_Archives" id="sphca_On_Archives">
			<option value='YES' <?php if($sphca_On_Archives == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($sphca_On_Archives == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p><?php _e('This option is to display the popup on wp archives pages.', 'scroll-popup'); ?></p>
		
		<label for="tag-title"><?php _e('Display on wp search', 'scroll-popup'); ?></label>
		<select name="sphca_On_Search" id="sphca_On_Search">
			<option value='YES' <?php if($sphca_On_Search == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($sphca_On_Search == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p><?php _e('This option is to display the popup on wp search pages.', 'scroll-popup'); ?></p>
		
		<div style="height:5px;"></div>
		<input type="hidden" name="sphca_form_submit" value="yes"/>
		<input name="sphca_submit" id="sphca_submit" class="button add-new-h2" value="<?php _e('Submit', 'scroll-popup'); ?>" type="submit" />&nbsp;
		<input name="publish" lang="publish" class="button add-new-h2" onclick="sphca_redirect()" value="<?php _e('Cancel', 'scroll-popup'); ?>" type="button" />&nbsp;
		<input name="Help" lang="publish" class="button add-new-h2" onclick="sphca_help()" value="<?php _e('Help', 'scroll-popup'); ?>" type="button" />
		<div style="height:5px;"></div>
		<?php wp_nonce_field('sphca_form_setting'); ?>
    </form>
	 </div>
	<p class="description">
		<?php _e('Check official website for more information', 'scroll-popup'); ?>
		<a target="_blank" href="<?php echo sphca_FAV; ?>"><?php _e('click here', 'scroll-popup'); ?></a>
	</p>
</div>