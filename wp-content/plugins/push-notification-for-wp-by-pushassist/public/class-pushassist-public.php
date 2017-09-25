<?php

if (!defined('PUSHASSIST_JS_URL')) {
	define('PUSHASSIST_JS_URL', 'https://cdn.pushassist.com/account/assets/');
}

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://pushassist.com/
 * @since      2.2.4
 *
 * @package    Pushassist
 * @subpackage Pushassist/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pushassist
 * @subpackage Pushassist/public
 * @author     Team PushAssist <support@pushassist.com>
 */
class Pushassist_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.2.4
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.2.4
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.2.4
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    2.2.4
	 */
	public function enqueue_styles() {

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

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pushassist-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    2.2.4
	 */
	public function enqueue_scripts() {

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
		$pushassist_settings = get_option('pushassist_settings');

		if (isset($pushassist_settings['appKey']) && isset($pushassist_settings['appSecret']) && isset($pushassist_settings['jsPath']) && (isset($pushassist_settings['psaJsRestrict']) && (false == $pushassist_settings['psaJsRestrict']))) {
					
			add_action( 'wp_enqueue_scripts', 'load_jquery_check' );
			
			$switch_cdn = explode('assets/', $pushassist_settings['jsPath']);

			//wp_enqueue_script('pushassist-js', trim(PUSHASSIST_JS_URL.$switch_cdn[1]), array('jquery'), "", false);
			echo '<script type="text/javascript" src="'.trim(PUSHASSIST_JS_URL.$switch_cdn[1]).'" async></script>';
		}
	}
	
	public	function load_jquery_check() {
				
		if ( ! wp_script_is( 'jquery', 'enqueued' )) {

			//Enqueue
			wp_enqueue_script( 'jquery' );
		}
	}
	
	public function call_pushassist_schedule_notification($new_status, $old_status, $post){

		$pushassist_settings = get_option('pushassist_settings');

		$appKey = $pushassist_settings['appKey'];

		$appSecret = $pushassist_settings['appSecret'];

		$psa_auto_push = $pushassist_settings['psaAutoPush'];

		$psaIsAutoPushUTM = $pushassist_settings['psaIsAutoPushUTM'];

		$psaPostLogoImage = $pushassist_settings['psaPostLogoImage'];

		$utm_source = '';
		$utm_medium = '';
		$utm_campaign = '';

		if (!isset($appKey) || !isset($appSecret)) {

			return;
		}

		if (empty($post)) {

			return;
		}

		$pushassist_note = false;

		$pushassist_post_id = $post->ID;

		if ('publish' === $new_status && 'future' === $old_status) {

			$pushassist_checkbox_array = get_post_meta($pushassist_post_id, '_pushassist_checkbox_override', true);

			if (!empty($pushassist_checkbox_array)) {

				$pushassist_note = true;
			}
		}

		if ((true === $pushassist_note) || (true === $psa_auto_push && 'future' === $old_status)) {

			if ('publish' === $new_status) {

				$segments = array();
				$image_url = null;

				if (('publish' === $new_status && 'future' === $old_status)) {

					$pushassist_checkbox_array = get_post_meta($pushassist_post_id, '_pushassist_checkbox_override', true);

					$pushassist_post_notification_text = get_post_meta($pushassist_post_id, '_pushassist_custom_text', true);

				}

				if (!empty($pushassist_checkbox_array) || (true === $psa_auto_push && 'future' === $old_status)) {

					if (isset($_POST['pushassist_segment_categories']) and !empty($_POST['pushassist_segment_categories'])) {

						$segments = $_POST['pushassist_segment_categories'];
					}

					if (!empty($pushassist_post_notification_text)) {

						$notification_title_text = sanitize_text_field(substr(get_the_title($pushassist_post_id), 0, 100));

						$notification_message_text = sanitize_text_field(substr(stripslashes($pushassist_post_notification_text), 0, 138));

					} else {

						$notification_title_text = sanitize_text_field(substr(get_the_title($pushassist_post_id), 0, 100));

						if(isset($pushassist_settings['psaPostMessage'])){

							$notification_message_text = sanitize_text_field(substr(stripslashes($pushassist_settings['psaPostMessage']), 0, 138));

						} else {

							$notification_message_text = sanitize_text_field(substr(stripslashes(__('We have just published an article, check it out!', 'push-notification-for-wp-by-pushassist')), 0, 138));
						}
					}

					if($psaPostLogoImage == false) {

						if (has_post_thumbnail($pushassist_post_id)) {

							$thumbnail_image = wp_get_attachment_image_src(get_post_thumbnail_id($pushassist_post_id));

							$image_url = $thumbnail_image[0];
						}
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
						"image" => $image_url),
						"utm_params" => array("utm_source" => $utm_source,
							"utm_medium" => $utm_medium,
							"utm_campaign" => $utm_campaign),
						"segments" => $segments
					);

					$notification_request_data = array("appKey" => trim($appKey),
						"appSecret" => trim($appSecret),
						"action" => "notifications/",
						"method" => "POST",
						"remoteContent" => $notification
					);

					$notification_response = self::puhsassist_decode_request($notification_request_data);
				}
			}
		}
	}

	public function puhsassist_remote_request($remote_data)
	{
		$remote_url = 'https://api.pushassist.com/' . $remote_data['action'];

		$headers = array(
			'X-Auth-Token' => $remote_data['appKey'],
			'X-Auth-Secret' => $remote_data['appSecret'],
			"Content-Type" => 'application/json'
		);

		$remote_array = array(
			'method' => $remote_data['method'],
			'headers' => $headers,
			'body' => json_encode($remote_data['remoteContent']),
		);

		$response = wp_remote_request(esc_url_raw($remote_url), $remote_array);

		return $response;
	}

	public function puhsassist_decode_request($remote_data)
	{	
		$remote_request_response = self::puhsassist_remote_request($remote_data);

		$retrieve_body_content = wp_remote_retrieve_body($remote_request_response);

		$response_array = json_decode($retrieve_body_content, true);

		return $response_array;
	}
}
