<?php 

class Manager_control {

	public static $listGallery = null;

	function __construct(){
		
	}

	public static function init(){
	
		View::setHeaderCss(
			array(
				_PLUGINURL_."app/_public/plugins/mebox/mebox.css",
				_PLUGINURL_."app/_public/css/"."manager.css"
			)
		);	


		$html = '<script type="text/javascript" >'
				. 'var path = {'
				. '"_PLUGINURL_":"'._PLUGINURL_.'"'
				. '};'				
				. '</script>';

    	echo $html;
    	//echo '<script  src="'._PLUGINURL_.'app/_public/js/'.'jquery.js" ></script>';
    	//echo '<script  src="'._PLUGINURL_.'app/_public/js/'.'manager.js" ></script>';

		View::setHeaderJs(
			array(
				  _PLUGINURL_."app/_public/js/"."jquery.js",
				  _PLUGINURL_."app/_public/plugins/mebox/mebox.js",
				  _PLUGINURL_."app/_public/js/"."Box.js",
				  _PLUGINURL_."app/_public/js/"."manager.js"
			)
		);	


		
		

		/*$gallerys = self::getGallerys();
		$gallerys_html = "";
		foreach ($gallerys as $key => $value) {
			$gallerys_html .= "<li><a onclick=manager.selGallery('".json_encode($value)."');>".$value['name']."</a></li>";
		}*/


		self::$listGallery = '';//$gallerys_html;

		$view_index = Basic::requireToVar( _PLUGINPATH_."app/manager/view/index.php");
		echo $view_index;

		


	}



}

