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
<div id="pushassist" class="content dashboard clearfix">
    <!-- Start Page Header -->
    <div class="page-header">
        <h1 class="title"><?php _e('Sent Notifications', 'push-notification-for-wp-by-pushassist');?></h1>
        <div class="sub_count">
            <a href="admin.php?page=pushassist-send-notifications"><?php _e('Send New Notification', 'push-notification-for-wp-by-pushassist');?></a>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Container Start -->
    <div class="container-widget clearfix">

        <!-- Project Stats Start -->
        <div class="col-md-12 col-lg-12">
            <div class="panel panel-widget">
                <div class="panel-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td>#</td>
                            <td><?php _e('Site', 'push-notification-for-wp-by-pushassist');?></td>
                            <td><?php _e('Message', 'push-notification-for-wp-by-pushassist');?></td>
                            <td><?php _e('Total Sent', 'push-notification-for-wp-by-pushassist');?></td>
                            <td><?php _e('Delivered', 'push-notification-for-wp-by-pushassist');?></td>
                            <td><?php _e('Unsubscribed', 'push-notification-for-wp-by-pushassist');?></td>
                            <td><?php _e('Clicked', 'push-notification-for-wp-by-pushassist');?></td>
                            <td><?php _e('Created Date', 'push-notification-for-wp-by-pushassist');?></td>
                            <td><?php _e('Is Campaign', 'push-notification-for-wp-by-pushassist');?></td>
                            <td><?php _e('Campaign Date', 'push-notification-for-wp-by-pushassist');?></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($notification_list) > 0) {

                            $no = 1;
                            foreach ($notification_list as $row) {
                                ?>

                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $row['siteurl']; ?></td>
                                    <td  style="width: 45%;">

                                        <div class="table_image">
                                            <img alt="Notification Logo"
                                                 src="<?php echo $row['logo']; ?>">
                                        </div>

                                        <div>
                                            <h5 class="margin-t-0"><?php echo str_replace("\\", "", stripslashes($row['title'])); ?></h5>
                                            <p class="margin-b-5"><?php echo str_replace("\\", "", stripslashes($row['message'])); ?></p>
                                            <a href="<?php echo $row['redirecturl']; ?>"
                                               target="_blank"><?php echo $row['redirecturl']; ?></a>
                                        </div>
                                    </td>
                                    <td><?php echo number_format($row['total_sent'] + $row['failed']); ?></td>
                                    <td><?php echo number_format($row['total_sent']); ?></td>
                                    <td><?php echo number_format($row['failed']); ?></td>
                                    <td>
                                        <?php
                                        echo number_format($row['total_clicked']);

                                        if ($row['total_sent'] != 0) {

                                            $percentChange = ($row['total_clicked'] / $row['total_sent']) * 100;
                                        } else {

                                            $percentChange = 0;
                                        }
                                        $percentChange = (int)$percentChange;
										
										if($percentChange >= 1){
                                        ?>
                                        <b class="color-up margin-l-15"> <?php echo $percentChange; ?>% </b>
										<?php } ?>
                                    </td>
                                    <td><?php echo date('M d, Y g:i A', strtotime($row['created_at'])); ?></td>
                                    <td><?php echo $row['is_campaign']; ?></td>
                                    <td><?php echo $row['campaign_datetime']; ?></td>

                                </tr>
                                <?php
                                $no++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="8" class="text-center">
                                    <?php
                                    if ($notification_list['error'] != '') {

                                        echo $notification_list['error'];
                                    } else { ?>
                                        <?php _e('No record found.', 'push-notification-for-wp-by-pushassist');?>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                        } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Project Stats End -->
    </div>
    <!-- Container End -->

</div>
<!-- Content End -->