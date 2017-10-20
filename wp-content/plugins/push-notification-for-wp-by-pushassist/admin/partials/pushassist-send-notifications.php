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
        <h1 class="title"><?php _e('New Notification', 'push-notification-for-wp-by-pushassist');?></h1>
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
                    <form class="form-horizontal" autocomplete="off" id="send_notification_form"
                          name="send_notification_form" enctype="multipart/form-data"
                          action="admin.php?page=pushassist-send-notifications" method="post">

                        <div class="form-group">
                            <label class="col-sm-3 control-label form-label"><?php _e('Notification Title', 'push-notification-for-wp-by-pushassist');?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="pushassist_notification_title" name="pushassist_notification_title"
                                       placeholder="<?php _e('Notification Title', 'push-notification-for-wp-by-pushassist');?>" maxlength="77" required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 77 Characters', 'push-notification-for-wp-by-pushassist');?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label form-label"><?php _e('Notification Message', 'push-notification-for-wp-by-pushassist');?></label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="2" name="pushassist_notification_message" id="pushassist_notification_message"
                                          placeholder="<?php _e('Notification Message', 'push-notification-for-wp-by-pushassist');?>" maxlength="138" required="required"
                                          style="resize: none"></textarea>
                                <p class="margin-b-0 align-right"><?php _e('Limit 138 Characters', 'push-notification-for-wp-by-pushassist');?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label form-label"><?php _e('Notification URL', 'push-notification-for-wp-by-pushassist');?></label>
                            <div class="col-sm-9">
                                <input type="url" class="form-control" id="pushassist_notification_url" name="pushassist_notification_url"
                                       placeholder="<?php _e('Enter a URL to push your subscribers to (yoursite.com)', 'push-notification-for-wp-by-pushassist');?>"
                                       maxlength="250"/>
                            </div>
                        </div>

                        <div class="form-group margin-b-0">
                            <label for="focusedinput" class="col-sm-3 control-label form-label"><?php _e('Notification Logo', 'push-notification-for-wp-by-pushassist');?></label>
                            <div class="col-sm-9">
                                <span class="btn btn-success fileinput-button margin-b-10">
                                    <span><?php _e('Notification Logo', 'push-notification-for-wp-by-pushassist');?></span>
                                    <input id="fileupload" type="file" name="pushassist_notification_fileupload"/>
                                </span>
                                <span class="clearfix"><?php _e('Image size must be exactly 256x256px.', 'push-notification-for-wp-by-pushassist');?></span>
                            </div>
                        </div>
						<div class="form-group margin-b-0">
                            <label class="col-sm-offset-3 control-label form-label">
                                <input type="checkbox" value="1" name="pushassist_is_big_image" id="pushassist_is_big_image"/>
                                <label class="form-label checkbox_title margin-l-10 margin-t-10"><?php _e('Use Large Image', 'push-notification-for-wp-by-pushassist');?></label>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-offset-3 control-label form-label">
                                <input type="checkbox" value="0" name="pushassist_notification_is_utm_show" id="pushassist_notification_is_utm_show"/>
                                <label class="form-label checkbox_title margin-l-10 margin-t-10"><?php _e('Add UTM Parameters', 'push-notification-for-wp-by-pushassist');?></label>
                            </label>
                        </div>
                        <div class="form-group" id="pushassist_notification_utm_parameter_div" style="display: none;">
                            <label class="col-sm-3 control-label form-label"><?php _e('UTM Source', 'push-notification-for-wp-by-pushassist');?></label>
                            <div class="col-sm-9 margin-b-15">
                                <input type="text" class="form-control" id="pushassist_notification_utm_source" name="pushassist_notification_utm_source"
                                       value="pushassist" placeholder="<?php _e('Enter UTM Source', 'push-notification-for-wp-by-pushassist');?>" maxlength="45"
                                       required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 45 Characters', 'push-notification-for-wp-by-pushassist');?></p>
                            </div>

                            <label class="col-sm-3 control-label form-label"><?php _e('UTM Medium', 'push-notification-for-wp-by-pushassist');?></label>
                            <div class="col-sm-9 margin-b-15">
                                <input type="text" class="form-control" name="pushassist_notification_utm_medium" id="pushassist_notification_utm_medium"
                                       value="pushassist_notification" placeholder="<?php _e('Enter UTM Medium', 'push-notification-for-wp-by-pushassist');?>" maxlength="73"
                                       required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 73 Characters', 'push-notification-for-wp-by-pushassist');?></p>
                            </div>

                            <label class="col-sm-3 control-label form-label"><?php _e('UTM Campaign', 'push-notification-for-wp-by-pushassist');?></label>
                            <div class="col-sm-9 margin-b-5">
                                <input type="text" class="form-control" name="pushassist_notification_utm_campaign" id="pushassist_notification_utm_campaign"
                                       value="pushassist" placeholder="<?php _e('Enter UTM Campaign', 'push-notification-for-wp-by-pushassist');?>" maxlength="500"
                                       required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 500 Characters', 'push-notification-for-wp-by-pushassist');?></p>
                            </div>
                        </div>

                        <?php if (count($segment_list) > 0) { ?>

                            <div class="form-group">
                                <label class="col-sm-3 control-label form-label"><?php _e('Segment', 'push-notification-for-wp-by-pushassist');?></label>
                                <div class="col-sm-9">
                                    <select class="col-sm-12 form-control" id="pushassist_notification_segment" name="pushassist_notification_segment[]"
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

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-1">
                                <input type="submit" class="btn btn-default" value="<?php _e('Send', 'push-notification-for-wp-by-pushassist');?>">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 dummy-notification shadow panel panel-default">
            <p class="h4 pb15"><?php _e('Preview', 'push-notification-for-wp-by-pushassist');?></p>

            <div class="widget shadow dummy-notification-inner-wrapper">
                <div class="wrapper">

                    <div class="img_wrapper pull-left">
                        <img id="pushassist_preview_logo" src="<?php echo $account_details['site_image'];?>"
                             class="img-responsive">
                    </div>

                    <div class="text_wrapper pull-left">
                        <div class="title">
                            <div class="title_txt pull-left" id="pushassist_preview_notification_title">
                                <?php _e('Notification Title', 'push-notification-for-wp-by-pushassist');?>
                            </div>
                            <div class="closer pull-right">
                                x
                            </div>
                        </div>
                        <div class="message" id="pushassist_preview_notification_message">
                            <?php _e('Notification Message', 'push-notification-for-wp-by-pushassist');?>
                        </div>

                        <div class="domain">
                            <div class="domain">
                                <?php echo $account_details['account_name'];?><?php _e('.pushassist.com', 'push-notification-for-wp-by-pushassist');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="redirect_url">
                <p id="pushassist_notification_redirect_url" class="h5"><?php _e('URL to open when user clicks the notification:', 'push-notification-for-wp-by-pushassist');?></p>
            </div>
        </div>

    </div>
    <!-- Container End -->
</div>
<!-- Content End -->

<script language="javascript">

    var  utm_source = jQuery('#pushassist_notification_utm_source').val(), utm_medium = jQuery('#pushassist_notification_utm_medium').val(), utm_campaign = jQuery('#pushassist_notification_utm_campaign').val(), url = "", title = "", message = "";

    jQuery("#pushassist_notification_is_utm_show").on('click', function () {

        if (jQuery('#pushassist_notification_is_utm_show').is(':checked')) {

            jQuery('#pushassist_notification_is_utm_show').val(1);

            jQuery('#pushassist_notification_utm_parameter_div').show('slow');

            if (url == "") {

                jQuery('#pushassist_notification_redirect_url').text('<?php _e('URL to open when user clicks the notification:', 'push-notification-for-wp-by-pushassist');?>');
            } else {

                jQuery('#pushassist_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
            }

        } else {

            jQuery('#pushassist_notification_is_utm_show').val(0);

            jQuery('#pushassist_notification_utm_parameter_div').hide('slow');

            if (url == "") {

                jQuery('#pushassist_notification_redirect_url').text('<?php _e('URL to open when user clicks the notification:', 'push-notification-for-wp-by-pushassist');?>');
            } else {

                jQuery('#pushassist_notification_redirect_url').text(url);
            }
        }
    });

    jQuery("#pushassist_notification_title").keyup(function () {

        title = jQuery('#pushassist_notification_title').val();

        if (title != "") {

            jQuery('#pushassist_preview_notification_title').text(title);
        }
        else {
            jQuery('#pushassist_preview_notification_title').text('<?php _e('Notification Title', 'push-notification-for-wp-by-pushassist');?>');
        }
    });

    jQuery("#pushassist_notification_message").keyup(function () {

        message = jQuery('#pushassist_notification_message').val();

        if (message != "") {

            jQuery('#pushassist_preview_notification_message').text(message);
        }
        else {

            jQuery('#pushassist_preview_notification_message').text('<?php _e('Notification Message', 'push-notification-for-wp-by-pushassist');?>');
        }
    });

    jQuery('#pushassist_notification_utm_source').keyup(function () {

        var  utm_source = jQuery('#pushassist_notification_utm_source').val(), utm_medium = jQuery('#pushassist_notification_utm_medium').val(), utm_campaign = jQuery('#pushassist_notification_utm_campaign').val();

        var url = jQuery('#pushassist_notification_url').val();

        if(url !== '') {

            jQuery('#pushassist_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#pushassist_notification_utm_source').blur(function () {

        var  utm_source = jQuery('#pushassist_notification_utm_source').val(), utm_medium = jQuery('#pushassist_notification_utm_medium').val(), utm_campaign = jQuery('#pushassist_notification_utm_campaign').val();

        var url = jQuery('#pushassist_notification_url').val();

        if(url !== '') {

            jQuery('#pushassist_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#pushassist_notification_utm_medium').keyup(function () {

        var  utm_source = jQuery('#pushassist_notification_utm_source').val(), utm_medium = jQuery('#pushassist_notification_utm_medium').val(), utm_campaign = jQuery('#pushassist_notification_utm_campaign').val();

        var url = jQuery('#pushassist_notification_url').val();

        if(url !== '') {

            jQuery('#pushassist_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#pushassist_notification_utm_medium').blur(function () {

        var  utm_source = jQuery('#pushassist_notification_utm_source').val(), utm_medium = jQuery('#pushassist_notification_utm_medium').val(), utm_campaign = jQuery('#pushassist_notification_utm_campaign').val();

        var url = jQuery('#pushassist_notification_url').val();

        if(url !== '') {

            jQuery('#pushassist_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#pushassist_notification_utm_campaign').keyup(function () {

        var  utm_source = jQuery('#pushassist_notification_utm_source').val(), utm_medium = jQuery('#pushassist_notification_utm_medium').val(), utm_campaign = jQuery('#pushassist_notification_utm_campaign').val();

        var url = jQuery('#pushassist_notification_url').val();

        if(url !== '') {

            jQuery('#pushassist_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#pushassist_notification_utm_campaign').blur(function () {

        var  utm_source = jQuery('#pushassist_notification_utm_source').val(), utm_medium = jQuery('#pushassist_notification_utm_medium').val(), utm_campaign = jQuery('#pushassist_notification_utm_campaign').val();

        var url = jQuery('#pushassist_notification_url').val();

        if(url !== '') {

            jQuery('#pushassist_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery("#pushassist_notification_title").blur(function () {

        title = jQuery('#pushassist_notification_title').val();

        if (title != "") {

            jQuery('#pushassist_preview_notification_title').text(title);
        }
        else {
            jQuery('#pushassist_preview_notification_title').text('<?php _e('Notification Title', 'push-notification-for-wp-by-pushassist');?>');
        }
    });

    jQuery("#pushassist_notification_message").blur(function () {

        message = jQuery('#pushassist_notification_message').val();

        if (message != "") {

            jQuery('#pushassist_preview_notification_message').text(message);
        }
        else {

            jQuery('#pushassist_preview_notification_message').text('<?php _e('Notification Message', 'push-notification-for-wp-by-pushassist');?>');
        }
    });

    jQuery('#pushassist_notification_url').keyup(function () {

        var  utm_source = jQuery('#pushassist_notification_utm_source').val(), utm_medium = jQuery('#pushassist_notification_utm_medium').val(), utm_campaign = jQuery('#pushassist_notification_utm_campaign').val();

        var url = jQuery('#pushassist_notification_url').val();

        is_utm_show = jQuery('#pushassist_notification_is_utm_show').val();

        if (url != "" && is_utm_show == 0) {

            jQuery('#pushassist_notification_redirect_url').text(url);

        } else if (url != "" && is_utm_show == 1) {

            jQuery('#pushassist_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
        else {
            jQuery('#pushassist_notification_redirect_url').text('<?php _e('URL to open when user clicks the notification:', 'push-notification-for-wp-by-pushassist');?>');
        }
    });

    jQuery("#pushassist_notification_url").blur(function () {

        var  utm_source = jQuery('#pushassist_notification_utm_source').val(), utm_medium = jQuery('#pushassist_notification_utm_medium').val(), utm_campaign = jQuery('#pushassist_notification_utm_campaign').val();

        url = jQuery('#pushassist_notification_url').val();

        is_utm_show = jQuery('#pushassist_notification_is_utm_show').val();

        if (url != "" && is_utm_show == 0) {

            jQuery('#pushassist_notification_redirect_url').text(url);

        } else if (url != "" && is_utm_show == 1) {

            jQuery('#pushassist_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
        else {
            jQuery('#pushassist_notification_redirect_url').text('<?php _e('URL to open when user clicks the notification:', 'push-notification-for-wp-by-pushassist');?>');
        }
    });

</script>