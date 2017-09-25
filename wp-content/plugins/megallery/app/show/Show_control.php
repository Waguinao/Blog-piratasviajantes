<?php 

class Show_control {

	public static $galleryHtml = null;

	function __construct(){
		
	}

	public static function init($nameShortcode){
		
		require_once _PLUGINPATH_."Acts.php";

		View::setHeaderCss(
			array(
				 _PLUGINURL_."app/_public/css/"."show.css"
			)
		);	


		$html = '<script type="text/javascript" >'
				. 'var path = {'
				. '"_PLUGINURL_":"'._PLUGINURL_.'"'
				. '};'				
				. '</script>';

    	
    	//echo '<script  src="'._PLUGINURL_.'app/_public/js/'.'jquery.js" ></script>';
    	//echo '<script  src="'._PLUGINURL_.'app/_public/js/'.'manager.js" ></script>';

		View::setHeaderJs(
			array(
				  _PLUGINURL_."app/_public/js/"."jquery.js",
				  _PLUGINURL_."app/_public/js/"."show.js"
			)
		);	



		/*$gallerys = self::getGallerys();
		$gallerys_html = "";
		foreach ($gallerys as $key => $value) {
			$gallerys_html .= "<li><a onclick=manager.selGallery('".json_encode($value)."');>".$value['name']."</a></li>";
		}


		self::$listGallery = $gallerys_html;*/
		
		$pathGallery = _PLUGINPATH_.'app/_public/gallerys/';
    	$urlGallery = _PLUGINURL_.'app/_public/gallerys/';

		$galleryArray = Acts::loadGallery($nameShortcode);
        //$galleryHtml = Acts::HtmlGallery($urlGallery,$nameShortcode,$galleryArray);

        
        self::$galleryHtml = Acts::HtmlGalleryUser($urlGallery,$nameShortcode,$galleryArray);

		$view_index = Basic::includeToVar( _PLUGINPATH_."app/show/view/index.php");

		$html .= $view_index;
		return $html;
	}



	public static function getGallerys(){
		$dirGallery = _PLUGINPATH_."app/_public/gallerys/";
		$dir = scandir($dirGallery);
		$index = 0;
		foreach ($dir as $key => $value) {
			if($value != '.' && $value != '..' && is_dir($dirGallery.'/'.$value)){
			
				$gallerys[$index]['name'] = $value;
				$gallerys[$index]['title'] = ucfirst($value);
				$gallerys[$index]['path'] = $dirGallery.''.$value;
				$gallerys[$index]['count'] = self::countFiles($dirGallery.''.$value);
				$index++;
			}
		}
		return $gallerys;
	}



	public static function countFiles($path){
		$count = 0;
		$dir = scandir($path);
		foreach ($dir as $key => $value) {
			if($value != '.' && $value != '..' && !is_dir($path.'/'.$value)){
				$count++;
			}
		}
		return $count;
	}
}

