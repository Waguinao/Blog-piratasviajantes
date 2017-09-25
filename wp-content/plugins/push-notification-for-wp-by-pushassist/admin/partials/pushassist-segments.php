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
<div id="pushassist" class="content clearfix">
    <!-- Start Page Header -->

    <div class="page-header">
        <h1 class="title"><?php _e('Create Segment', 'push-notification-for-wp-by-pushassist');?></h1>
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
                    <form class="form-horizontal" autocomplete="off" id="segment_form"
                          name="segment_form" action="admin.php?page=pushassist-segments" method="post">

                        <div class="form-group">
                            <label class="col-sm-3 control-label form-label"><?php _e('Segment Name', 'push-notification-for-wp-by-pushassist');?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="pushassist_segment_name"
                                       name="pushassist_segment_name"
                                       placeholder="<?php _e('Segment Name', 'push-notification-for-wp-by-pushassist');?>" maxlength="40" required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 40 Characters. E.g. Google', 'push-notification-for-wp-by-pushassist');?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label form-label"></label>
                            <div class="">
                                <input type="submit" class="margin-l-5 btn btn-default" value="<?php _e('Create Segment', 'push-notification-for-wp-by-pushassist');?>">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 dummy-notification shadow panel panel-default">

            <p class="h5 pb15"><strong><?php _e('How to Implement Segments for your Push Notification Subscribers', 'push-notification-for-wp-by-pushassist');?></strong></p>

            <div class="widget shadow dummy-notification-inner-wrapper pb15">
                <p><strong><?php _e('Step 1 ', 'push-notification-for-wp-by-pushassist');?> : </strong> <?php _e('Create a new segment. Go to Create Segments', 'push-notification-for-wp-by-pushassist');?></p>

                <p><strong><?php _e('Step 2', 'push-notification-for-wp-by-pushassist');?> :</strong> <?php _e('Copy the following JavaScript code and paste it on your site page(s).', 'push-notification-for-wp-by-pushassist');?> </p>

                <p class="margin-t-20"><strong> <?php _e('Subscribe for Single Segment', 'push-notification-for-wp-by-pushassist');?> </strong></p>
                <p>
                    &lt;script&gt;
                    <br/>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; var _pa = [];<br/>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; _pa.push('segmentname');
                    <br/>
                    &lt;/script&gt;
                </p>

                <p class="margin-t-20"><strong><?php _e('Subscribe for Multiple Segments', 'push-notification-for-wp-by-pushassist');?></strong></p>
                <p>
                    &lt;script&gt;
                    <br/>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; var _pa = [];<br/>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; _pa.push('segmentname1', 'segmentname2');
                    <br/>
                    &lt;/script&gt;
                </p>
            </div>
        </div>
    </div>
</div>
