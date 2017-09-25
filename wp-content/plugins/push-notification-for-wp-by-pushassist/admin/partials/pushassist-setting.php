<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://pushassist.com/
 * @since      2.2.4
 *
 * @package    Pushassist
 * @subpackage Pushassist/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<!-- Content Start -->
<div id="pushassist" class="content clearfix">
    <!-- Start Page Header -->
    <div class="page-header">
        <h1 class="title"><?php _e('Settings / Account Information', 'push-notification-for-wp-by-pushassist'); ?></h1>
    </div>
    <!-- End Page Header -->

    <?php if (isset($_REQUEST['response_message']) && $_REQUEST['response_message'] != '') { ?>
        <div class="margin-l-0 margin-b-20 updated notice notice-success is-dismissible">
            <p><?php echo $_REQUEST['response_message']; ?> </p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'push-notification-for-wp-by-pushassist');?></span>
            </button>
        </div>
    <?php } ?>

    <!-- Container Start -->
    <div class="container-widget clearfix">
        <div class="col-md-6">
            <div class="panel panel-default">

                <div class="panel-body">

                    <form class="form-horizontal" autocomplete="off" id="pushassist_template_setting_form"
                          name="pushassist_template_setting_form" enctype="multipart/form-data"
                          action="admin.php?page=pushassist-setting" method="post">

                        <div class="form-group">
                            <label class="col-sm-2 control-label form-label margin-r-5 padding-t-10"><?php _e('Ask for permission after', 'push-notification-for-wp-by-pushassist'); ?></label>

                            <input type="number" id="pushassist_timeinterval" name="pushassist_timeinterval"
                                   placeholder="<?php _e('Interval', 'push-notification-for-wp-by-pushassist'); ?>"
                                   min="0" style="width: 10%" max="30"
                                   maxlength="2" value="<?php echo $account_details['notification_interval']; ?>"/>
                            <label
                                class="control-label form-label margin-l-10 padding-t-0"> <?php _e('seconds on your website.', 'push-notification-for-wp-by-pushassist'); ?></label>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Opt-In Box Title', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pushassist_opt_in_title"
                                       id="pushassist_opt_in_title" value="<?php _e(stripslashes_deep($account_details['opt_in_title']), 'push-notification-for-wp-by-pushassist'); ?>"
                                       placeholder="<?php _e('Opt-In Box Title', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="80" required>
                                <span
                                    class="float-r"><?php _e('Limit 80 Characters', 'push-notification-for-wp-by-pushassist'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Opt-In Box Subtitle', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pushassist_opt_in_subtitle"
                                       id="pushassist_opt_in_subtitle" value="<?php _e(stripslashes_deep($account_details['opt_in_subtitle']), 'push-notification-for-wp-by-pushassist'); ?>"
                                       placeholder="<?php _e('Opt-In Box Subtitle', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="105" required>
                                <span
                                    class="float-r"><?php _e('Limit 105 Characters', 'push-notification-for-wp-by-pushassist'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Allow Button Text', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pushassist_allow_button_text"
                                       id="pushassist_allow_button_text" value="<?php _e(stripslashes_deep($account_details['allow_button']), 'push-notification-for-wp-by-pushassist'); ?>"
                                       placeholder="<?php _e('Allow Button Text', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="25" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Don\'t Allow Button', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pushassist_disallow_button_text"
                                       id="pushassist_disallow_button_text" value="<?php _e(stripslashes_deep($account_details['disallow_button']), 'push-notification-for-wp-by-pushassist'); ?>"
                                       placeholder="<?php _e('Don\'t Allow Button', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="25" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label form-label padding-l-0"><?php _e('Notification Template', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <select class="form-control col-sm-12" id="template" name="template">
                                    <?php

                                    $template = array('1' => 'Default', '2' => 'Template 1', '3' => 'Template 2', '4' => 'Template 3', '5' => 'Template 4', '6' => 'Template 5', '7' => 'Template 6', '8' => 'Template 7', '9' => 'Template 8'); //

                                    while (list($key, $val) = each($template)) {

                                    if ($key == $account_details['template']) {
                                         ?>
                                            <option value="<?php echo $key;  ?>" data-title="<?php echo $key; ?>"
                                                    selected> <?php echo $val;  ?></option>
                                        <?php } else {
                                             ?>
                                    <option data-title="<?php echo $key; ?>" value="<?php echo $key; ?>"> <?php echo $val; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label form-label"><?php _e('Location', 'push-notification-for-wp-by-pushassist'); ?></label>

                            <?php
                            $location = array('1' => 'Top Left', '2' => 'Top Right', '3' => 'Top Center', '4' => 'Bottom Left', '5' => 'Bottom Right', '6' => 'Bottom Center');
                            $location_2 = array('1' => 'Top Left', '2' => 'Top Right', '4' => 'Bottom Left', '5' => 'Bottom Right');
                            $location_3 = array('7' => 'Top', '8' => 'Bottom');
                            ?>

                            <input type="hidden" name="psa_template_location" id="psa_template_location" value="<?php if(isset($account_details['opt_in_location'])){ echo $account_details['opt_in_location']; } else { echo 1; } ?>">

                            <div class="col-sm-9" id="psa_list_1" style="display: <?php if($account_details['template'] < 7 ||  $account_details['template'] == 9 ||  $account_details['template'] == '1') { echo 'block'; } else { echo 'none'; }?>;">
                                <select class="form-control col-sm-12" id="location" name="location">

                                    <?php

                                    while (list($key, $val) = each($location)) {

                                        if ($key == $account_details['opt_in_location']) {
                                            ?>
                                            <option value="<?php echo $key;  ?>"
                                                    selected> <?php echo $val;  ?></option>
                                        <?php } else {
                                            ?>
                                            <option value="<?php echo $key; ?>"> <?php echo $val; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>

                            <div class="col-sm-9" id="psa_list_2" style="display: <?php if($account_details['template'] == 7) { echo 'block'; } else { echo 'none'; }?>;">
                                <select class="selectpicker col-sm-12" id="location_1" name="location_1">

                                    <?php

                                    while (list($key, $val) = each($location_2)) {

                                        if ($key == $account_details['opt_in_location']) {
                                            ?>
                                            <option value="<?php echo $key;  ?>"
                                                    selected> <?php echo $val;  ?></option>
                                        <?php } else {
                                            ?>
                                            <option value="<?php echo $key; ?>"> <?php echo $val; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>

                            <div class="col-sm-9" id="psa_list_3" style="display: <?php if($account_details['template'] == 8) { echo 'block'; } else { echo 'none'; }?>;">
                                <select class="selectpicker col-sm-12" id="location_2" name="location_2">

                                    <?php

                                    while (list($key, $val) = each($location_3)) {

                                        if ($key == $account_details['opt_in_location']) {
                                            ?>
                                            <option value="<?php echo $key;  ?>"
                                                    selected> <?php echo $val;  ?></option>
                                        <?php } else {
                                            ?>
                                            <option value="<?php echo $key; ?>"> <?php echo $val; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>

                        </div>

                        <div class="form-group margin-b-0">
                            <label for="focusedinput"
                                   class="col-sm-2 control-label form-label"><?php _e('Site Logo', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <span class="btn btn-success fileinput-button margin-b-10">
                                    <span><?php _e('Site Logo', 'push-notification-for-wp-by-pushassist'); ?></span>
                                    <input id="fileupload" type="file" name="pushassist_setting_fileupload"/>
                                </span>
                                <br/>
                                <span><?php _e('Image size must be exactly 256x256px.', 'push-notification-for-wp-by-pushassist'); ?> </span>
                            </div>
                        </div>

                        <hr>

                        <h5 class="col-sm-offset-2 title margin-t-0 margin-b-20"><?php _e('Notification Subscription Setting', 'push-notification-for-wp-by-pushassist'); ?></h5>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Opt-In Text', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pushassist_child_window_text"
                                       id="pushassist_child_window_text" value="<?php echo stripslashes_deep($account_details['child_text']); ?>"
                                       placeholder="<?php _e('Opt-In Text', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="100" required>
                                <span
                                    class="float-r"><?php _e('Limit 100 Characters', 'push-notification-for-wp-by-pushassist'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Opt-In Title', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pushassist_child_window_title"
                                       id="pushassist_child_window_title" value="<?php _e(stripslashes_deep($account_details['child_title']), 'push-notification-for-wp-by-pushassist'); ?>"
                                       placeholder="<?php _e('Opt-In Title', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="45" required>
                                <span
                                    class="float-r"><?php _e('Limit 45 Characters', 'push-notification-for-wp-by-pushassist'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Opt-In Message', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pushassist_child_window_message"
                                       id="pushassist_child_window_message" value="<?php _e(stripslashes_deep($account_details['child_message']), 'push-notification-for-wp-by-pushassist'); ?>"
                                       placeholder="<?php _e('Opt-In Message', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="73" required>
                                <span
                                    class="float-r"><?php _e('Limit 73 Characters', 'push-notification-for-wp-by-pushassist'); ?></span>
                            </div>
                        </div>

                        <hr>

                        <h5 class="col-sm-offset-2 title margin-t-0 margin-b-20"><?php _e('Welcome Message for first time subscribers', 'push-notification-for-wp-by-pushassist'); ?></h5>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Notification Title', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pushassist_setting_title"
                                       id="pushassist_setting_title" value="<?php _e(stripslashes_deep($account_details['title']), 'push-notification-for-wp-by-pushassist'); ?>"
                                       placeholder="<?php _e('Notification Title', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="45">
                                <span
                                    class="float-r"><?php _e('Limit 45 Characters', 'push-notification-for-wp-by-pushassist'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Notification Message', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pushassist_setting_message"
                                       id="pushassist_setting_message" value="<?php _e(stripslashes_deep($account_details['message']), 'push-notification-for-wp-by-pushassist'); ?>"
                                       placeholder="<?php _e('Notification Message', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="73">
                                <span
                                    class="float-r"><?php _e('Limit 73 Characters', 'push-notification-for-wp-by-pushassist'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Redirect URL', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pushassist_redirect_url"
                                       id="pushassist_redirect_url" value="<?php _e(stripslashes_deep($account_details['redirect_url']), 'push-notification-for-wp-by-pushassist'); ?>"
                                       placeholder="<?php _e('Redirect URL', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="250">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <input type="submit" class="btn btn-default"
                                       value="<?php _e('Save Settings', 'push-notification-for-wp-by-pushassist'); ?>"
                                       name="psa-advance-settings">
                            </div>
                        </div>

                    </form>

                    <hr>

                    <form class="form-horizontal" autocomplete="off" id="pushassist_setting_form"
                          name="pushassist_setting_form" enctype="multipart/form-data"
                          action="admin.php?page=pushassist-setting" method="post">

                        <div class="form-group">
                            <label class="col-sm-2 control-label form-label"></label>
                            <div class="col-sm-10">
                                <label class="form-label">
                                    <strong><?php _e('Auto Send Push Notifications', 'push-notification-for-wp-by-pushassist'); ?> </strong></<label
                                    class="form-label">
                                    <br/>
                                    <input type="checkbox" value="1" name="pushassist_auto_push"
                                           id="pushassist_auto_push" <?php checked(stripslashes_deep($pushassist_settings['psaAutoPush']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('When a Post is Published', 'push-notification-for-wp-by-pushassist'); ?> </label>
                                    <br/>
                                    <input type="checkbox" value="1" name="pushassist_edit_post_push"
                                           id="pushassist_edit_post_push" <?php checked(stripslashes_deep($pushassist_settings['psaEditPostPush']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('When a Post is Updated', 'push-notification-for-wp-by-pushassist'); ?> </label>
                                    <br/>
									<input type="checkbox" value="1" name="pushassist_logo_image"
                                           id="pushassist_logo_image" <?php checked(stripslashes_deep($pushassist_settings['psaPostLogoImage']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('Use Logo Image as Post Image', 'push-notification-for-wp-by-pushassist'); ?> </label>
                                    <br/>
									<input type="checkbox" value="1" name="pushassist_big_image"
                                           id="pushassist_big_image" <?php checked(stripslashes_deep($pushassist_settings['psaPostBigImage']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('Use Large Image', 'push-notification-for-wp-by-pushassist'); ?> </label>
                                    <br/>
									<input type="checkbox" value="1" name="pushassist_js_restrict"
                                           id="pushassist_js_restrict" <?php checked(stripslashes_deep($pushassist_settings['psaJsRestrict']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('Stop Automatic Script Inclusion. In That Case You Have to Manually Install our Script.', 'push-notification-for-wp-by-pushassist'); ?> </label>
                                    <br/>
                                    <input type="checkbox" value="1" name="pushassist_setting_is_utm_show"
                                           id="pushassist_setting_is_utm_show" <?php checked(stripslashes_deep($pushassist_settings['psaIsAutoPushUTM']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-10"><?php _e('Auto Push UTM Parameters', 'push-notification-for-wp-by-pushassist'); ?></label>

                            </div>

                            <label class="col-sm-2 control-label form-label"></label>
                            <div class="col-sm-9">
                                <span><?php _e('Notification Message When a Post is Published', 'push-notification-for-wp-by-pushassist'); ?></span>
                                <input type="text" value="<?php echo stripslashes_deep($pushassist_settings['psaPostMessage']); ?>" name="pushassist_setting_post_message" placeholder="<?php _e('Notification Message When a Post is Published', 'push-notification-for-wp-by-pushassist'); ?>" maxlength="138"
                                       id="pushassist_setting_post_message" class="form-control margin-t-10 clearfix" required/>
                            </div>

                        </div>

                        <div class="form-group" id="pushassist_setting_utm_parameter_div"
                             style="display: <?php if ($pushassist_settings['psaIsAutoPushUTM']) {
                                 echo 'block';
                             } else {
                                 echo 'none';
                             } ?>;">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('UTM Source', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9 margin-b-15">
                                <input type="text" class="form-control" id="pushassist_setting_utm_source"
                                       name="pushassist_setting_utm_source"
                                       value="<?php echo stripslashes_deep($pushassist_settings['psaUTMSource']); ?>"
                                       placeholder="<?php _e('Enter UTM Source', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="45"
                                       required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 45 Characters', 'push-notification-for-wp-by-pushassist'); ?></p>
                            </div>

                            <label
                                class="col-sm-2 control-label form-label"><?php _e('UTM Medium', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9 margin-b-15">
                                <input type="text" class="form-control" name="pushassist_setting_utm_medium"
                                       id="pushassist_setting_utm_medium"
                                       value="<?php echo stripslashes_deep($pushassist_settings['psaUTMMedium']); ?>"
                                       placeholder="<?php _e('Enter UTM Medium', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="73"
                                       required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 73 Characters', 'push-notification-for-wp-by-pushassist'); ?></p>
                            </div>

                            <label
                                class="col-sm-2 control-label form-label"><?php _e('UTM Campaign', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9 margin-b-5">
                                <input type="text" class="form-control" name="pushassist_setting_utm_campaign"
                                       id="pushassist_setting_utm_campaign"
                                       value="<?php echo stripslashes_deep($pushassist_settings['psaUTMCampaign']); ?>"
                                       placeholder="<?php _e('Enter UTM Campaign', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="500"
                                       required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 500 Characters', 'push-notification-for-wp-by-pushassist'); ?></p>
                            </div>
                        </div>
						
						<div class="form-group margin-b-0">
                            <label class="col-sm-2 control-label form-label"></label>
                            <div class="col-sm-10">
                                <label class="form-label">
                                    <strong><?php _e('Other Settings', 'push-notification-for-wp-by-pushassist'); ?> </strong></<label
                                    class="form-label">
                                    <br/>

                                    <input type="checkbox" value="1" name="pushassist_new_post_checked"
                                           id="pushassist_new_post_checked" <?php checked(stripslashes_deep($pushassist_settings['psaNewPostChecked']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('Autocheck Notification for New Posts', 'push-notification-for-wp-by-pushassist'); ?> </label>
                                    <br/>

                                    <input type="checkbox" value="1" name="pushassist_update_post_checked"
                                           id="pushassist_update_post_checked" <?php checked(stripslashes_deep($pushassist_settings['psaUpdatePostChecked']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('Autocheck Notification for Post Updates', 'push-notification-for-wp-by-pushassist'); ?> </label>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <input type="submit" class="btn btn-default"
                                       value="<?php _e('Save Settings', 'push-notification-for-wp-by-pushassist'); ?>"
                                       name="psa-save-settings">
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">

                    <p><strong><?php _e('What is a GCM Key? How do I get export my subscribers, What if I want to switch to other vendor.', 'push-notification-for-wp-by-pushassist'); ?></strong></p>
                    <p class="margin-b-15 margin-t-15"><?php _e('At the time of installation, you have to provide your GCM (Google Cloud Messaging) API Key for Chrome and Certificate Details for Safari that is used.', 'push-notification-for-wp-by-pushassist'); ?></p>
                    <p><?php _e('We need this information to export your subscriber’s ID’s. Please note that only premium accounts can export the subscribers.', 'push-notification-for-wp-by-pushassist'); ?></p>
                    <p class="margin-b-15 margin-t-15"> <?php _e('Please read', 'push-notification-for-wp-by-pushassist'); ?>
                        <a href="https://pushassist.com/knowledgebase/adding-your-own-fcm-key-sender-id-in-pushassist/"  style="color: #0000ff;"
                            target="_blank"> <?php _e('GCM registration', 'push-notification-for-wp-by-pushassist'); ?></a> <?php _e('guidelines here.', 'push-notification-for-wp-by-pushassist'); ?>
                    </p>

                    <form class="form-horizontal margin-t-40" autocomplete="off" id="pushassist_gcm_setting_form"
                          name="pushassist_gcm_setting_form" enctype="multipart/form-data"
                          action="admin.php?page=pushassist-setting" method="post">

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('GCM Project No.', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pushassist_gcm_project_no"
                                       id="pushassist_gcm_project_no" value="<?php _e(stripslashes_deep($account_details['gcm_project_number']), 'push-notification-for-wp-by-pushassist'); ?>"
                                       placeholder="<?php _e('GCM Project No.', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="20" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('GCM API Key', 'push-notification-for-wp-by-pushassist'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pushassist_gcm_api_key"
                                       id="pushassist_gcm_api_key" value="<?php _e(stripslashes_deep($account_details['gcm_api_key']), 'push-notification-for-wp-by-pushassist'); ?>"
                                       placeholder="<?php _e('GCM API Key', 'push-notification-for-wp-by-pushassist'); ?>"
                                       maxlength="250" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <input type="submit" class="btn btn-default"
                                       value="<?php _e('Save Settings', 'push-notification-for-wp-by-pushassist'); ?>"
                                       name="psa-gcm-settings">
                            </div>
                        </div>

                    </form>

                    <hr>

                    <p><?php _e('Screenshot of advance configurations that are possible with your PushAssist account.', 'push-notification-for-wp-by-pushassist'); ?>
                        &nbsp;&nbsp;&nbsp;
                        <a href="https://<?php echo $account_details['account_name']; ?>.pushassist.com/allsites/"
                           class="btn btn-default margin-t-0"
                           target="_blank"><?php _e('Customize Now', 'push-notification-for-wp-by-pushassist'); ?></a>
                    </p>

                    <div class="margin-t-15 image_wrapper">
                        <img src="<?php echo esc_url(PUSHASSIST_URL . 'images/pushassist_opt_in_box_setting.png'); ?>"
                             alt="<?php _e('Notification Opt-in Box Setting', 'push-notification-for-wp-by-pushassist'); ?>">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Container End -->
</div>
<!-- Content End -->
<script language="javascript">

    jQuery("#pushassist_setting_is_utm_show").on('click', function () {

        if (jQuery('#pushassist_setting_is_utm_show').is(':checked')) {

            jQuery('#pushassist_setting_utm_parameter_div').show('slow');

        } else {

            jQuery('#pushassist_setting_utm_parameter_div').hide('slow');

        }
    });

    jQuery("#template").on("change", function () {

        if(jQuery(this).val() == 8){

            jQuery('#psa_list_3').show();
            jQuery('#psa_list_2').hide();
            jQuery('#psa_list_1').hide();

            jQuery('#psa_template_location').val(jQuery('#location_2').val());

        }

        if(jQuery(this).val() == 7){

            jQuery('#psa_list_3').hide();
            jQuery('#psa_list_2').show();
            jQuery('#psa_list_1').hide();

            jQuery('#psa_template_location').val(jQuery('#location_1').val());

        }

        if(jQuery(this).val() < 7 || jQuery(this).val() == 9){

            jQuery('#psa_list_3').hide();
            jQuery('#psa_list_2').hide();
            jQuery('#psa_list_1').show();

            jQuery('#psa_template_location').val(jQuery('#location').val());
        }
    });

    jQuery("#location").on("change", function () {

        var template_location = jQuery(this).val();

        jQuery('#psa_template_location').val(template_location);
    });

    jQuery("#location_1").on("change", function () {

        var template_location = jQuery(this).val();

        jQuery('#psa_template_location').val(template_location);
    });

    jQuery("#location_2").on("change", function () {

        var template_location = jQuery(this).val();

        jQuery('#psa_template_location').val(template_location);
    });

</script>