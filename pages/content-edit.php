<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? sanitize_text_field($_GET['did']) : '0';
if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }

// First check if ID exist with requested ID
$sSql = $wpdb->prepare(
	"SELECT COUNT(*) AS `count` FROM ".wp_scroll_popup_html_content_ads_table."
	WHERE `sphca_id` = %d",
	array($did)
);
$result = '0';
$result = $wpdb->get_var($sSql);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'scroll-popup'); ?></strong></p></div><?php
}
else
{
	$sphca_errors = array();
	$sphca_success = '';
	$sphca_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".wp_scroll_popup_html_content_ads_table."`
		WHERE `sphca_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'sphca_text' => $data['sphca_text'],
		'sphca_title' => $data['sphca_title'],
		'sphca_width' => $data['sphca_width'],
		'sphca_height' => $data['sphca_height'],
		'sphca_pos1' => $data['sphca_pos1'],
		'sphca_pos2' => $data['sphca_pos2'],
		'sphca_pos3' => $data['sphca_pos3'],
		'sphca_date' => $data['sphca_date'],
		'sphca_id' => $data['sphca_id']
	);
}
// Form submitted, check the data
if (isset($_POST['sphca_form_submit']) && $_POST['sphca_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('sphca_form_edit');
	
	
	$form['sphca_text'] = isset($_POST['sphca_text']) ? wp_filter_post_kses($_POST['sphca_text']) : '';	
	if ($form['sphca_text'] == '')
	{
		$sphca_errors[] = __('Please enter the message.', 'scroll-popup');
		$sphca_error_found = TRUE;
	}
	
	$form['sphca_width'] = isset($_POST['sphca_width']) ? sanitize_text_field($_POST['sphca_width']) : '';
	$returnvalue = scroll_popup_html_content_validation::num_val($form['sphca_width']);
	if ($form['sphca_width'] == '' || $returnvalue == "invalid")
	{
		$sphca_errors[] = __('Please enter window width, only number.', 'scroll-popup');
		$sphca_error_found = TRUE;
	}
	
	$form['sphca_height'] = isset($_POST['sphca_height']) ? sanitize_text_field($_POST['sphca_height']) : '';
	$returnvalue = scroll_popup_html_content_validation::num_val($form['sphca_height']);
	if ($form['sphca_height'] == '' || $returnvalue == "invalid")
	{
		$sphca_errors[] = __('Please enter window height, only number.', 'scroll-popup');
		$sphca_error_found = TRUE;
	}
	
	$form['sphca_title'] = isset($_POST['sphca_title']) ? wp_filter_post_kses($_POST['sphca_title']) : '';
	
	$form['sphca_pos1'] = isset($_POST['sphca_pos1']) ? sanitize_text_field($_POST['sphca_pos1']) : '';
	if($form['sphca_pos1'] != "rightSide" && $form['sphca_pos1'] != "leftSide")
	{
		$form['sphca_pos1'] = "rightSide";
	}
		
	$form['sphca_pos2'] = isset($_POST['sphca_pos2']) ? sanitize_text_field($_POST['sphca_pos2']) : '';
	if($form['sphca_pos2'] != "bottomCorner" && $form['sphca_pos2'] != "topCorner")
	{
		$form['sphca_pos2'] = "bottomCorner";
	}
	
	$form['sphca_pos3'] = isset($_POST['sphca_pos3']) ? sanitize_text_field($_POST['sphca_pos3']) : '';
	if($form['sphca_pos3'] != "rightLeft" && $form['sphca_pos3'] != "bottopUp" && $form['sphca_pos3'] != "topDown" && $form['sphca_pos3'] != "leftRight")
	{
		$form['sphca_pos3'] = "rightLeft";
	}
	
	$form['sphca_date'] = isset($_POST['sphca_date']) ? sanitize_text_field($_POST['sphca_date']) : '';


	//	No errors found, we can add this Group to the table
	if ($sphca_error_found == FALSE)
	{	
		$sSql = $wpdb->prepare(
				"UPDATE `".wp_scroll_popup_html_content_ads_table."`
				SET `sphca_text` = %s,
				`sphca_title` = %s,
				`sphca_width` = %s,
				`sphca_height` = %s,
				`sphca_pos1` = %s,
				`sphca_pos2` = %s,
				`sphca_pos3` = %s,
				`sphca_date` = %s
				WHERE sphca_id = %d
				LIMIT 1",
				array($form['sphca_text'], $form['sphca_title'], $form['sphca_width'], $form['sphca_height'], 
				$form['sphca_pos1'], $form['sphca_pos2'], $form['sphca_pos3'], $form['sphca_date'], $did)
			);
		$wpdb->query($sSql);
		
		$sphca_success = __('Details was successfully updated.', 'scroll-popup');
	}
}

if ($sphca_error_found == TRUE && isset($sphca_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $sphca_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($sphca_error_found == FALSE && strlen($sphca_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $sphca_success; ?> <a href="<?php echo WP_sphca_ADMIN_URL; ?>"><?php _e('Click here to view the details', 'scroll-popup'); ?></a></strong></p>
	</div>
	<?php
}
?>
<script language="JavaScript" src="<?php echo WP_sphca_PLUGIN_URL; ?>/pages/noenter.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Scroll popup html content ad', 'scroll-popup'); ?></h2>
	<form name="sphca_form" method="post" action="#" onsubmit="return sphca_submit()"  >
      <h3><?php _e('Update Details', 'scroll-popup'); ?></h3>
	  
		<label for="tag-title"><?php _e('Popup window title', 'scroll-popup'); ?></label>
		<input name="sphca_title" type="text" id="sphca_title" value="<?php echo esc_html(stripslashes($form['sphca_title'])); ?>" size="70" maxlength="1000" /> 
		<p><?php _e('Enter your popup window title.', 'scroll-popup'); ?></p>
		
		<label for="tag-title"><?php _e('Window width', 'scroll-popup'); ?></label>
		<input name="sphca_width" type="text" id="sphca_width" value="<?php echo $form['sphca_width']; ?>" maxlength="4" />
		<p><?php _e('Enter your popup window width.', 'scroll-popup'); ?></p>
		
		<label for="tag-title"><?php _e('Window height', 'scroll-popup'); ?></label>
		<input name="sphca_height" type="text" id="sphca_height" value="<?php echo $form['sphca_height']; ?>" maxlength="4" />
		<p><?php _e('Enter your popup window height.', 'scroll-popup'); ?></p>
	  
	  	<label for="tag-title"><?php _e('Window position 1', 'scroll-popup'); ?></label>
		<select name="sphca_pos1" id="sphca_pos1">
            <option value='rightSide' <?php if($form['sphca_pos1'] == 'rightSide') { echo "selected='selected'" ; } ?>>Right Side</option>
            <option value='leftSide' <?php if($form['sphca_pos1'] == 'leftSide') { echo "selected='selected'" ; } ?>>Left Side</option>
          </select>
		<p><?php _e('Select your window position.', 'scroll-popup'); ?></p>
		
		<label for="tag-title"><?php _e('Window position 2', 'scroll-popup'); ?></label>
		<select name="sphca_pos2" id="sphca_pos2">
            <option value='bottomCorner' <?php if($form['sphca_pos2'] == 'bottomCorner') { echo "selected='selected'" ; } ?>>Bottom Corner</option>
            <option value='topCorner' <?php if($form['sphca_pos2'] == 'topCorner') { echo "selected='selected'" ; } ?>>Top Corner</option>
          </select>
		<p><?php _e('Select your window position.', 'scroll-popup'); ?></p>
		
		<label for="tag-title"><?php _e('Scroll direction', 'scroll-popup'); ?></label>
		<select name="sphca_pos3" id="sphca_pos3">
            <option value='rightLeft' <?php if($form['sphca_pos3'] == 'rightLeft') { echo "selected='selected'" ; } ?>>Right Left</option>
            <option value='bottopUp' <?php if($form['sphca_pos3'] == 'bottopUp') { echo "selected='selected'" ; } ?>>Bottom Up</option>
			<option value='topDown' <?php if($form['sphca_pos3'] == 'topDown') { echo "selected='selected'" ; } ?>>Top Down</option>
			<option value='leftRight' <?php if($form['sphca_pos3'] == 'leftRight') { echo "selected='selected'" ; } ?>>Left Right</option>
          </select>
		<p><?php _e('Select your scroll direction.', 'scroll-popup'); ?></p>
		
		<label for="tag-title"><?php _e('Popup message', 'scroll-popup'); ?></label>
		<textarea name="sphca_text" id="sphca_text" cols="120" rows="10"><?php echo esc_html(stripslashes($form['sphca_text'])); ?></textarea>
		<p><?php _e('Add your popup test here, your can add HTML content.', 'scroll-popup'); ?></p>
		
		<label for="tag-title"><?php _e('Expiration date', 'scroll-popup'); ?></label>
		<input name="sphca_date" type="text" id="sphca_date" value="<?php echo substr($form['sphca_date'],0,10); ?>" maxlength="10" />
		<p><?php _e('Please enter the expiration date in this format YYYY-MM-DD <br /> 9999-12-31 : Is equal to no expire.', 'scroll-popup'); ?></p>
	  
      <input name="sphca_id" id="sphca_id" type="hidden" value="<?php echo $form['sphca_id']; ?>">
      <input type="hidden" name="sphca_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Update Details', 'scroll-popup'); ?>" type="submit" />&nbsp;
        <input name="publish" lang="publish" class="button add-new-h2" onclick="sphca_redirect()" value="<?php _e('Cancel', 'scroll-popup'); ?>" type="button" />&nbsp;
        <input name="Help" lang="publish" class="button add-new-h2" onclick="sphca_help()" value="<?php _e('Help', 'scroll-popup'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('sphca_form_edit'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'scroll-popup'); ?>
	<a target="_blank" href="<?php echo sphca_FAV; ?>"><?php _e('click here', 'scroll-popup'); ?></a>
</p>
</div>