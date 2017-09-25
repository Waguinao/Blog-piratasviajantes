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
        <h1 class="title"><?php _e('Date Based Campaign', 'push-notification-for-wp-by-pushassist'); ?></h1>
    </div>
    <!-- End Page Header -->

    <?php if (isset($_REQUEST['response_message']) && $_REQUEST['response_message'] != '') { ?>
        <div class="margin-l-0 margin-b-20 updated notice notice-success is-dismissible">
            <p><?php echo $_REQUEST['response_message']; ?> </p>
            <button type="button" class="notice-dismiss"><span
                    class="screen-reader-text"><?php _e('Dismiss this notice.', 'push-notification-for-wp-by-pushassist'); ?></span>
            </button>
        </div>
    <?php } ?>

    <!-- Container Start -->
    <div class="container-widget clearfix">
        <div class="col-md-6">
            <div class="panel panel-default">

                <div class="panel-body">

                    <?php if ($account_details['planType'] == 'Free') { ?>

                        <p class="margin-b-20"> <?php _e('Following screenshot shows how you can create and schedule a campaign.', 'push-notification-for-wp-by-pushassist'); ?>
                            <strong> <?php _e('This feature is available in premium plans.', 'push-notification-for-wp-by-pushassist'); ?></strong>
                        </p>
                        <p class="align-center margin-b-25">
                            <a href="https://<?php echo $account_details['account_name']; ?>.pushassist.com/campaign/"
                               class="btn btn-default margin-t-0"
                               target="_blank"><?php _e('Upgrade to Premium', 'push-notification-for-wp-by-pushassist'); ?></a>
                        </p>
                        <div class="margin-t-15 image_wrapper">
                            <img src="<?php echo esc_url(PUSHASSIST_URL . 'images/campaign_notification.png'); ?>"
                                 alt="<?php _e('Campaign Notification', 'push-notification-for-wp-by-pushassist'); ?>">
                        </div>

                    <?php } else { ?>

                        <!--   Campaign Form     -->

                        <form class="form-horizontal" autocomplete="off" id="create_pushassist_campaign_form"
                              name="create_pushassist_campaign_form" enctype="multipart/form-data"
                              action="admin.php?page=pushassist-campaigns" method="post">

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label form-label"><?php _e('Campaign Title', 'push-notification-for-wp-by-pushassist'); ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="pushassist_campaign_title"
                                           name="pushassist_campaign_title"
                                           placeholder="<?php _e('Campaign Title', 'push-notification-for-wp-by-pushassist'); ?>"
                                           maxlength="77" required="required"/>
                                    <p class="margin-b-0 align-right"><?php _e('Limit 77 Characters', 'push-notification-for-wp-by-pushassist'); ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label form-label"><?php _e('Campaign Message', 'push-notification-for-wp-by-pushassist'); ?></label>
                                <div class="col-sm-9">
                                <textarea class="form-control" rows="2" name="pushassist_campaign_message"
                                          id="pushassist_campaign_message"
                                          placeholder="<?php _e('Campaign Message', 'push-notification-for-wp-by-pushassist'); ?>"
                                          maxlength="138" required="required"
                                          style="resize: none"></textarea>
                                    <p class="margin-b-0 align-right"><?php _e('Limit 138 Characters', 'push-notification-for-wp-by-pushassist'); ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label form-label"><?php _e('Campaign URL', 'push-notification-for-wp-by-pushassist'); ?></label>
                                <div class="col-sm-9">
                                    <input type="url" class="form-control" id="pushassist_campaign_url"
                                           name="pushassist_campaign_url"
                                           placeholder="<?php _e('Enter a URL to push your subscribers to (yoursite.com)', 'push-notification-for-wp-by-pushassist'); ?>"
                                           maxlength="250"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label form-label"><?php _e('Campaign Date', 'push-notification-for-wp-by-pushassist'); ?></label>

                                <div class="col-sm-5 input-group date">
                                    <input class="form-control" type="text" readonly id="pushassist_campaign_date"
                                           name="pushassist_campaign_date"
                                           placeholder="<?php _e('Campaign Date', 'push-notification-for-wp-by-pushassist'); ?>">
                                    <span
                                        class="clearfix float-r"><?php _e('Date Format (YYYY-MM-DD HH:MM)', 'push-notification-for-wp-by-pushassist'); ?></span>
                                </div>

                            </div>

                            <div class="form-group margin-b-0">
                                <label for="focusedinput"
                                       class="col-sm-3 control-label form-label"><?php _e('Campaign Logo', 'push-notification-for-wp-by-pushassist'); ?></label>
                                <div class="col-sm-9">
                                <span class="btn btn-success fileinput-button margin-b-10">
                                    <span><?php _e('Campaign Logo', 'push-notification-for-wp-by-pushassist'); ?></span>
                                    <input id="fileupload" type="file" name="pushassist_campaign_fileupload"/>
                                </span>
                                    <span
                                        class="clearfix"><?php _e('Image size must be exactly 256x256px.', 'push-notification-for-wp-by-pushassist'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-offset-3 control-label form-label">
                                    <input type="checkbox" value="0" name="pushassist_campaign_is_utm_show"
                                           id="pushassist_campaign_is_utm_show"/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-10"><?php _e('Add UTM Parameters', 'push-notification-for-wp-by-pushassist'); ?></label>
                                </label>
                            </div>
                            <div class="form-group" id="pushassist_campaign_utm_parameter_div" style="display: none;">
                                <label
                                    class="col-sm-3 control-label form-label"><?php _e('UTM Source', 'push-notification-for-wp-by-pushassist'); ?></label>
                                <div class="col-sm-9 margin-b-15">
                                    <input type="text" class="form-control" id="pushassist_campaign_utm_source"
                                           name="pushassist_campaign_utm_source"
                                           value="pushassist"
                                           placeholder="<?php _e('Enter UTM Source', 'push-notification-for-wp-by-pushassist'); ?>"
                                           maxlength="45"
                                           required="required"/>
                                    <p class="margin-b-0 align-right"><?php _e('Limit 45 Characters', 'push-notification-for-wp-by-pushassist'); ?></p>
                                </div>

                                <label
                                    class="col-sm-3 control-label form-label"><?php _e('UTM Medium', 'push-notification-for-wp-by-pushassist'); ?></label>
                                <div class="col-sm-9 margin-b-15">
                                    <input type="text" class="form-control" name="pushassist_campaign_utm_medium"
                                           id="pushassist_campaign_utm_medium"
                                           value="pushassist_notification"
                                           placeholder="<?php _e('Enter UTM Medium', 'push-notification-for-wp-by-pushassist'); ?>"
                                           maxlength="73"
                                           required="required"/>
                                    <p class="margin-b-0 align-right"><?php _e('Limit 73 Characters', 'push-notification-for-wp-by-pushassist'); ?></p>
                                </div>

                                <label
                                    class="col-sm-3 control-label form-label"><?php _e('UTM Campaign', 'push-notification-for-wp-by-pushassist'); ?></label>
                                <div class="col-sm-9 margin-b-5">
                                    <input type="text" class="form-control" name="pushassist_campaign_utm_campaign"
                                           id="pushassist_campaign_utm_campaign"
                                           value="pushassist"
                                           placeholder="<?php _e('Enter UTM Campaign', 'push-notification-for-wp-by-pushassist'); ?>"
                                           maxlength="500"
                                           required="required"/>
                                    <p class="margin-b-0 align-right"><?php _e('Limit 500 Characters', 'push-notification-for-wp-by-pushassist'); ?></p>
                                </div>
                            </div>

                            <?php if (count($segment_list) > 0) { ?>

                                <div class="form-group">
                                    <label
                                        class="col-sm-3 control-label form-label"><?php _e('Segment', 'push-notification-for-wp-by-pushassist'); ?></label>
                                    <div class="col-sm-9">
                                        <select class="col-sm-12 form-control" id="pushassist_campaign_segment"
                                                name="pushassist_campaign_segment[]"
                                                multiple>
                                            <?php
                                            foreach ($segment_list as $row) {
                                                ?>
                                                <option
                                                    value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            <?php } ?>
							
							<?php if($account_details['timezone_list']) { ?>
							
							<div class="form-group">
								<label
									class="col-sm-3 control-label form-label"><?php _e('TimeZone', 'push-notification-for-wp-by-pushassist'); ?></label>
								<div class="col-sm-9">
									<select class="col-sm-12 form-control" id="pushassist_campaign_timezone"
											name="pushassist_campaign_timezone">
										<?php
										while (list($key, $val) = each($account_details['timezone_list'])) {

                                            if($val == $account_details['timezone']) {
                                                ?>
                                                <option selected
                                                    value="<?php echo $val; ?>"><?php echo $key; ?></option>
                                                <?php
                                            } else if($val == 'America/Los_Angeles' && empty($account_details['timezone'])){
                                                ?>
                                                <option selected
                                                        value="<?php echo $val; ?>"><?php echo $key; ?></option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value="<?php echo $val; ?>"><?php echo $key; ?></option>
                                            <?php
                                            }
										}
										?>
									</select>
								</div>
							</div>
							
							<?php } ?>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-1">
                                    <input type="submit" class="btn btn-default"
                                           value="<?php _e('Create Campaign', 'push-notification-for-wp-by-pushassist'); ?>">
                                </div>

                            </div>
                        </form>

                    <?php } ?>

                </div>
            </div>
        </div>

        <?php if ($account_details['planType'] == 'Paid') { ?>

            <div class="col-md-6 dummy-notification shadow panel panel-default">
                <p class="h4 pb15"><?php _e('Preview', 'push-notification-for-wp-by-pushassist'); ?></p>

                <div class="widget shadow dummy-notification-inner-wrapper">
                    <div class="wrapper">

                        <div class="img_wrapper pull-left">
                            <img id="pushassist_preview_logo" src="<?php echo $account_details['site_image']; ?>"
                                 class="img-responsive">
                        </div>

                        <div class="text_wrapper pull-left">
                            <div class="title">
                                <div class="title_txt pull-left" id="pushassist_preview_campaign_title">
                                    <?php _e('Campaign Title', 'push-notification-for-wp-by-pushassist'); ?>
                                </div>
                                <div class="closer pull-right">
                                    x
                                </div>
                            </div>
                            <div class="message" id="pushassist_preview_campaign_message">
                                <?php _e('Campaign Message', 'push-notification-for-wp-by-pushassist'); ?>
                            </div>

                            <div class="domain">
                                <div class="domain">
                                    <?php echo $account_details['account_name']; ?><?php _e('.pushassist.com', 'push-notification-for-wp-by-pushassist'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="redirect_url">
                    <p id="pushassist_campaign_redirect_url"
                       class="h5"><?php _e('URL to open when user clicks the campaign:', 'push-notification-for-wp-by-pushassist'); ?></p>
                </div>
            </div>

        <?php } ?>

    </div>
    <!-- Container End -->
</div>
<!-- Content End -->

<script language="javascript">

    var utm_source = jQuery('#pushassist_campaign_utm_source').val(), utm_medium = jQuery('#pushassist_campaign_utm_medium').val(), utm_campaign = jQuery('#pushassist_campaign_utm_campaign').val(), url = "", title = "", message = "";

    jQuery("#pushassist_campaign_is_utm_show").on('click', function () {

        if (jQuery('#pushassist_campaign_is_utm_show').is(':checked')) {

            jQuery('#pushassist_campaign_is_utm_show').val(1);

            jQuery('#pushassist_campaign_utm_parameter_div').show('slow');

            if (url == "") {

                jQuery('#pushassist_campaign_redirect_url').text('<?php _e('URL to open when user clicks the campaign:', 'push-notification-for-wp-by-pushassist');?>');
            } else {

                jQuery('#pushassist_campaign_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
            }

        } else {

            jQuery('#pushassist_campaign_is_utm_show').val(0);

            jQuery('#pushassist_campaign_utm_parameter_div').hide('slow');

            if (url == "") {

                jQuery('#pushassist_campaign_redirect_url').text('<?php _e('URL to open when user clicks the campaign:', 'push-notification-for-wp-by-pushassist');?>');
            } else {

                jQuery('#pushassist_campaign_redirect_url').text(url);
            }
        }
    });

    jQuery("#pushassist_campaign_title").keyup(function () {

        title = jQuery('#pushassist_campaign_title').val();

        if (title != "") {

            jQuery('#pushassist_preview_campaign_title').text(title);
        }
        else {
            jQuery('#pushassist_preview_campaign_title').text('<?php _e('Campaign Title', 'push-notification-for-wp-by-pushassist');?>');
        }
    });

    jQuery("#pushassist_campaign_message").keyup(function () {

        message = jQuery('#pushassist_campaign_message').val();

        if (message != "") {

            jQuery('#pushassist_preview_campaign_message').text(message);
        }
        else {

            jQuery('#pushassist_preview_campaign_message').text('<?php _e('Campaign Message', 'push-notification-for-wp-by-pushassist');?>');
        }
    });

    jQuery('#pushassist_campaign_utm_source').keyup(function () {

        var utm_source = jQuery('#pushassist_campaign_utm_source').val(), utm_medium = jQuery('#pushassist_campaign_utm_medium').val(), utm_campaign = jQuery('#pushassist_campaign_utm_campaign').val();

        var url = jQuery('#pushassist_campaign_url').val();

        if (url !== '') {

            jQuery('#pushassist_campaign_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#pushassist_campaign_utm_source').blur(function () {

        var utm_source = jQuery('#pushassist_campaign_utm_source').val(), utm_medium = jQuery('#pushassist_campaign_utm_medium').val(), utm_campaign = jQuery('#pushassist_campaign_utm_campaign').val();

        var url = jQuery('#pushassist_campaign_url').val();

        if (url !== '') {

            jQuery('#pushassist_campaign_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#pushassist_campaign_utm_medium').keyup(function () {

        var utm_source = jQuery('#pushassist_campaign_utm_source').val(), utm_medium = jQuery('#pushassist_campaign_utm_medium').val(), utm_campaign = jQuery('#pushassist_campaign_utm_campaign').val();

        var url = jQuery('#pushassist_campaign_url').val();

        if (url !== '') {

            jQuery('#pushassist_campaign_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#pushassist_campaign_utm_medium').blur(function () {

        var utm_source = jQuery('#pushassist_campaign_utm_source').val(), utm_medium = jQuery('#pushassist_campaign_utm_medium').val(), utm_campaign = jQuery('#pushassist_campaign_utm_campaign').val();

        var url = jQuery('#pushassist_campaign_url').val();

        if (url !== '') {

            jQuery('#pushassist_campaign_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#pushassist_campaign_utm_campaign').keyup(function () {

        var utm_source = jQuery('#pushassist_campaign_utm_source').val(), utm_medium = jQuery('#pushassist_campaign_utm_medium').val(), utm_campaign = jQuery('#pushassist_campaign_utm_campaign').val();

        var url = jQuery('#pushassist_campaign_url').val();

        if (url !== '') {

            jQuery('#pushassist_campaign_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#pushassist_campaign_utm_campaign').blur(function () {

        var utm_source = jQuery('#pushassist_campaign_utm_source').val(), utm_medium = jQuery('#pushassist_campaign_utm_medium').val(), utm_campaign = jQuery('#pushassist_campaign_utm_campaign').val();

        var url = jQuery('#pushassist_campaign_url').val();

        if (url !== '') {

            jQuery('#pushassist_campaign_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery("#pushassist_campaign_title").blur(function () {

        title = jQuery('#pushassist_campaign_title').val();

        if (title != "") {

            jQuery('#pushassist_preview_campaign_title').text(title);
        }
        else {
            jQuery('#pushassist_preview_campaign_title').text('<?php _e('Campaign Title', 'push-notification-for-wp-by-pushassist');?>');
        }
    });

    jQuery("#pushassist_campaign_message").blur(function () {

        message = jQuery('#pushassist_campaign_message').val();

        if (message != "") {

            jQuery('#pushassist_preview_campaign_message').text(message);
        }
        else {

            jQuery('#pushassist_preview_campaign_message').text('<?php _e('Campaign Message', 'push-notification-for-wp-by-pushassist');?>');
        }
    });

    jQuery('#pushassist_campaign_url').keyup(function () {

        var utm_source = jQuery('#pushassist_campaign_utm_source').val(), utm_medium = jQuery('#pushassist_campaign_utm_medium').val(), utm_campaign = jQuery('#pushassist_campaign_utm_campaign').val();

        var url = jQuery('#pushassist_campaign_url').val();

        is_utm_show = jQuery('#pushassist_campaign_is_utm_show').val();

        if (url != "" && is_utm_show == 0) {

            jQuery('#pushassist_campaign_redirect_url').text(url);

        } else if (url != "" && is_utm_show == 1) {

            jQuery('#pushassist_campaign_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
        else {
            jQuery('#pushassist_campaign_redirect_url').text('<?php _e('URL to open when user clicks the campaign:', 'push-notification-for-wp-by-pushassist');?>');
        }
    });

    jQuery("#pushassist_campaign_url").blur(function () {

        var utm_source = jQuery('#pushassist_campaign_utm_source').val(), utm_medium = jQuery('#pushassist_campaign_utm_medium').val(), utm_campaign = jQuery('#pushassist_campaign_utm_campaign').val();

        url = jQuery('#pushassist_campaign_url').val();

        is_utm_show = jQuery('#pushassist_campaign_is_utm_show').val();

        if (url != "" && is_utm_show == 0) {

            jQuery('#pushassist_campaign_redirect_url').text(url);

        } else if (url != "" && is_utm_show == 1) {

            jQuery('#pushassist_campaign_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
        else {
            jQuery('#pushassist_campaign_redirect_url').text('<?php _e('URL to open when user clicks the campaign:', 'push-notification-for-wp-by-pushassist');?>');
        }
    });

    jQuery(function () {
        jQuery('*[name=pushassist_campaign_date]').appendDtpicker({
            "inline": false,
            "minuteInterval": 10
        });
    });

</script>
