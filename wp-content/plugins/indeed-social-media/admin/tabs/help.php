<?php 
$curl_active = (function_exists('curl_version')) ? TRUE : FALSE;
?>
<div class="metabox-holder indeed">
		<div class="stuffbox-ism">
			<?php 
				if (isset($_REQUEST['ism_save_licensing_code']) && isset($_REQUEST['ism_licensing_code'])){
					$proceed = ism_envato_licensing($_REQUEST['ism_licensing_code']);
				}
				$envato_code = get_option('ism_envato_code');
			?>
			<h3>
				<label style=" font-size:16px;">
					<?php _e('Activate Indeed Social Share & Locker Pro', 'ihc');?>
				</label>
			</h3>
			<form method="post" action="">
				<div class="inside">
					<?php if (!$curl_active): ?>
					<div class="iump-form-line iump-no-border" style="font-weight: bold; color: red;padding: 10px 0px 0px 5px;">cURL is disabled. You need to enable if for further activation request.</div>
					<?php endif;?>
					<div class="iump-form-line iump-no-border" style="width:10%;    padding: 10px 5px; float:left; box-sizing:border-box; text-align:right; font-weight:bold;">
						<label for="tag-name" class="ism-labels"><?php _e('Purchase Code', 'ihc');?></label>
					</div>	
					<div class="iump-form-line iump-no-border" style="width:70%;    padding: 10px 5px; float:left; box-sizing:border-box;">	
						<input name="ism_licensing_code" type="text" value="<?php echo $envato_code;?>" style="width:100%;"/>
					</div>
					<div class="ihc-stuffbox-submit-wrap iump-submit-form" style="width:20%;    padding: 10px 5px; float:right; box-sizing:border-box; text-align:center;">
						<input type="submit" value="<?php _e('Activate', 'ihc');?>" name="ism_save_licensing_code" class="button button-primary button-large" <?php if (!$curl_active) echo 'disabled';?> />
					</div>
					<div class="clear"></div>
					<div class="ism-license-status"><?php 
						if (isset($proceed)){
							if ($proceed){
								?>
								<div class="ism-dashboard-valid-license-code"><?php _e("You've activated the Indeed Social Share & Locker Pro plugin!")?></div>
								<?php 
							} else {
								?>
								<div class="ism-dashboard-err-license-code"><?php _e("You have entered an invalid purchase code or the Envato API could be down for a moment.")?></div>
								<?php 	
							}
						}
					?></div>
					<div style="padding:0 60px;">
					<p>A valid purchase code Activate the Full Version of<strong> Indeed Social Share & Locker Pro</strong> plugin and provides access on support system. A purchase code can only be used for <strong>ONE</strong> Indeed Social Share & Locker Pro for WordPress installation on <strong>ONE</strong> WordPress site at a time. If you previosly activated your purchase code on another website, then you have to get a <a href="http://codecanyon.net/item/social-share-locker-pro-wordpress-plugin/8137709?ref=azzaroco" target="_blank">new Licence</a>.</p>
					<h4>Where can I find my Purchase Code?</h4>
					<a href="http://codecanyon.net/item/social-share-locker-pro-wordpress-plugin/8137709?ref=azzaroco" target="_blank">
						<img src="<?php echo ISM_DIR_URL;?>admin/files/images/purchase_code.jpg" style="margin: 0 auto; display: block;"/>
						</a>
					</div>	
				</div>
			</form>		
		</div>
	<div class="stuffbox-ism">
		<h3>
			<label style="text-transform: uppercase; font-size:16px;">
				Contact Support
			</label>
		</h3>
		<div class="inside">
			<div class="submit" style="float:left; width:80%;">
				In order to contact Indeed support team you need to create a ticket providing all the necessary details via our support system: support.wpindeed.com
			</div>
			<div class="submit" style="float:left; width:20%; text-align:center;">
				<a href="http://support.wpindeed.com/open.php?topicId=12" target="_blank" class="button button-primary button-large"> Submit Ticket</a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="stuffbox-ism">
		<h3>
			<label style="text-transform: uppercase; font-size:16px;">
		    	Documentation
		    </label>
		</h3>
		<div class="inside">
			<iframe src="http://demoism.wpindeed.com/documentation/" width="100%" height="1000px" ></iframe>
		</div>
	</div>	
</div>
</div>
<?php 
