<?php

if (!defined('PUSHASSIST_URL')) {
    define('PUSHASSIST_URL', plugin_dir_url(__FILE__));
}
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://pushassist.com/
 * @since      2.2.4
 *
 * @package    Pushassist
 * @subpackage Pushassist/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pushassist
 * @subpackage Pushassist/admin
 * @author     Team PushAssist <support@pushassist.com>
 */
class Pushassist_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    2.2.4
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    2.2.4
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since      2.2.4
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    //Init Function
    public function pushassist_admin_init()
    {
		
	}

    //Actions Function
    public static function pushassist_add_actions()
    {
        if (is_admin()) {

            $pushassist_settings = self::pushassist_settings();

            if (isset($pushassist_settings['appKey']) && isset($pushassist_settings['appSecret'])) {

                add_action('pushassist_admin_init', array(__CLASS__, 'pushassist_admin_menu'));
                add_action('pushassist_admin_init', array(__CLASS__, 'pushassist_sent_notification_details'));
                add_action('pushassist_admin_init', array(__CLASS__, 'send_pushassist_notifications'));
                add_action('pushassist_admin_init', array(__CLASS__, 'pushassist_segment_details'));
                add_action('pushassist_admin_init', array(__CLASS__, 'pushassist_segment'));
                add_action('pushassist_admin_init', array(__CLASS__, 'pushassist_subscribers_details'));

                add_action('pushassist_admin_init', array(__CLASS__, 'template_setting_psa'));
                add_action('pushassist_admin_init', array(__CLASS__, 'pushassist_advance_setting'));
                add_action('pushassist_admin_init', array(__CLASS__, 'pushassist_gcm_setting'));
                add_action('pushassist_admin_init', array(__CLASS__, 'pushassist_create_campaign'));

                /*    Auto Notification send BY POST      */
                add_action('post_submitbox_misc_actions', array(__CLASS__, 'pushassist_publish_new_post'));
                add_action('add_meta_boxes', array(__CLASS__, 'pushassist_note_text'), 10, 2);
                add_action('save_post', array(__CLASS__, 'save_pushassist_post_meta_data'));

                add_action('wp_dashboard_setup', array(__CLASS__, 'pushassist_dashboard_widget'));

            } else {

                add_action('pushassist_admin_init', array(__CLASS__, 'pushassist_account_create'));
                add_action('pushassist_appkey', array(__CLASS__, 'pushassist_accept_keys'));
            }
        }

        add_action('transition_post_status', array(__CLASS__, 'send_pushassist_post_notification'), 10, 3);

    }

    public static function pushassist_dashboard_widget()
    {
        wp_add_dashboard_widget(
            'pushassist_dashboard_widget',
            __('PushAssist Stats', 'push-notification-for-wp-by-pushassist'),
            array(__CLASS__, 'pushassist_dashboard_widget_display'),
            'normal',
            'high'
        );
    }

    public static function pushassist_dashboard_widget_display()
    {
        $pushassist_settings = self::pushassist_settings();

        $request_data = array("appKey" => trim($pushassist_settings['appKey']),
            "appSecret" => trim($pushassist_settings['appSecret']),
            "action" => 'dashboard/',
            "method" => "GET",
            "remoteContent" => ""
        );

        $dashboard_info = self::puhsassist_decode_request($request_data);

        ?>
        <ul class="psa_stat">
            <li class="total_active_users border_right">
                <a>
                    <?php printf(__("<strong>%s </strong> Active Subscribers", 'push-notification-for-wp-by-pushassist'), number_format($dashboard_info['active'])); ?>
                </a>
            </li>
            <li class="total_unsubscribed_users">
                <a>
                    <?php printf(__("<strong>%s </strong> Unsubscribed", 'push-notification-for-wp-by-pushassist'), number_format($dashboard_info['total_unsubscribed'])); ?>
                </a>
            </li>
            <li class="total_sent border_right">
                <a>
                    <?php printf(__("<strong>%s </strong> Total Delivered", 'push-notification-for-wp-by-pushassist'), number_format($dashboard_info['stats_notification_sent'])); ?>
                </a>
            </li>
            <li class="total_clicks">
                <a>
                    <?php printf(__("<strong>%s </strong> Total Clicks", 'push-notification-for-wp-by-pushassist'), number_format($dashboard_info['stats_clicks'])); ?>
                </a>
            </li>
            <li class="total_users border_right">
                <a>
                    <?php printf(__("<strong>%s </strong> Segments", 'push-notification-for-wp-by-pushassist'), number_format($dashboard_info['segment_count'])); ?>
                </a>
            </li>
            <li class="total_campaigns">
                <a>
                    <?php printf(__("<strong>%s </strong> Campaigns", 'push-notification-for-wp-by-pushassist'), number_format($dashboard_info['stats_campaigns'])); ?>
                </a>
            </li>
        </ul>

        <?php
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    2.2.4
     */
	 
    public function enqueue_styles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Pushassist_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Pushassist_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style('pushassist-admin', plugin_dir_url(__FILE__) . 'css/pushassist-admin.css', array(), $this->version, 'all');
        wp_enqueue_style('pushassist-number-validate', plugin_dir_url(__FILE__) . 'css/intlTelInput.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    2.2.4
     */
	 
    public function enqueue_scripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Pushassist_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Pushassist_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script('pushassist-prism', plugin_dir_url(__FILE__) . 'js/prism.js', array('jquery'), $this->version, true);
        wp_enqueue_script('pushassist-utils', plugin_dir_url(__FILE__) . 'js/utils.js', array('jquery'), $this->version, true);
        wp_enqueue_script('pushassist-intltel', plugin_dir_url(__FILE__) . 'js/intlTelInput.js', array('jquery'), $this->version, true);
        wp_enqueue_script('pushassist-isValidNumber', plugin_dir_url(__FILE__) . 'js/isValidNumber.js', array('jquery'), $this->version, true);
        wp_enqueue_script('pushassist-admin', plugin_dir_url(__FILE__) . 'js/pushassist-admin.js', array('jquery'), $this->version, true);
    }

    function pushassist_admin_menu()
    {
        add_menu_page(
            'PushAssist',
            'PushAssist',
            'manage_options',
            'pushassist-admin',
            array(__CLASS__, 'pushassist_admin_dashboard'),
            plugin_dir_url(__FILE__) . 'images/pushassist.png'
        );

        $pushassist_settings = self::pushassist_settings();

        if (isset($pushassist_settings['appKey']) && isset($pushassist_settings['appSecret'])) {

            add_submenu_page('pushassist-admin', __('Dashboard', 'push-notification-for-wp-by-pushassist'), __('Dashboard', 'push-notification-for-wp-by-pushassist'), 'manage_options', 'pushassist-admin');
            add_submenu_page('pushassist-admin', __('Notifications', 'push-notification-for-wp-by-pushassist'), __('Notifications', 'push-notification-for-wp-by-pushassist'), 'manage_options', 'pushassist-sent-notification-details', array(__CLASS__, 'pushassist_sent_notification_details'));
            add_submenu_page('pushassist-admin', __('Send Notification', 'push-notification-for-wp-by-pushassist'), __('Send Notification', 'push-notification-for-wp-by-pushassist'), 'manage_options', 'pushassist-send-notifications', array(__CLASS__, 'pushassist_send_notifications'));
            add_submenu_page('pushassist-admin', __('Segments', 'push-notification-for-wp-by-pushassist'), __('Segments', 'push-notification-for-wp-by-pushassist'), 'manage_options', 'pushassist-segment-details', array(__CLASS__, 'pushassist_segment_details'));
            add_submenu_page('pushassist-admin', __('Create Segments', 'push-notification-for-wp-by-pushassist'), __('Create Segments', 'push-notification-for-wp-by-pushassist'), 'manage_options', 'pushassist-segments', array(__CLASS__, 'pushassist_create_segment'));
            add_submenu_page('pushassist-admin', __('Subscribers', 'push-notification-for-wp-by-pushassist'), __('Subscribers', 'push-notification-for-wp-by-pushassist'), 'manage_options', 'pushassist-subscribers', array(__CLASS__, 'pushassist_subscribers_details'));
            add_submenu_page('pushassist-admin', __('PushAssist Settings', 'push-notification-for-wp-by-pushassist'), __('Settings', 'push-notification-for-wp-by-pushassist'), 'manage_options', 'pushassist-setting', array(__CLASS__, 'pushassist_setting_details'));
            add_submenu_page('pushassist-admin', __('PushAssist Campaigns', 'push-notification-for-wp-by-pushassist'), __('Campaigns', 'push-notification-for-wp-by-pushassist'), 'manage_options', 'pushassist-campaigns', array(__CLASS__, 'pushassist_campaigns'));

        } else {

            add_submenu_page('pushassist-admin', __('Create Account', 'push-notification-for-wp-by-pushassist'), __('Create Account', 'push-notification-for-wp-by-pushassist'), 'manage_options', 'pushassist-create-account', array(__CLASS__, 'pushassist_create_account'));
        }
    }

    // Admin Dashboard
    public static function pushassist_admin_dashboard()
    {
        $pushassist_settings = self::pushassist_settings();

        if (isset($pushassist_settings['appKey']) && isset($pushassist_settings['appSecret'])) {

            $request_data = array("appKey" => trim($pushassist_settings['appKey']),
                "appSecret" => trim($pushassist_settings['appSecret']),
                "action" => 'dashboard/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $dashboard_info = self::puhsassist_decode_request($request_data);

            $account_info = array("appKey" => trim($pushassist_settings['appKey']),
                "appSecret" => trim($pushassist_settings['appSecret']),
                "action" => 'accounts_info/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $account_details = self::puhsassist_decode_request($account_info);

            require_once plugin_dir_path(__FILE__) . 'partials/pushassist-dashboard.php';

        } else {

            require_once plugin_dir_path(__FILE__) . 'partials/pushassist-create-account.php';
        }
    }

    public static function pushassist_campaigns()
    {
        $timezones = array(
            'Hawaii' => 'Pacific/Honolulu',
            'Alaska' => 'US/Alaska',
            'Pacific Time (US & Canada)' => 'America/Los_Angeles',
            'Arizona' => 'US/Arizona',
            'Mountain Time (US & Canada)' => 'US/Mountain',
            'Central Time (US & Canada)' => 'US/Central',
            'Eastern Time (US & Canada)' => 'US/Eastern',
            'Indiana (East)' => 'US/East-Indiana',
            'Midway Island' => 'Pacific/Midway',
            'American Samoa' => 'US/Samoa',
            'Tijuana' => 'America/Tijuana',
            'Chihuahua' => 'America/Chihuahua',
            'Mazatlan' => 'America/Mazatlan',
            'Central America' => 'America/Managua',
            'Mexico City' => 'America/Mexico_City',
            'Monterrey' => 'America/Monterrey',
            'Saskatchewan' => 'Canada/Saskatchewan',
            'Bogota' => 'America/Bogota',
            'Lima' => 'America/Lima',
            'Quito' => 'America/Bogota',
            'Atlantic Time (Canada)' => 'Canada/Atlantic',
            'Caracas' => 'America/Caracas',
            'La Paz' => 'America/La_Paz',
            'Santiago' => 'America/Santiago',
            'Newfoundland' => 'Canada/Newfoundland',
            'Brasilia' => 'America/Sao_Paulo',
            'Buenos Aires' => 'America/Argentina/Buenos_Aires',
            'Greenland' => 'America/Godthab',
            'Mid-Atlantic' => 'America/Noronha',
            'Azores' => 'Atlantic/Azores',
            'Cape Verde Is.' => 'Atlantic/Cape_Verde',
            'Casablanca' => 'Africa/Casablanca',
            'Dublin' => 'Europe/Dublin',
            'Lisbon' => 'Europe/Lisbon',
            'London' => 'Europe/London',
            'Monrovia' => 'Africa/Monrovia',
            'UTC' => 'UTC',
            'Amsterdam' => 'Europe/Amsterdam',
            'Belgrade' => 'Europe/Belgrade',
            'Bern' => 'Europe/Berlin',
            'Bratislava' => 'Europe/Bratislava',
            'Brussels' => 'Europe/Brussels',
            'Budapest' => 'Europe/Budapest',
            'Copenhagen' => 'Europe/Copenhagen',
            'Ljubljana' => 'Europe/Ljubljana',
            'Madrid' => 'Europe/Madrid',
            'Paris' => 'Europe/Paris',
            'Prague' => 'Europe/Prague',
            'Rome' => 'Europe/Rome',
            'Sarajevo' => 'Europe/Sarajevo',
            'Skopje' => 'Europe/Skopje',
            'Stockholm' => 'Europe/Stockholm',
            'Vienna' => 'Europe/Vienna',
            'Warsaw' => 'Europe/Warsaw',
            'West Central Africa' => 'Africa/Lagos',
            'Zagreb' => 'Europe/Zagreb',
            'Athens' => 'Europe/Athens',
            'Bucharest' => 'Europe/Bucharest',
            'Cairo' => 'Africa/Cairo',
            'Harare' => 'Africa/Harare',
            'Helsinki' => 'Europe/Helsinki',
            'Istanbul' => 'Europe/Istanbul',
            'Jerusalem' => 'Asia/Jerusalem',
            'Kyiv' => 'Europe/Helsinki',
            'Pretoria' => 'Africa/Johannesburg',
            'Riga' => 'Europe/Riga',
            'Sofia' => 'Europe/Sofia',
            'Tallinn' => 'Europe/Tallinn',
            'Vilnius' => 'Europe/Vilnius',
            'Baghdad' => 'Asia/Baghdad',
            'Kuwait' => 'Asia/Kuwait',
            'Minsk' => 'Europe/Minsk',
            'Nairobi' => 'Africa/Nairobi',
            'Riyadh' => 'Asia/Riyadh',
            'Volgograd' => 'Europe/Volgograd',
            'Tehran' => 'Asia/Tehran',
            'Abu Dhabi' => 'Asia/Muscat',
            'Baku' => 'Asia/Baku',
            'Moscow' => 'Europe/Moscow',
            'Muscat' => 'Asia/Muscat',
            'Tbilisi' => 'Asia/Tbilisi',
            'Yerevan' => 'Asia/Yerevan',
            'Kabul' => 'Asia/Kabul',
            'Karachi' => 'Asia/Karachi',
            'Tashkent' => 'Asia/Tashkent',
            'Chennai' => 'Asia/Calcutta',
            'Kolkata' => 'Asia/Kolkata',
            'Kathmandu' => 'Asia/Katmandu',
            'Almaty' => 'Asia/Almaty',
            'Dhaka' => 'Asia/Dhaka',
            'Ekaterinburg' => 'Asia/Yekaterinburg',
            'Rangoon' => 'Asia/Rangoon',
            'Bangkok' => 'Asia/Bangkok',
            'Jakarta' => 'Asia/Jakarta',
            'Novosibirsk' => 'Asia/Novosibirsk',
            'Beijing' => 'Asia/Hong_Kong',
            'Chongqing' => 'Asia/Chongqing',
            'Krasnoyarsk' => 'Asia/Krasnoyarsk',
            'Kuala Lumpur' => 'Asia/Kuala_Lumpur',
            'Perth' => 'Australia/Perth',
            'Singapore' => 'Asia/Singapore',
            'Taipei' => 'Asia/Taipei',
            'Ulaan Bataar' => 'Asia/Ulan_Bator',
            'Urumqi' => 'Asia/Urumqi',
            'Irkutsk' => 'Asia/Irkutsk',
            'Seoul' => 'Asia/Seoul',
            'Tokyo' => 'Asia/Tokyo',
            'Adelaide' => 'Australia/Adelaide',
            'Darwin' => 'Australia/Darwin',
            'Brisbane' => 'Australia/Brisbane',
            'Canberra' => 'Australia/Canberra',
            'Guam' => 'Pacific/Guam',
            'Hobart' => 'Australia/Hobart',
            'Melbourne' => 'Australia/Melbourne',
            'Port Moresby' => 'Pacific/Port_Moresby',
            'Sydney' => 'Australia/Sydney',
            'Yakutsk' => 'Asia/Yakutsk',
            'Vladivostok' => 'Asia/Vladivostok',
            'Auckland' => 'Pacific/Auckland',
            'Fiji' => 'Pacific/Fiji',
            'International Date Line West' => 'Pacific/Kwajalein',
            'Kamchatka' => 'Asia/Kamchatka',
            'Magadan' => 'Asia/Magadan',
            'Marshall Is.' => 'Pacific/Fiji',
            'New Caledonia' => 'Asia/Magadan',
            'Wellington' => 'Pacific/Auckland',
            'Nuku\'alofa' => 'Pacific/Tongatapu'
        );

        $pushassist_settings = self::pushassist_settings();

        if (isset($pushassist_settings['appKey']) && isset($pushassist_settings['appSecret'])) {

            $segment_data = array("appKey" => trim($pushassist_settings['appKey']),
                "appSecret" => trim($pushassist_settings['appSecret']),
                "action" => 'segments/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $segment_list = self::puhsassist_decode_request($segment_data);

            $account_info = array("appKey" => trim($pushassist_settings['appKey']),
                "appSecret" => trim($pushassist_settings['appSecret']),
                "action" => 'accounts_info/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $account_details = self::puhsassist_decode_request($account_info);

            $account_details['timezone_list'] = $timezones;
        }

        require_once plugin_dir_path(__FILE__) . 'partials/pushassist-campaign.php';
    }

    // account creation
    public static function pushassist_create_account()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/pushassist-create-account.php';
    }

    //  notification details ( History )
    public static function pushassist_sent_notification_details()
    {
        $pushassist_settings = self::pushassist_settings();

        if (isset($pushassist_settings['appKey']) && isset($pushassist_settings['appSecret'])) {

            $notification_data = array("appKey" => trim($pushassist_settings['appKey']),
                "appSecret" => trim($pushassist_settings['appSecret']),
                "action" => 'notifications/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $notification_list = self::puhsassist_decode_request($notification_data);
        }

        require_once plugin_dir_path(__FILE__) . 'partials/pushassist-sent-notification-details.php';
    }

    // send new notification
    public static function pushassist_send_notifications()
    {
        $pushassist_settings = self::pushassist_settings();

        if (isset($pushassist_settings['appKey']) && isset($pushassist_settings['appSecret'])) {

            $segment_data = array("appKey" => trim($pushassist_settings['appKey']),
                "appSecret" => trim($pushassist_settings['appSecret']),
                "action" => 'segments/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $segment_list = self::puhsassist_decode_request($segment_data);

            $account_info = array("appKey" => trim($pushassist_settings['appKey']),
                "appSecret" => trim($pushassist_settings['appSecret']),
                "action" => 'accounts_info/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $account_details = self::puhsassist_decode_request($account_info);
        }

        require_once plugin_dir_path(__FILE__) . 'partials/pushassist-send-notifications.php';
    }

    // segment details
    public static function pushassist_segment_details()
    {
        $pushassist_settings = self::pushassist_settings();

        if (isset($pushassist_settings['appKey']) && isset($pushassist_settings['appSecret'])) {

            $segment_data = array("appKey" => trim($pushassist_settings['appKey']),
                "appSecret" => trim($pushassist_settings['appSecret']),
                "action" => 'segments/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $segment_list = self::puhsassist_decode_request($segment_data);
        }

        require_once plugin_dir_path(__FILE__) . 'partials/pushassist-segment-details.php';
    }

    // segment create
    public static function pushassist_create_segment()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/pushassist-segments.php';
    }

    // Pushassist Account subscriber list
    public static function pushassist_subscribers_details()
    {
        $pushassist_settings = self::pushassist_settings();

        if (isset($pushassist_settings['appKey']) && isset($pushassist_settings['appSecret'])) {

            $subscriber_info = array("appKey" => trim($pushassist_settings['appKey']),
                "appSecret" => trim($pushassist_settings['appSecret']),
                "action" => 'subscribers/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $subscriber_details = self::puhsassist_decode_request($subscriber_info);
        }

        require_once plugin_dir_path(__FILE__) . 'partials/pushassist-subscribers.php';
    }

    // Pushassist Account Information Or setting
    public static function pushassist_setting_details()
    {
        $pushassist_settings = self::pushassist_settings();

        if (isset($pushassist_settings['appKey']) && isset($pushassist_settings['appSecret'])) {

            $account_info = array("appKey" => trim($pushassist_settings['appKey']),
                "appSecret" => trim($pushassist_settings['appSecret']),
                "action" => 'accounts_info/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $account_details = self::puhsassist_decode_request($account_info);
        }

        require_once plugin_dir_path(__FILE__) . 'partials/pushassist-setting.php';
    }

    public static function template_setting_psa()
    {
        $pushassist_settings = self::pushassist_settings();

        $response_message = '';

        if (isset($_POST['psa-save-settings'])) {

            $pushassist_setting_post_message = __('We have just published an article, check it out!', 'push-notification-for-wp-by-pushassist');

            $auto_push = false;

            $edit_push = false;

            $use_logoimage = false;
			
            $use_bigimage = false;

            $auto_push_UTM = false;

            $psaJsRestrict = false;

            $psaNewPostChecked = false;

            $psaUpdatePostChecked = false;

            if (isset($_POST['pushassist_auto_push'])) {

                $auto_push = true;
            }

            if (isset($_POST['pushassist_edit_post_push'])) {

                $edit_push = true;
            }

            if (isset($_POST['pushassist_logo_image'])) {

                $use_logoimage = true;
            }

            if (isset($_POST['pushassist_big_image'])) {

                $use_bigimage = true;
            }

            if (isset($_POST['pushassist_setting_post_message'])) {

                $pushassist_setting_post_message = trim($_POST['pushassist_setting_post_message']);
            }

            if (isset($_POST['pushassist_js_restrict'])) {

                $psaJsRestrict = true;
            }

            if (isset($_POST['pushassist_new_post_checked'])) {

                $psaNewPostChecked = true;
            }

            if (isset($_POST['pushassist_update_post_checked'])) {

                $psaUpdatePostChecked = true;
            }

            if (isset($_POST['pushassist_setting_is_utm_show'])) {

                $auto_push_UTM = true;

                $pushassist_settings['psaUTMSource'] = trim($_POST['pushassist_setting_utm_source']);
                $pushassist_settings['psaUTMMedium'] = trim($_POST['pushassist_setting_utm_medium']);
                $pushassist_settings['psaUTMCampaign'] = trim($_POST['pushassist_setting_utm_campaign']);

            } else {

                $pushassist_settings['psaUTMSource'] = 'pushassist';
                $pushassist_settings['psaUTMMedium'] = 'pushassist_notification';
                $pushassist_settings['psaUTMCampaign'] = 'pushassist';
            }

            $pushassist_settings['psaAutoPush'] = $auto_push;

            $pushassist_settings['psaEditPostPush'] = $edit_push;

            $pushassist_settings['psaPostLogoImage'] = $use_logoimage;
			
            $pushassist_settings['psaPostBigImage'] = $use_bigimage;

            $pushassist_settings['psaJsRestrict'] = $psaJsRestrict;

            $pushassist_settings['psaNewPostChecked'] = $psaNewPostChecked;

            $pushassist_settings['psaUpdatePostChecked'] = $psaUpdatePostChecked;

            $pushassist_settings['psaIsAutoPushUTM'] = $auto_push_UTM;

            $pushassist_settings['psaPostMessage'] = $pushassist_setting_post_message;

            update_option('pushassist_settings', $pushassist_settings);

            $response_message = trim('Setting successfully save.');

            wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-setting') . '&response_message=' . $response_message));
        }
    }

    public static function pushassist_advance_setting()
    {
        $pushassist_settings = self::pushassist_settings();

        $appKey = $pushassist_settings['appKey'];

        $secretKey = $pushassist_settings['appSecret'];

        if (isset($_POST['psa-advance-settings'])) {

            $pushassist_timeinterval = $_POST['pushassist_timeinterval'];
            $pushassist_opt_in_title = $_POST['pushassist_opt_in_title'];
            $pushassist_opt_in_subtitle = $_POST['pushassist_opt_in_subtitle'];
            $pushassist_allow_button_text = $_POST['pushassist_allow_button_text'];
            $pushassist_disallow_button_text = $_POST['pushassist_disallow_button_text'];
            $template = $_POST['template'];
            $location = $_POST['psa_template_location'];
            
			/*   image upload   */

			$$image_name = '';

			$image_data = '';
			
			$actual_uploaded_image_path = '';

			$tm = time();

			$upload_file_name = $_FILES['pushassist_setting_fileupload']['name'];

			$upload_tem_file_name = $_FILES['pushassist_setting_fileupload']['tmp_name'];

			if ($upload_file_name != '' && $upload_tem_file_name != '') {

				$wp_upload_dir = wp_upload_dir();

				$image_name = $tm . '-' . $upload_file_name;

				move_uploaded_file($upload_tem_file_name, $wp_upload_dir['basedir'] . '/' . $image_name);

				$actual_uploaded_image_path = $wp_upload_dir['baseurl'] . '/' . $tm . '-' . $upload_file_name;
			}

			/*   image upload  end  */

			$pushassist_child_window_text = $_POST['pushassist_child_window_text'];
			$pushassist_child_window_title = $_POST['pushassist_child_window_title'];
			$pushassist_child_window_message = $_POST['pushassist_child_window_message'];
			$pushassist_setting_title = $_POST['pushassist_setting_title'];
			$pushassist_setting_message = $_POST['pushassist_setting_message'];
			$pushassist_redirect_url = $_POST['pushassist_redirect_url'];

			if (isset($appKey) && isset($secretKey)) {

				$advance_settings = array("templatesetting" => array("interval_time" => $pushassist_timeinterval,
					"opt_in_title" => trim($pushassist_opt_in_title),
					"opt_in_subtitle" => trim($pushassist_opt_in_subtitle),
					"allow_button_text" => trim($pushassist_allow_button_text),
					"disallow_button_text" => trim($pushassist_disallow_button_text),
					"template" => $template,
					"location" => $location,
					"image_name" => trim($image_name),
					"image_path" => trim($actual_uploaded_image_path),
					"child_window_text" => trim($pushassist_child_window_text),
					"child_window_title" => trim($pushassist_child_window_title),
					"child_window_message" => trim($pushassist_child_window_message),
					"notification_title" => trim($pushassist_setting_title),
					"notification_message" => trim($pushassist_setting_message),
					"redirect_url" => trim($pushassist_redirect_url))
				);

				$account_request_data = array("appKey" => $appKey,
					"appSecret" => $secretKey,
					"action" => "settings/",
					"method" => "POST",
					"remoteContent" => $advance_settings
				);

				$site_settings = self::puhsassist_decode_request($account_request_data);

				if ($site_settings['status'] == 'Success') {

					$response_message = $site_settings['response_message'];

				} else if ($site_settings['errors'] != '') {

					$response_message = $site_settings['errors'];

				} else if ($site_settings['error'] != '') {

					$response_message = $site_settings['error'];

				} else {

					$response_message = $site_settings['error_message'];
				}

				$response_message = trim($response_message);

				wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-setting') . '&response_message=' . $response_message));
			}
		}
    }

    public static function pushassist_footer_promo()
    {

        echo <<<END_SCRIPT
<!-- Push Notifications for this site is powered by PushAssist. Push Notifications for Chrome, Safari, FireFox, Opera. - Plugin version 2.2.4 - https://pushassist.com/ -->
END_SCRIPT;

    }

    public static function pushassist_gcm_setting()
    {

        $pushassist_settings = self::pushassist_settings();

        $appKey = $pushassist_settings['appKey'];

        $secretKey = $pushassist_settings['appSecret'];

        if (isset($_POST['psa-gcm-settings'])) {

            $pushassist_gcm_project_no = $_POST['pushassist_gcm_project_no'];

            $pushassist_gcm_api_key = $_POST['pushassist_gcm_api_key'];

            if (isset($appKey) && isset($secretKey)) {

                $gcm_settings = array("accountgcmsetting" => array("project_number" => $pushassist_gcm_project_no,
                    "project_api_key" => trim($pushassist_gcm_api_key))
                );

                $gcm_request_data = array("appKey" => $appKey,
                    "appSecret" => $secretKey,
                    "action" => "gcmsettings/",
                    "method" => "POST",
                    "remoteContent" => $gcm_settings
                );

                $gcm_settings = self::puhsassist_decode_request($gcm_request_data);

                if ($gcm_settings['status'] == 'Success') {

                    $response_message = $gcm_settings['response_message'];

                } else if ($gcm_settings['errors'] != '') {

                    $response_message = $gcm_settings['errors'];

                } else if ($gcm_settings['error'] != '') {

                    $response_message = $gcm_settings['error'];

                } else {

                    $response_message = $gcm_settings['error_message'];
                }

                $response_message = trim($response_message);

                wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-setting') . '&response_message=' . $response_message));
            }
        }
    }

    public static function pushassist_create_campaign()
    {
        if (isset($_POST['pushassist_campaign_title']) && isset($_POST['pushassist_campaign_message']) && isset($_POST['pushassist_campaign_date'])) {

            $response_message = '';

            $utm_source = '';
            $utm_medium = '';
            $utm_campaign = '';

            $campaign_date = sanitize_text_field($_POST['pushassist_campaign_date']);

            $message = sanitize_text_field($_POST['pushassist_campaign_message']);

            $title = sanitize_text_field($_POST['pushassist_campaign_title']);

            $campaign_timezone = $_POST['pushassist_campaign_timezone'];

            $utm_string_url = esc_url($_POST['pushassist_campaign_url']);

            if (isset($_POST['pushassist_campaign_segment'])) {

                $segments = $_POST['pushassist_campaign_segment'];
            } else {

                $segments = array();
            }

            if ($title == '') {

                $response_message = 'Please provide title.';

            } else if ($message == '') {

                $response_message = 'Please provide message.';

            } else if ($campaign_date == '') {

                $response_message = 'Please provide campaign date.';

            } else if ($_POST['pushassist_campaign_is_utm_show'] == 1 && $utm_string_url == '') {

                $response_message = 'Please provide campaign url.';

            } else if ($_POST['pushassist_campaign_is_utm_show'] == 1 && $_POST['pushassist_campaign_utm_source'] == '') {

                $response_message = 'Please provide UTM source.';

            } else if ($_POST['pushassist_campaign_is_utm_show'] == 1 && $_POST['pushassist_campaign_utm_medium'] == '') {

                $response_message = 'Please provide UTM medium.';

            } else if ($_POST['pushassist_campaign_is_utm_show'] == 1 && $_POST['pushassist_campaign_utm_campaign'] == '') {

                $response_message = 'Please provide UTM campaign.';

            } else if ($_FILES['pushassist_campaign_fileupload']['size'] > 500000) {

                $response_message = 'Image size must be exactly 250x250px.';
            }

            if (!empty($response_message)) {

                $response_message = trim(trim($response_message));

                wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-campaigns') . '&response_message=' . $response_message));

            } else {

                $pushassist_settings = self::pushassist_settings();

                $appKey = $pushassist_settings['appKey'];

                $appSecret = $pushassist_settings['appSecret'];

                /*   image upload   */

                $tm = time();

                $upload_file_name = $_FILES['pushassist_campaign_fileupload']['name'];

                $upload_tem_file_name = $_FILES['pushassist_campaign_fileupload']['tmp_name'];

                if ($upload_file_name != '' && $upload_tem_file_name != '') {

                    $wp_upload_dir = wp_upload_dir();

                    move_uploaded_file($upload_tem_file_name, $wp_upload_dir['basedir'] . '/' . $tm . '-' . $upload_file_name);

                    $actual_uploaded_image_path = $wp_upload_dir['baseurl'] . '/' . $tm . '-' . $upload_file_name;

                } else {

                    $actual_uploaded_image_path = '';
                }

                /*   image upload  end  */

                if (isset($_POST['pushassist_campaign_utm_source']) && $_POST['pushassist_campaign_is_utm_show'] == 1 && $utm_string_url != '') {

                    $utm_source = sanitize_text_field($_POST['pushassist_campaign_utm_source']);
                }

                if (isset($_POST['pushassist_campaign_utm_medium']) && $_POST['pushassist_campaign_is_utm_show'] == 1 && $utm_string_url != '') {

                    $utm_medium = sanitize_text_field($_POST['pushassist_campaign_utm_medium']);
                }

                if (isset($_POST['pushassist_campaign_utm_campaign']) && $_POST['pushassist_campaign_is_utm_show'] == 1 && $utm_string_url != '') {

                    $utm_campaign = sanitize_text_field($_POST['pushassist_campaign_utm_campaign']);
                }

                $campaign = array("campaign" => array("title" => $title,
                    "message" => $message,
                    "timezone" => $campaign_date,
                    "redirect_url" => $utm_string_url,
                    "image" => $actual_uploaded_image_path),
                    "utm_params" => array("utm_source" => $utm_source,
                        "utm_medium" => $utm_medium,
                        "utm_campaign" => $utm_campaign),
                    "segments" => $segments,
                    "campaign_timezone" => $campaign_timezone,
                );

                $campaign_request_data = array("appKey" => trim($appKey),
                    "appSecret" => trim($appSecret),
                    "action" => "campaigns/",
                    "method" => "POST",
                    "remoteContent" => $campaign
                );

                $campaign_response = self::puhsassist_decode_request($campaign_request_data);

                if ($campaign_response['status'] == 'Success') {

                    $response_message = $campaign_response['response_message'];

                } else if ($campaign_response['errors'] != '') {

                    $response_message = $campaign_response['errors'];

                } else if ($campaign_response['error'] != '') {

                    $response_message = $campaign_response['error'];

                } else {

                    $response_message = $campaign_response['error_message'];
                }

                $response_message = trim(trim($response_message));

                if ($campaign_response['status'] == 'Success') {

                    wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-admin') . '&response_message=' . $response_message));
					
                } else {

                    wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-campaigns') . '&response_message=' . $response_message));
                }
            }
        }
    }

    // Check Pushassist Account valid or not
    public static function pushassist_settings()
    {
        $pushassist = get_option('pushassist_settings');

        return $pushassist;
    }

    // if already registered then accept API keys
    public static function pushassist_accept_keys()
    {
        $response_message = '';

        if (isset($_POST['pushassist_api_key']) || isset($_POST['pushassist_secret_key'])) {

            $appKey = $_POST['pushassist_api_key'];

            $secretKey = $_POST['pushassist_secret_key'];

            $request_data = array("appKey" => $appKey,
                "appSecret" => $secretKey,
                "action" => 'accounts_info/',
                "method" => "GET",
                "remoteContent" => array()
            );

            $account_info = self::puhsassist_decode_request($request_data);

            if (isset($account_info['apiKey']) && isset($account_info['apiSecret'])) {

                $pushassist_settings = array(

                    'appKey' => trim($account_info['apiKey']),
                    'appSecret' => trim($account_info['apiSecret']),
                    'jsPath' => trim($account_info['jsPath']),
                    'psaAutoPush' => false,
                    'psaEditPostPush' => false,
                    'psaIsAutoPushUTM' => false,
                    'psaJsRestrict' => false,
                    'psaNewPostChecked' => false,
                    'psaUpdatePostChecked' => false,
                    'psaPostLogoImage' => false,
                    'psaPostBigImage' => false,
                    'psaUTMSource' => 'pushassist',
                    'psaUTMMedium' => 'pushassist_notification',
                    'psaUTMCampaign' => 'pushassist',
                    'psaPostMessage' => 'We have just published an article, check it out!',
                );

                wp_enqueue_script('pushassist-js', trim($account_info['jsPath']), array('jquery'), "", true);

                add_option('pushassist_settings', $pushassist_settings);

                $response_message = trim("PushAssist is installed, no additional step is needed. Completely Purge Site Cache once to see it in action. Your Account Details have already been emailed to you. Also check under SPAM if you don't find it.");

                wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-admin') . '&response_message=' . $response_message));

            } else {

                if (isset($account_info['error'])) {

                    $response_message = trim($account_info['error']);
                }

                wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-create-account') . '&response_message=' . $response_message));
            }
        }
    }

    // function to create an new account
    public static function pushassist_account_create()
    {
        if (isset($_POST['pushassist_api_form']) && $_POST['pushassist_api_form'] == 'pushassist_account_creation') {

            if (isset($_POST['pushassist_name']) || isset($_POST['pushassist_email']) || isset($_POST['pushassist_contact']) || isset($_POST['pushassist_password']) || isset($_POST['pushassist_protocol']) || isset($_POST['pushassist_site_url']) || isset($_POST['pushassist_sub_domain'])) {

                $response_message_error = '';

                $name = sanitize_text_field($_POST['pushassist_name']);

                $company_name = sanitize_text_field($_POST['pushassist_company_name']);

                $email = sanitize_text_field($_POST['pushassist_email']);

                $contact = sanitize_text_field($_POST['pushassist_contact']);

                $hidden_psa_error_msg = sanitize_text_field($_POST['hidden_psa_error_msg']);

                $password = sanitize_text_field($_POST['pushassist_password']);

                $protocol = sanitize_text_field($_POST['pushassist_protocol']);

                $site_url = sanitize_text_field($_POST['pushassist_site_url']);

                $url = $protocol . $site_url;

                $sub_domain = sanitize_text_field($_POST['pushassist_sub_domain']);

                if ($hidden_psa_error_msg == 0 && !empty($contact)) {

                    $response_message_error = trim('Please Provide valid contact no.');
                }

                $flag = self::url_validator($url);

                if ($flag == 0) {

                    $response_message_error = trim('Please Provide valid site URL.');
                }

                if (!empty($response_message_error)) {

                    wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-create-account') . '&response_message=' . $response_message_error));

                } else {
                    /*   account creation   */
                    $remoteContent = array("account" => array("name" => trim($name),
                        "company_name" => trim($company_name),
                        "contact" => $contact,
                        "email" => trim($email),
                        "password" => trim($password),
                        "protocol" => trim($protocol),
                        "siteurl" => trim($site_url),
                        "subdomain" => trim($sub_domain),
                        "psa_source" => 'WordPress')
                    );

                    $account_request_data = array("action" => "accounts/",
                        "method" => "POST",
                        "remoteContent" => $remoteContent
                    );

                    $account_create = self::puhsassist_decode_request($account_request_data);

                    if ($account_create['status'] == 'Success') {

                        $dashboard_request_data = array("appKey" => $account_create['api_key'],
                            "appSecret" => $account_create['auth_secret'],
                            "action" => "accounts_info/",
                            "method" => "GET",
                            "remoteContent" => ""
                        );

                        $account_info = self::puhsassist_decode_request($dashboard_request_data);

                        if (isset($account_info['apiKey']) && isset($account_info['apiSecret'])) {

                            $pushassist_settings = array(

                                'appKey' => trim($account_info['apiKey']),
                                'appSecret' => trim($account_info['apiSecret']),
                                'jsPath' => trim($account_info['jsPath']),
                                'psaAutoPush' => false,
                                'psaEditPostPush' => false,
                                'psaIsAutoPushUTM' => false,
                                'psaJsRestrict' => false,
                                'psaNewPostChecked' => false,
                                'psaUpdatePostChecked' => false,
								'psaPostLogoImage' => false,
								'psaPostBigImage' => false,
                                'psaUTMSource' => 'pushassist',
                                'psaUTMMedium' => 'pushassist_notification',
                                'psaUTMCampaign' => 'pushassist',
                                'psaPostMessage' => 'We have just published an article, check it out!',
                            );

                            wp_enqueue_script('pushassist-js', trim($account_info['jsPath']), array('jquery'), "", true);

                            add_option('pushassist_settings', $pushassist_settings);

                            if ($account_create['status'] == 'Success') {

                                $response_message = $account_create['response_message'];
                            }

                            $response_message = trim("PushAssist is installed, no additional step is needed. Completely Purge Site Cache once to see it in action.  Your Account Details have already been emailed to you. Also check under SPAM if you don't find it.");

                            wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-admin') . '&response_message=' . $response_message));
                        }

                    } else {

                        if ($account_create['error'] != '') {

                            $response_message = $account_create['error'];

                        } else if ($account_create['errors'] != '') {

                            $response_message = $account_create['errors'];

                        } else {

                            $response_message = $account_create['error_message'];
                        }

                        $response_message = trim(trim($response_message));

                        wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-create-account') . '&response_message=' . $response_message));
                    }
                }
            }
        } else {

            self::pushassist_accept_keys();
        }
    }

    /*   notification send    */

    public static function send_pushassist_notifications()
    {
        if (isset($_POST['pushassist_notification_title']) || isset($_POST['pushassist_notification_message'])) {

            $utm_source = '';
            $utm_medium = '';
            $utm_campaign = '';

            $message = sanitize_text_field($_POST['pushassist_notification_message']);

            $title = sanitize_text_field($_POST['pushassist_notification_title']);

            $utm_string_url = esc_url($_POST['pushassist_notification_url']);
			
			$big_image_url = '';
						
            if (isset($_POST['pushassist_notification_segment'])) {

                $segment = $_POST['pushassist_notification_segment'];
            } else {

                $segment = array();
            }

            if ($title == '') {

                $response_message = 'Please provide title.';

            } else if ($message == '') {

                $response_message = 'Please provide message.';

            } else if ($_POST['pushassist_notification_is_utm_show'] == 1 && $utm_string_url == '') {

                $response_message = 'Please provide notification url.';

            } else if ($_POST['pushassist_notification_is_utm_show'] == 1 && $_POST['pushassist_notification_utm_source'] == '') {

                $response_message = 'Please provide UTM source.';

            } else if ($_POST['pushassist_notification_is_utm_show'] == 1 && $_POST['pushassist_notification_utm_medium'] == '') {

                $response_message = 'Please provide UTM medium.';

            } else if ($_POST['pushassist_notification_is_utm_show'] == 1 && $_POST['pushassist_notification_utm_campaign'] == '') {

                $response_message = 'Please provide UTM campaign.';

            } else if ($_FILES['pushassist_notification_fileupload']['size'] > 500000) {

                $response_message = 'Image size must be exactly 256x256px.';
            }

            if (!empty($response_message)) {

                $response_message = trim(trim($response_message));

                wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-send-notifications') . '&response_message=' . $response_message));

            } else {

                $pushassist_settings = self::pushassist_settings();

                $appKey = $pushassist_settings['appKey'];

                $appSecret = $pushassist_settings['appSecret'];

                /*   image upload   */

                $tm = time();

                //$upload_file = $_FILES['pushassist_notification_fileupload'];

                $upload_file_name = $_FILES['pushassist_notification_fileupload']['name'];

                $upload_tem_file_name = $_FILES['pushassist_notification_fileupload']['tmp_name'];

                if ($upload_file_name != '' && $upload_tem_file_name != '') {

                    $wp_upload_dir = wp_upload_dir();

                    move_uploaded_file($upload_tem_file_name, $wp_upload_dir['basedir'] . '/' . $tm . '-' . $upload_file_name);

                    $actual_uploaded_image_path = $wp_upload_dir['baseurl'] . '/' . $tm . '-' . $upload_file_name;

                } else {

                    $actual_uploaded_image_path = '';
                }
				
				/*	Notification Large Image  */
				if(isset($_POST['pushassist_is_big_image']) && $_POST['pushassist_is_big_image'] == 1 && $actual_uploaded_image_path != ''){
				
					$big_image_url = $actual_uploaded_image_path;
					$actual_uploaded_image_path = '';
				}

                /*   image upload  end  */

                if (isset($_POST['pushassist_notification_utm_source']) && $_POST['pushassist_notification_is_utm_show'] == 1 && $utm_string_url != '') {

                    $utm_source = sanitize_text_field($_POST['pushassist_notification_utm_source']);
                }

                if (isset($_POST['pushassist_notification_utm_medium']) && $_POST['pushassist_notification_is_utm_show'] == 1 && $utm_string_url != '') {

                    $utm_medium = sanitize_text_field($_POST['pushassist_notification_utm_medium']);
                }

                if (isset($_POST['pushassist_notification_utm_campaign']) && $_POST['pushassist_notification_is_utm_show'] == 1 && $utm_string_url != '') {

                    $utm_campaign = sanitize_text_field($_POST['pushassist_notification_utm_campaign']);
                }

                $notification = array("notification" => array("title" => $title,
                    "message" => $message,
                    "redirect_url" => $utm_string_url,
                    "image" => $actual_uploaded_image_path,
					"big_image" => $big_image_url),
                    "utm_params" => array("utm_source" => $utm_source,
                        "utm_medium" => $utm_medium,
                        "utm_campaign" => $utm_campaign),
                    "segments" => $segment
                );

                $notification_request_data = array("appKey" => trim($appKey),
                    "appSecret" => trim($appSecret),
                    "action" => "notifications/",
                    "method" => "POST",
                    "remoteContent" => $notification
                );
				
                $notification_response = self::puhsassist_decode_request($notification_request_data);

                if ($notification_response['status'] == 'Success') {

                    $response_message = $notification_response['response_message'];

                } else if ($notification_response['errors'] != '') {

                    $response_message = $notification_response['errors'];

                } else if ($notification_response['error'] != '') {

                    $response_message = $notification_response['error'];

                } else {

                    $response_message = $notification_response['error_message'];
                }

                $response_message = trim(trim($response_message));

                if ($notification_response['status'] == 'Success') {

                    wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-admin') . '&response_message=' . $response_message));
                } else {

                    wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-send-notifications') . '&response_message=' . $response_message));
                }
            }
        }
    }

    /*   end notification   */

    /*   add segment   */

    public static function pushassist_segment()
    {
        $pushassist_settings = self::pushassist_settings();

        if (isset($_POST['pushassist_segment_name'])) {

            $pushassit_segmentname = sanitize_text_field($_POST['pushassist_segment_name']);

            if ($pushassit_segmentname != '') {

                $pushassit_segmentname = str_replace(" ", "+", $pushassit_segmentname);

                $remoteContent = array("segment" => array("segment_name" => $pushassit_segmentname));

                $segment_request_data = array("appKey" => trim($pushassist_settings['appKey']),
                    "appSecret" => trim($pushassist_settings['appSecret']),
                    "action" => "segments/",
                    "method" => "POST",
                    "remoteContent" => $remoteContent
                );

                $add_segment = self::puhsassist_decode_request($segment_request_data);

                if ($add_segment['status'] == 'Success') {

                    $response_message = $add_segment['response_message'];

                } else if ($add_segment['errors'] != '') {

                    $response_message = $add_segment['errors'];

                } else if ($add_segment['error'] != '') {

                    $response_message = $add_segment['error'];

                } else {

                    $response_message = $add_segment['error_message'];
                }

                if ($add_segment['status'] == 'Success') {

                    wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-segment-details')));

                } else {

                    $response_message = trim(trim($response_message));

                    wp_redirect(esc_url_raw(admin_url('admin.php?page=pushassist-segments') . '&response_message=' . $response_message));
                }
            }
        }
    }

    /*   segment end  */

    /*  New post publish notification  */

    public static function pushassist_publish_new_post()
    {
        $newpostChecked = '';

        $updatepostChecked = '';

        $pushassist_settings = self::pushassist_settings();

        $psaNewPostChecked = $pushassist_settings['psaNewPostChecked'];

        if (isset($psaNewPostChecked) && (true === $psaNewPostChecked)) {

            $newpostChecked = 'checked';
        }

        $psaUpdatePostChecked = $pushassist_settings['psaUpdatePostChecked'];

        if (isset($psaUpdatePostChecked) && (true === $psaUpdatePostChecked)) {

            $updatepostChecked = 'checked';
        }

        $psa_auto_push = $pushassist_settings['psaAutoPush'];

        global $post;

        printf('<div id="pushassist_segment_checkboxes" class="misc-pub-section misc-pub-post-status">');

        if ('publish' === $post->post_status) {

            printf('<label><input type="checkbox" ' . $updatepostChecked . ' value="1" id="pushassist-forced-checkbox" name="pushassist-checkbox" style="margin: -3px 9px 0 1px;" />');
            _e('Send Push Notification on Update', 'push-notification-for-wp-by-pushassist');
            echo ' </label>';

        } else if ('auto-draft' === $post->post_status || true === $psa_auto_push) {

            $pushassist_post_id = get_the_ID();

            printf('<label><input type="checkbox" value="1"  ' . $newpostChecked . ' id="pushassist-forced-checkbox" name="pushassist-checkbox" style="margin: -3px 9px 0 1px;" %s />', checked(get_post_meta($pushassist_post_id, '_pushassist_force', true), 1, false));
            _e('Send Push Notification', 'push-notification-for-wp-by-pushassist');
            echo ' </label>';
        }

        wp_nonce_field('pushassist_save_post', 'hidden_pe');

        echo '</div>';

        if ('publish' === $post->post_status || 'auto-draft' === $post->post_status) {

            if (isset($pushassist_settings['appKey']) && isset($pushassist_settings['appSecret'])) {

                $segment_data = array("appKey" => trim($pushassist_settings['appKey']),
                    "appSecret" => trim($pushassist_settings['appSecret']),
                    "action" => 'segments/',
                    "method" => "GET",
                    "remoteContent" => ""
                );

                $pushassist_segmets_data = self::puhsassist_decode_request($segment_data);

            } else {

                $pushassist_segmets_data = '';
            }

            if (!empty($pushassist_segmets_data)) {

                printf('<div style="padding-left:37px;padding-top:0px; line-height: 25px" id="pushassist_post_categories"><span style="font-weight:bold;">');
                _e('Select PushAssist Segments', 'push-notification-for-wp-by-pushassist');
                printf('</span>');

                echo '<br><input type="checkbox" id="pushassist_checkbox" onclick="pushassist_check_all();"><span  style="margin-left:10px;">';
                _e('All', 'push-notification-for-wp-by-pushassist');
                echo '</span>';

                foreach ($pushassist_segmets_data as $segment_list) {

                    echo '<div style="margin:5px 10px 5px 0px !important;"><input type="checkbox" class="pushassist-segments" name="pushassist_segment_categories[]" value="' . $segment_list["id"] . '"><span style="margin-left:10px;">' . $segment_list["name"] . '</span></div>';
                }
                echo '</div>';

                echo '<script>
				function pushassist_check_all()
				{
					var pushassist_all_checkbox = document.getElementById("pushassist_checkbox").checked;

					var pushassist_segments = document.getElementsByClassName("pushassist-segments");

					for (var key in pushassist_segments)
					{
					  if (pushassist_segments.hasOwnProperty(key))
					  {
						if(!pushassist_all_checkbox)
						{
							pushassist_segments[key].checked = false;
						}
						else
						{
							pushassist_segments[key].checked = true;
						}
					  }
					}
				}
				</script>';
            }
        }
    }

    public static function pushassist_note_text($post_type, $post)
    {
        if ('post' === $post_type || 'shop_coupon' === $post_type || 'product' === $post_type) {

            if ('attachment' !== $post_type && 'comment' !== $post_type && 'dashboard' !== $post_type && 'link' !== $post_type) {

                add_meta_box(
                    'pushassist_meta',
                    __('PushAssist Notification Message', 'push-notification-for-wp-by-pushassist'),
                    array(__CLASS__, 'pushassist_custom_headline_content'),
                    '',
                    'normal',
                    'high'
                );
            }
        }
    }

    public static function pushassist_custom_headline_content($post)
    {
        $pushassist_note_text = get_post_meta($post->ID, '_pushassist_custom_text', true);

        ?>
        <div id="pushassist_custom_note" class="form-field form-required">

            <input type="text" id="pushassist_post_notification_message" maxlength="138"
                   placeholder="<?php _e('Notification Message', 'push-notification-for-wp-by-pushassist'); ?>"
                   name="pushassist_post_notification_message"
                   value="<?php echo !empty($pushassist_note_text) ? esc_attr($pushassist_note_text) : ''; ?>"/><br>
            <span
                id="pushassist-post-description"><?php _e('Limit 138 Characters', 'push-notification-for-wp-by-pushassist'); ?>
                <br/> <?php _e('When using a custom headline, this text will be used in place of the default blog post message for your push notification.', 'push-notification-for-wp-by-pushassist'); ?></span>
        </div>
        <?php
    }

    public static function save_pushassist_post_meta_data($post_id)
    {		
		$pushassist_settings = self::pushassist_settings();

		$psa_auto_push = $pushassist_settings['psaAutoPush'];
		
        if ((!isset($_POST['pushassist-checkbox']) || !current_user_can('edit_posts')) && false === $psa_auto_push) {
			
            return false;

        } else {
			
            $pushassist_note = get_post_meta($post_id, '_pushassist_checkbox_override', true);

            if ((isset($_POST['pushassist-checkbox']) && !$pushassist_note) || (true === $psa_auto_push && !$pushassist_note)) {

				if ((isset($_POST['pushassist-checkbox']))){
					
					$checkbox_setting = sanitize_text_field($_POST['pushassist-checkbox']);

					add_post_meta($post_id, '_pushassist_checkbox_override', $checkbox_setting, true);					
				}
				
            } elseif (!isset($_POST['pushassist-checkbox']) && $pushassist_note) {

                delete_post_meta($post_id, '_pushassist_checkbox_override');
            }

            if (isset($_POST['pushassist_post_notification_message']) || true === $psa_auto_push) {
			
				if ((isset($_POST['pushassist_post_notification_message']))){
					
					update_post_meta($post_id, '_pushassist_custom_text', sanitize_text_field($_POST['pushassist_post_notification_message']));
				}
            }
        }
    }

    public static function send_pushassist_post_notification($new_status, $old_status, $post)
    {
        $pushassist_settings = self::pushassist_settings();

        $appKey = $pushassist_settings['appKey'];

        $appSecret = $pushassist_settings['appSecret'];

        $psa_auto_push = $pushassist_settings['psaAutoPush'];

        $psa_edit_post_push = $pushassist_settings['psaEditPostPush'];

        $psaIsAutoPushUTM = $pushassist_settings['psaIsAutoPushUTM'];

        $psaPostLogoImage = $pushassist_settings['psaPostLogoImage'];
		
        $psaPostBigImage = $pushassist_settings['psaPostBigImage'];

        $utm_source = '';
        $utm_medium = '';
        $utm_campaign = '';

        $post_type = get_post_type($post);

        if (!isset($appKey) || !isset($appSecret)) {

            return;
        }

        if (empty($post)) {

            return;
        }

        $pushassist_post_id = $post->ID;

        if ('publish' === $new_status && 'publish' === $old_status) {

            if (isset($_POST['pushassist-checkbox'])) {

                $pushassit_note = true;
            }
        }

        if ($new_status !== $old_status || !empty($pushassit_note) || true === $psa_edit_post_push) {

            if ('publish' === $new_status) {

                $segments = array();
                $image_url = null;
				$big_image_url = null;

                if (('publish' === $new_status && 'future' === $old_status)) {

                    $pushassist_checkbox_array = get_post_meta($pushassist_post_id, '_pushassist_checkbox_override', true);

                    $pushassist_post_notification_text = get_post_meta($pushassist_post_id, '_pushassist_custom_text', true);

                } else {

                    if (isset($_POST['pushassist-checkbox'])) {

                        $pushassist_checkbox_array = sanitize_text_field($_POST['pushassist-checkbox']);
                    }

                    if (isset($_POST['pushassist_post_notification_message']) && !empty($_POST['pushassist_post_notification_message'])) {

                        $pushassist_post_notification_text = sanitize_text_field($_POST['pushassist_post_notification_message']);
                    }
                }

                if (!empty($pushassist_checkbox_array) || true === $psa_auto_push || true === $psa_edit_post_push) {

                    if (isset($_POST['pushassist_segment_categories']) and !empty($_POST['pushassist_segment_categories'])) {

                        $segments = $_POST['pushassist_segment_categories'];
                    }

                    if (!empty($pushassist_post_notification_text)) {

                        $notification_title_text = sanitize_text_field(substr(get_the_title($pushassist_post_id), 0, 100));

                        $notification_message_text = sanitize_text_field(substr(stripslashes($pushassist_post_notification_text), 0, 138));

                    } else {

                        $notification_title_text = sanitize_text_field(substr(get_the_title($pushassist_post_id), 0, 100));

                        if (isset($pushassist_settings['psaPostMessage'])) {

                            $notification_message_text = sanitize_text_field(substr(stripslashes($pushassist_settings['psaPostMessage']), 0, 138));

                        } else {

                            $notification_message_text = sanitize_text_field(substr(stripslashes(__('We have just published an article, check it out!', 'push-notification-for-wp-by-pushassist')), 0, 138));
                        }
                    }

                    if ($psaPostLogoImage == false) {

                        if (has_post_thumbnail($pushassist_post_id)) {

                            $thumbnail_image = wp_get_attachment_image_src(get_post_thumbnail_id($pushassist_post_id));

                            $image_url = $thumbnail_image[0];
                        }
                    }

                    if (isset($pushassist_settings['psaPostBigImage']) && $psaPostBigImage == true) {
						
						$big_image_url = $image_url;
						$image_url = null;
					}
					
					if ((isset($pushassist_settings['psaPostBigImage']) && $psaPostBigImage == true) && (isset($pushassist_settings['psaPostLogoImage']) && $psaPostLogoImage == true)) {
						
						$big_image_url = $image_url;
						$image_url = null;
					}
					
                    if (isset($pushassist_settings['psaUTMSource']) && $psaIsAutoPushUTM == true) {

                        $utm_source = sanitize_text_field($pushassist_settings['psaUTMSource']);
                    }

                    if (isset($pushassist_settings['psaUTMMedium']) && $psaIsAutoPushUTM == true) {

                        $utm_medium = sanitize_text_field($pushassist_settings['psaUTMMedium']);
                    }

                    if (isset($pushassist_settings['psaUTMCampaign']) && $psaIsAutoPushUTM == true) {

                        $utm_campaign = sanitize_text_field($pushassist_settings['psaUTMCampaign']);
                    }

                    $pushassist_link = get_permalink($pushassist_post_id);

                    $notification = array("notification" => array("title" => $notification_title_text,
                        "message" => $notification_message_text,
                        "redirect_url" => $pushassist_link,
                        "image" => $image_url,
						"big_image" => $big_image_url,
                        "utm_params" => array("utm_source" => $utm_source,
                            "utm_medium" => $utm_medium,
                            "utm_campaign" => $utm_campaign),
                        "segments" => $segments)
                    );

                    $segment_request_data = array("appKey" => trim($appKey),
                        "appSecret" => trim($appSecret),
                        "action" => "notifications/",
                        "method" => "POST",
                        "remoteContent" => $notification
                    );
					
                    $notification_response = self::puhsassist_decode_request($segment_request_data);
                }
            }
        }
    }

    /*  end post publish notification  */

    public static function pushassist_removeSpecialCharacters($string)
    {
        return preg_replace('/[^A-Za-z0-9\- ]/', '', $string);
    }

    /*     API Functions start     */
    public static function puhsassist_remote_request($remote_data)
    {
        $remote_url = 'https://api.pushassist.com/' . $remote_data['action'];

        if ($remote_data['action'] == "accounts/") {

            $headers = array("Content-Type" => 'application/json');

        } else {

            $headers = array(
                'X-Auth-Token' => $remote_data['appKey'],
                'X-Auth-Secret' => $remote_data['appSecret'],
                "Content-Type" => 'application/json'
            );
        }

        if ($remote_data['method'] != 'GET') {

            $remote_array = array(
                'method' => $remote_data['method'],
                'headers' => $headers,
                'body' => json_encode($remote_data['remoteContent']),
            );

        } else {

            $remote_array = array(
                'method' => $remote_data['method'],
                'headers' => $headers
            );
        }

        $response = wp_remote_request(esc_url_raw($remote_url), $remote_array);

        return $response;
    }

    public static function puhsassist_decode_request($remote_data)
    {
        $remote_request_response = self::puhsassist_remote_request($remote_data);

        $retrieve_body_content = wp_remote_retrieve_body($remote_request_response);

        $response_array = json_decode($retrieve_body_content, true);

        return $response_array;
    }

    public static function url_validator($url)
    {
        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME
        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
        $regex .= "([a-z0-9-.]*)\.([a-z]{2,4})"; // Host or IP
        $regex .= "(\:[0-9]{2,5})?"; // Port
        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor

        if (preg_match("/^$regex$/", $url)) {

            return 1;

        } else {

            return 0;
        }
    }
    /*     API Functions end    */
}