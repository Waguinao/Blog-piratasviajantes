<?php
/*
 * Author: Wallace Rio <wallacerio@wallrio.com>
 *
 */

class WPNewsFunctions{

	private function __construct(){}

    /**
     * captura o conteúdo de um arquivo e aloca em uma variavel
     * @param  [string] $filename 
     * @return [string]        
     */
    public static function requireToVar($filename){       
        
    	if(!file_exists($filename)){return null;}
        $file = $filename;          
        ob_start();
        include sprintf('%s', $file);
        $content = ob_get_clean(); 
        return  $content;
    }

    public static function textLimit($string,$length = 15,$reticence = '...'){
        $string = strip_tags($string);
        $stringCut = substr($string, 0,$length);
        $pos = strrpos($stringCut, ' ');
        if($pos === false){
            $pos = $length;
            $reticence = "";
        }
        $stringCut = substr($stringCut, 0,$pos);        
        $result = $stringCut.$reticence;    
        return $result;
    }

}

?>