<?php


class MeGallery extends Basic{

	public static $title = "MeGallery";
	public static $allModules_html = null;
	public static $enabledModules_html = null;

	public static function enable(){
		add_option('megallery', '');
	}

	public static function disable(){
		delete_option('megallery');
	}

	public static function shortCode(){
		
	}
	public static function makeMenu(){		 

		$plugin_icon_path = _PLUGINURL_.'app/_public/img/icon.png';
		add_menu_page('MeGallery', 'MeGallery','manage_options', 'megallery',array('MeGallery','managerContent'),$plugin_icon_path); 		
		add_submenu_page('megallery', 'Sobre...', 'Sobre...', 'manage_options', 'megallery_about',array('MeGallery','sobreContent'));
	}

	public static function managerContent(){	

		$html = self::requireToVar(_PLUGINPATH_.'app/manager/Manager_control.php');			
    	echo $html;
    	Manager_control::init();
	}

	public static function sobreContent(){
		$html = self::requireToVar(_PLUGINPATH_.'app/about/About_control.php');
		$about = new About_control();
    	echo $html;
	}
	

	public static function show( $atts ){
		$nameShortcode = $atts['id'];			
		$content = self::requireToVar(_PLUGINPATH_.'app/show/Show_control.php');			    	
    	$html = Show_control::init($nameShortcode);
    	
    	 return $html;
	}

	public static function jsInHead(){
		$html = '<script type="text/javascript" >'
				. '$(document).ready(function(){'
				. 'manager.getGallery();'		
				. '});'				
				. '</script>';

    	echo $html;
	}
	
}
new MeGallery;


MeGallery::shortCode();

$pathPlugin = _PLUGINPATH_;

// função mostra galeria para usuário
add_shortcode( 'megallery', array('MeGallery','show') );

// Função ativar
register_activation_hook( $pathPlugin, array('MeGallery','enable'));
 
// Função desativar
register_deactivation_hook( $pathPlugin, array('MeGallery','disable'));
 

//Ação de criar menu
add_action('admin_menu', array('MeGallery','makeMenu'));



