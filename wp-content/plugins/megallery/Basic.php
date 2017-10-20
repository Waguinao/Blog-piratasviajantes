<?php

class Basic{
	
	

	/**
     * captura o conteúdo de um arquivo e aloca em uma variavel
     */
    public static function includeToVar($filename){       
        $file = $filename;          
        ob_start();
        include sprintf('%s', $file);
        $content = ob_get_clean(); 
        return  $content;
    }

    public static function requireToVar($filename){       
        $file = $filename;          
        ob_start();
        require_once sprintf('%s', $file);
        $content = ob_get_clean(); 
        return  $content;
    }

    public static function delTree($dir) {
       $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
          (is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
      } 
}