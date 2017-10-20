<?php

class Show_control{

	private $viewPath;
	private $viewMetaPath;

	public function __construct(){		
		$this->viewPath = dirname(__FILE__).'/Show_view.php';		
		$this->viewMetaPath = dirname(__FILE__).'/_html/meta.php';		
	}

	public function show($category = null){						
		return $this->readView();
	}

	private function readView(){

		$html = WPNewsFunctions::requireToVar($this->viewMetaPath);
		$html .= WPNewsFunctions::requireToVar($this->viewPath);
		return $html;
	}
}