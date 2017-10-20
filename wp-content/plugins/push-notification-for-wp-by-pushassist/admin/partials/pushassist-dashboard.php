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
        <h1 class="title"><?php _e('Dashboard', 'push-notification-for-wp-by-pushassist');?></h1>
        <div class="sub_count"><span><?php echo number_format($account_details['subscribers_remain']);?> <?php _e('subscribers left', 'push-notification-for-wp-by-pushassist');?></span>
            <a href="https://<?php echo $account_details['account_name']; ?>.pushassist.com/dashboard/" target="_blank"><?php _e('Upgrade to Premium', 'push-notification-for-wp-by-pushassist');?></a>
        </div>
    </div>
    <!-- End Page Header -->

    <?php if (isset($_REQUEST['response_message']) && $_REQUEST['response_message'] != '') { ?>
        <div class="updated notice notice-success is-dismissible margin-l-0 margin-r-0">
			<p style='font-size: 15px; margin:15px 0px;'><?php echo $_REQUEST['response_message']; ?> </p>
		</div>
		<div class="clearfix"></div>
    <?php } ?>

    <!-- Container Start -->
    <div class="container-widget clearfix">
        <!-- Top Stats Start -->
        <div class="col-md-12">
            <ul class="topstats clearfix">
                <li class="col-xs-6 col-lg-2">
                    <span class="title"><i class="fa fa-send"></i> <?php _e('Total Delivered', 'push-notification-for-wp-by-pushassist');?></span>
                    <h3><?php echo number_format($dashboard_info['total_delivered']); ?></h3>

						<span class="diff">
						<?php if ($dashboard_info['delivered_change'] == 'negative') { ?>
                            <b class="color-down"><i class="fa fa-caret-down"></i>
                                <?php }
                                if ($dashboard_info['delivered_change'] == 'positive') { ?>
                                <b class="color-up"><i class="fa fa-caret-up"></i>
                                    <?php } ?>

                                    <?php echo $dashboard_info['delivered_percentage']; ?>%
                                </b> <?php _e('from last week', 'push-notification-for-wp-by-pushassist');?></span>
                </li>

                <li class="col-xs-6 col-lg-2">
                    <span class="title"><i class="fa fa-check-square-o"></i> <?php _e('Total Clicks', 'push-notification-for-wp-by-pushassist');?></span>
                    <h3 class="color-up"><?php echo number_format($dashboard_info['total_clicks']); ?></h3>

                        <span class="diff">
                            <?php if ($dashboard_info['clicks_change'] == 'negative') { ?>
                            <b class="color-down"><i class="fa fa-caret-down"></i>
                                <?php } if ($dashboard_info['clicks_change'] == 'positive') { ?>
                                <b class="color-up"><i class="fa fa-caret-up"></i>
                                    <?php } ?>
                                    <?php echo $dashboard_info['clicks_percentage']; ?>%
                                </b> <?php _e('from last week', 'push-notification-for-wp-by-pushassist');?></span>
                </li>

               <li class="col-xs-6 col-lg-2">
                    <span class="title"><i class="fa fa-bell"></i> <?php _e('Active Subscribers', 'push-notification-for-wp-by-pushassist');?></span>
                    <h3><?php echo number_format($dashboard_info['active_subscribers']); ?></h3>

                        <span class="diff">
                            <?php if ($dashboard_info['active_subscribers_change'] == 'negative') { ?>
                            <b class="color-down"><i class="fa fa-caret-down"></i>
                                <?php } if ($dashboard_info['active_subscribers_change'] == 'positive') { ?>
                                <b class="color-up"><i class="fa fa-caret-up"></i>
                                    <?php } ?>
                                    <?php echo $dashboard_info['active_subscribers_percentage']; ?>%
                                </b> <?php _e('from last week', 'push-notification-for-wp-by-pushassist');?></span>
                </li>
				
				<li class="col-xs-6 col-lg-2">
                    <span class="title"><i class="fa fa-bell-slash"></i> <?php _e('Unsubscribed', 'push-notification-for-wp-by-pushassist');?></span>
                    <h3><?php echo number_format($dashboard_info['unsubscribed']); ?></h3>

                        <span class="diff">
                            <?php if ($dashboard_info['unsubscribed_change'] == 'negative') { ?>
                            <b class="color-up"><i class="fa fa-caret-up"></i>
                                <?php } if ($dashboard_info['unsubscribed_change'] == 'positive') { ?>
                                <b class="color-down"><i class="fa fa-caret-down"></i>
                                    <?php } ?>
                                    <?php echo $dashboard_info['unsubscribed_percentage']; ?>%
                                </b> <?php _e('from last week', 'push-notification-for-wp-by-pushassist');?></span>
                </li>

                <li class="col-xs-6 col-lg-2">
                    <span class="title"><i class="fa  fa-cogs"></i> <?php _e('Campaigns', 'push-notification-for-wp-by-pushassist');?></span>
                    <h3 class="color-up"><?php echo number_format($dashboard_info['campaign_count']); ?></h3>
                    <span class="diff"><b class="color-down"></b> <?php _e('active this week', 'push-notification-for-wp-by-pushassist');?></span>
                </li>

                <li class="col-xs-6 col-lg-2">
                    <span class="title"><i class="fa fa-send"></i> <?php _e('Segments', 'push-notification-for-wp-by-pushassist');?></span>
                    <h3 class="color-up"><?php echo number_format($dashboard_info['segment_count']); ?></h3>
                    <span class="diff"><b class="color-down"></b> <?php _e('created', 'push-notification-for-wp-by-pushassist');?></span>
                </li>
            </ul>
        </div>
        <!-- Top Stats End -->

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
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($dashboard_info['last_notifications']) > 0) {

                            for ($i = 0; $i < count($dashboard_info['last_notifications']); $i++) {
                                $no = $i + 1;
                                ?>

                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $dashboard_info['last_notifications'][$i]['siteURL']; ?></td>
                                    <td>
                                        <h5 class="margin-t-0"><?php echo str_replace("\\", "", stripslashes($dashboard_info['last_notifications'][$i]['title'])); ?></h5>
                                        <p class="margin-b-5"><?php echo str_replace("\\", "", stripslashes($dashboard_info['last_notifications'][$i]['message'])); ?></p>
                                        <a href="<?php echo $dashboard_info['last_notifications'][$i]['url']; ?>"
                                           target="_blank"><?php echo $dashboard_info['last_notifications'][$i]['url']; ?></a>
                                    </td>
                                    <td><?php echo number_format($dashboard_info['last_notifications'][$i]['total_sent'] + $dashboard_info['last_notifications'][$i]['failed']); ?></td>
                                    <td><?php echo number_format($dashboard_info['last_notifications'][$i]['total_sent']); ?></td>
                                    <td><?php echo number_format($dashboard_info['last_notifications'][$i]['failed']); ?></td>
                                    <td>
                                        <?php
                                            echo number_format($dashboard_info['last_notifications'][$i]['total_clicked']);

                                            if($dashboard_info['last_notifications'][$i]['total_sent'] != 0){

                                                $percentChange = ($dashboard_info['last_notifications'][$i]['total_clicked'] / $dashboard_info['last_notifications'][$i]['total_sent']) * 100;
                                            } else {

                                                $percentChange = 0;
                                            }

                                            $percentChange = (int)$percentChange;
											
											if($percentChange >= 1){
                                        ?>
                                        <b class="color-up margin-l-15"> <?php echo $percentChange; ?>% </b>
										<?php } ?>
                                    </td>
                                    <td><?php echo date('M d, Y g:i A', strtotime($dashboard_info['last_notifications'][$i]['created_at'])); ?></td>

                                    <?php
                                    if ($dashboard_info['last_notifications'][$i]['campaign_flag'] > 0) {
                                        ?>
                                        <td> <?php _e('Yes', 'push-notification-for-wp-by-pushassist');?></td>
                                    <?php } else { ?>
                                        <td> <?php _e('No', 'push-notification-for-wp-by-pushassist');?></td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                            <?php }
                        } else {
                            ?>
                            <tr>
                                <td colspan="9" class="text-center">                                    
									<?php _e('No record found.', 'push-notification-for-wp-by-pushassist');?>                                    
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