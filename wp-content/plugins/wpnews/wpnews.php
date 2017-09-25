<?php
/*
Plugin Name: WpNews
Plugin URI: http://wallrio.com/dev/wordpress/plugins/wpnews
Description: Captura as postagens de uma determinada categoria e exibe em forma de notícias
Version: 1.0
Author: Wallace Rio <wallrio@gmail.com>
Author URI: http://wallrio.com
Version: v1.0
License: GPLv2
*/

define('_PLUGINPATH_',plugin_dir_path( __FILE__ ).'');
define('_PLUGINURL_',plugin_dir_url( __FILE__ ).'');

// include static class of basic functions
require_once "libs/WPNewsFunctions.php";

class Wpnews {

	public static $title = "WpNews";
	public static $pluginPath;
	public static $pluginUrl;

	public static $parameters;

	public function enable(){
		add_option('wpnews', '');
	}

	public function disable(){
		delete_option('wpnews');
	}

	public function shortCode(){				
	}

	public function makeMenu(){		 

		self::$pluginPath = plugin_dir_path( __FILE__ );
		self::$pluginUrl = plugin_dir_url( __FILE__ );

		$plugin_icon_path = self::$pluginUrl.'assets/img/icon.png';
		add_menu_page('wpnews', 'Wpnews','manage_options', 'wpnews',array('Wpnews','managerContent'),$plugin_icon_path); 		
		add_submenu_page('wpnews', 'Sobre...', 'Sobre...', 'manage_options', 'wpnews_about',array('Wpnews','sobreContent'));
	}

	public function managerContent(){			
		/*$html = Functions::requireToVar(self::$pluginPath.'app/manager/meta.php');
		$html .= Functions::requireToVar(self::$pluginPath.'app/manager/view.php');			    	
    	echo $html;*/
    	
    	// adiciona um editor TinyMCE
    	//$mytext_var="Some Text";
		//wp_editor($mytext_var,'id_do_editor');
		//get_search_form( "a");
		//
		
	}

	public function sobreContent(){
		/*$html = Functions::requireToVar(self::$pluginPath.'app/about/meta.php');
		$html .= Functions::requireToVar(self::$pluginPath.'app/about/view.php');			    	
    	echo $html;*/
	}
	

	public function show( $atts ){

		self::$pluginPath = plugin_dir_path( __FILE__ );
		self::$pluginUrl = plugin_dir_url( __FILE__ );

		define("__pluginPath__",self::$pluginPath);
		define("__pluginUrl__",self::$pluginUrl);

		$id = isset($atts['id'])?$atts['id']:null;
		$category = isset($atts['category'])?$atts['category']:null;
		$slug = isset($atts['slug'])?$atts['slug']:null;
		$file = self::$pluginPath.'app/show/Show_control.php';
		
		$maxcolumn = isset($atts['maxcolumn'])?$atts['maxcolumn']:3;
		$titlehide = isset($atts['titlehide'])?$atts['titlehide']:false;
		$maxwords = isset($atts['maxwords'])?$atts['maxwords']:null;
		$duration = isset($atts['duration'])?$atts['duration']:3000;
		$titlenews = isset($atts['titlenews'])?$atts['titlenews']:null;
		$class = isset($atts['class'])?$atts['class']:'tabFlat';
		$template = isset($atts['template'])?$atts['template']:null;
		$maxitens = isset($atts['maxitens'])?$atts['maxitens']:'-1';
		$itembypage = isset($atts['itembypage'])?$atts['itembypage']:5;
		$forcenavigation = isset($atts['forcenavigation'])?$atts['forcenavigation']:false;

		$catObj = get_category_by_slug($slug); 

		if($titlenews == null){
			$titlenews = '<h1>'.$catObj->name.'</h1>';
		}
		

		self::$parameters =(object) array(
			'category'=>$category,
			'slug'=>$slug,
			'maxcolumn'=>$maxcolumn,
			'titlehide'=>$titlehide,
			'maxwords'=>$maxwords,
			'duration'=>$duration,
			'titlenews'=>$titlenews,
			'class'=>$class,
			'template'=>$template,
			'itembypage'=>$itembypage,
			'maxitens'=>$maxitens,
			'forcenavigation'=>$forcenavigation
			);
		if(!class_exists('Show_control'))
		WPNewsFunctions::requireToVar($file);
			
		$show = new Show_control();
		$html = $show->show($category);
    	 return $html;
	}

	
	
}
new Wpnews;

Wpnews::shortCode();

$pathPlugin = _PLUGINPATH_;

// show in page
add_shortcode( 'wpnews', array('Wpnews','show') );

// register_activation_hook( $pathPlugin, array('Wpnews','enable'));
// register_deactivation_hook( $pathPlugin, array('Wpnews','disable'));
 
// add the menu on panel admin
add_action('admin_menu', array('Wpnews','makeMenu'));






wp_enqueue_style( 'wpnews', plugin_dir_url( __FILE__ ).'/app/mceditor/js/default.css' );
// wp_enqueue_script( 'wpnews', plugin_dir_url( __FILE__ ).'/app/show/_assets/plugins/jquery/jquery.min.js' , array(), '1.0.0', true );


add_action('init', 'wpnews_button');
function wpnews_register_button( $buttons ) {
    $buttons[] = "wpnews";
    return $buttons;
}

function wpnews_add_plugin( $plugin_array ) {
   
   $plugin_array['wpnews'] = plugin_dir_url(__FILE__) . '/app/mceditor/js/wpnews.js';
   return $plugin_array;
}
function wpnews_button() {
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
      return;
   }
   if ( get_user_option('rich_editing') == 'true' ) {
      add_filter( 'mce_external_plugins', 'wpnews_add_plugin' );
      add_filter( 'mce_buttons', 'wpnews_register_button' );
   }

}
