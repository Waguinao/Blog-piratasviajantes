<?php

class View{

	public static function setHeaderCss($array){
		wp_register_style('megallery-responsible', _PLUGINURL_."app/_public/css/responsible.css");
		wp_register_style('megallery-default', _PLUGINURL_."app/_public/css/default.css");
		wp_enqueue_style('megallery-responsible');
		wp_enqueue_style('megallery-default');      

		$index = 0;
		foreach ($array as $key => $value) {
			wp_register_style('megallery-custom'.$index, $value);
			wp_enqueue_style('megallery-custom'.$index);      
			$index++;	
		}
    }

    public static function setHeaderJs($array){

		wp_register_script('megallery-default', _PLUGINURL_."app/_public/js/default.js");		
		wp_enqueue_script('megallery-default');      

		$index = 0;
		foreach ($array as $key => $value) {
			wp_register_script('megallery-custom'.$index, $value);
			wp_enqueue_script('megallery-custom'.$index);      
			$index++;	
		}
    }


   

   

}