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
        <h1 class="title"><?php _e('Segment Details', 'push-notification-for-wp-by-pushassist');?></h1>
        <div class="sub_count">
            <a href="admin.php?page=pushassist-segments"><?php _e('Add New', 'push-notification-for-wp-by-pushassist');?></a>
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
                            <td><?php _e('Segment Name', 'push-notification-for-wp-by-pushassist');?></td>
                            <td><?php _e('Subscribers Count', 'push-notification-for-wp-by-pushassist');?></td>
                            <td><?php _e('Created Date', 'push-notification-for-wp-by-pushassist');?></td>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if (count($segment_list) > 0) {

                            $no =  1;

                            foreach ($segment_list as $row) {
                                ?>

                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['subscriber_count']; ?></td>
                                    <td><?php echo date('M d, Y ', strtotime($row['created_at'])); ?></td>
                                </tr>
                            <?php
                                $no++;
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="4" class="text-center">
                                <?php
                                if($segment_list['error'] != ''){

                                    echo $segment_list['error'];
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