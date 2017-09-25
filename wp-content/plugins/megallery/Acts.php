<?php

class Acts{

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

	public static function getGallerys(){
		$upload_dir = wp_upload_dir();
	    $pathGallery = $upload_dir['basedir'].'/megallery/';//_PLUGINPATH_.'app/_public/gallerys/';
	    $urlGallery = $upload_dir['baseurl'].'/megallery/';//_PLUGINURL_.'app/_public/gallerys/';


		//$pathGallery = _PLUGINPATH_."app/_public/gallerys/";
		if(file_exists($pathGallery)){
			$dir = scandir($pathGallery);
			$index = 0;
			foreach ($dir as $key => $value) {
				if($value != '.' && $value != '..' && is_dir($pathGallery.'/'.$value)){
				
					$gallerys[$index]['name'] = $value;
					$gallerys[$index]['title'] = ucfirst($value);
					$gallerys[$index]['path'] = $pathGallery.''.$value;
					$gallerys[$index]['count'] = self::countFiles($pathGallery.''.$value);
					$index++;
				}
			}
			return $gallerys;
		}else{
			return null;
		}
	}




	public static function delGallery($pathGallery,$gallery){
			$upload_dir = wp_upload_dir();
		    $pathGallery = $upload_dir['basedir'].'/megallery/';//_PLUGINPATH_.'app/_public/gallerys/';
		    $urlGallery = $upload_dir['baseurl'].'/megallery/';//_PLUGINURL_.'app/_public/gallerys/';
		    $pathInfo = $upload_dir['basedir'].'/megallery/'.$gallery;


			//$pathInfo = _PLUGINPATH_.'app/_public/gallerys/'.$gallery;
			// if(file_exists($pathInfo.'/info')){
			// 	rmdir($pathInfo.'/info');
			// }
			// if(file_exists($pathInfo)){
			// 	rmdir($pathInfo);
			// }

			Basic::delTree($pathInfo);
			
			//$content = '{"title":"'.$title.'","description":"'.$description.'"}';		
			//file_put_contents($pathInfo, $content);

	}

	public static function makeGallery($pathGallery,$gallery){
			$upload_dir = wp_upload_dir();
		    $pathGallery = $upload_dir['basedir'].'/megallery/';//_PLUGINPATH_.'app/_public/gallerys/';
		    $urlGallery = $upload_dir['baseurl'].'/megallery/';//_PLUGINURL_.'app/_public/gallerys/';
		    $pathInfo = $upload_dir['basedir'].'/megallery/'.$gallery;

			//$pathInfo = _PLUGINPATH_.'app/_public/gallerys/'.$gallery;
			mkdir($pathInfo);
			mkdir($pathInfo.'/info');
			//$content = '{"title":"'.$title.'","description":"'.$description.'"}';		
			//file_put_contents($pathInfo, $content);

	}

	public static function saveItem($pathGallery,$gallery,$item,$title,$description,$link,$target){
			$upload_dir = wp_upload_dir();
		    $pathGallery = $upload_dir['basedir'].'/megallery/';//_PLUGINPATH_.'app/_public/gallerys/';
		    $urlGallery = $upload_dir['baseurl'].'/megallery/';//_PLUGINURL_.'app/_public/gallerys/';
		    $pathInfo = $upload_dir['basedir'].'/megallery/'.$gallery.'/info/'.$item.'.data';

			//$pathInfo = _PLUGINPATH_.'app/_public/gallerys/'.$gallery.'/info/'.$item.'.data';

			$content = '{"title":"'.$title.'","description":"'.$description.'","link":"'.$link.'","target":"'.$target.'"}';		
			file_put_contents($pathInfo, $content);
	}

	public static function loadItem($pathGallery,$gallery,$item){
		$upload_dir = wp_upload_dir();
	    $pathGallery = $upload_dir['basedir'].'/megallery/';//_PLUGINPATH_.'app/_public/gallerys/';
	    $urlGallery = $upload_dir['baseurl'].'/megallery/';//_PLUGINURL_.'app/_public/gallerys/';
	    $pathInfo = $upload_dir['basedir'].'/megallery/'.$gallery.'/info/'.$item.'.data';

		//$pathInfo = _PLUGINPATH_.'app/_public/gallerys/'.$gallery.'/info/'.$item.'.data';
	    $target = '';
	    $link = '';
		$title = '';
		$description = '';
		if(file_exists($pathInfo)){
			$pathInfoJson = file_get_contents($pathInfo);				
			$pathInfoObj = json_decode($pathInfoJson);
			$title = $pathInfoObj->title;
			$description = $pathInfoObj->description;
			$link = $pathInfoObj->link;
			$target = $pathInfoObj->target;
		}

		$array = array('title'=>$title,'description'=>$description,'link'=>$link,'target'=>$target);
		return $array;

	}

	public static function delItem($pathGallery,$gallery,$item){
		$upload_dir = wp_upload_dir();
	    $pathGallery = $upload_dir['basedir'].'/megallery/';//_PLUGINPATH_.'app/_public/gallerys/';
	    $urlGallery = $upload_dir['baseurl'].'/megallery/';//_PLUGINURL_.'app/_public/gallerys/';
	    $pathInfo = $upload_dir['basedir'].'/megallery/'.$gallery.'/info/'.$item.'.data';
	    $pathGal = $upload_dir['basedir'].'/megallery/'.$gallery.'/'.$item.'';

		//$pathInfo = _PLUGINPATH_.'app/_public/gallerys/'.$gallery.'/info/'.$item.'.data';

	    $status = "error";

		$title = '';
		$description = '';
		if(file_exists($pathInfo)){
			unlink($pathInfo);		
			$status = "success";
		}

		if(file_exists($pathGal)){
			unlink($pathGal);		
			$status = "success";
		}

		$array = array('status'=>$status);
		return $array;

	}

	public static function saveGallery($data){
		$upload_dir = wp_upload_dir();
	    $pathGallery = $upload_dir['basedir'].'/megallery/';//_PLUGINPATH_.'app/_public/gallerys/';
	    $urlGallery = $upload_dir['baseurl'].'/megallery/';//_PLUGINURL_.'app/_public/gallerys/';

		$gallery = $data['gallery'];
        $gallery_mode = $data['gallery_mode'];
        $gallery_delay = $data['gallery_delay'];

        $pathInfo = $pathGallery.$gallery.'/info/info.json';

        $datajson = json_encode(array("mode"=>$gallery_mode,"sliderdelay"=>$gallery_delay));

        file_put_contents($pathInfo, $datajson);
	}
	public static function loadGallery($gallery){
		$upload_dir = wp_upload_dir();
	    $pathGallery = $upload_dir['basedir'].'/megallery/';//_PLUGINPATH_.'app/_public/gallerys/';
	    $urlGallery = $upload_dir['baseurl'].'/megallery/';//_PLUGINURL_.'app/_public/gallerys/';


		$dirArray = null;
		$dir = scandir($pathGallery.$gallery);
		foreach ($dir as $key => $value) {
			if($value != '.' && $value != '..' && !is_dir($pathGallery.$gallery.'/'.$value )){
				$dirArray[] = $value;	
			}
			
		}
		
		return $dirArray;
	}

	public static function HtmlGallery($urlGallery,$galleryName,$valueArray){
		$html = '';

		$upload_dir = wp_upload_dir();
	    $pathGallery = $upload_dir['basedir'].'/megallery/';//_PLUGINPATH_.'app/_public/gallerys/';
	    $urlGallery = $upload_dir['baseurl'].'/megallery/';//_PLUGINURL_.'app/_public/gallerys/';
	    

		$index = 0;
		$countColumn = 0;
		foreach ($valueArray as $key => $value) {

			$pathInfo = $upload_dir['basedir'].'/megallery/'.$galleryName.'/info/'.$value.'.data';

			//$pathInfo = _PLUGINPATH_.'app/_public/gallerys/'.$galleryName.'/info/'.$value.'.data';

			$title = '&nbsp;';
			$description = '&nbsp;';
			if(file_exists($pathInfo)){
				$pathInfoJson = file_get_contents($pathInfo);				
				$pathInfoObj = json_decode($pathInfoJson);
				$title = $pathInfoObj->title;
				$description = $pathInfoObj->description;
			}


			if($countColumn >3){
				$countColumn = 0;
			}

			if($countColumn == 0 && $index > 0){
				$html .= '</div>';
			}	

			if($countColumn == 0){
				$html .= '<div class="row">';
			}
			$html .= '<div class="column " style="width:25%" >';
				
				$html .= '<div class="megallery_item" onclick=manager.selItem("'.$galleryName.'","'.$value.'") style="background: #fff url(\''.$urlGallery.$galleryName.'/'.$value.'\')" >';				
				$html .= '<div class="info">'.($index+1).'</div>';
				$html .= '<div class="legend">'.$title.'</div>';
				$html .= '<div class="control"><a onclick=manager.delItem("'.$galleryName.'","'.$value.'") >del</a></div>';
				$html .= '</div>';
			$html .= '</div>';

			$index++;
			$countColumn++;
		}
		$html .= '</div>';

		return $html;

	}




	public static function HtmlGalleryUser($urlGallery,$galleryName,$valueArray){

		$infoGallery_mode = "gallery";
		$sliderdelay = "8000";

		$html = '';

		$upload_dir = wp_upload_dir();
	    $pathGallery = $upload_dir['basedir'].'/megallery/';//_PLUGINPATH_.'app/_public/gallerys/';
	    $urlGallery = $upload_dir['baseurl'].'/megallery/';//_PLUGINURL_.'app/_public/gallerys/';
	    
	    $pathInfoGallery = $upload_dir['basedir'].'/megallery/'.$galleryName.'/info/info.json';
	    if(file_exists($pathInfoGallery)){
	    	$infoGallery = file_get_contents($pathInfoGallery);
	    	$infoGallery = json_decode($infoGallery);

	    	$infoGallery_mode = $infoGallery->mode;
	    	$sliderdelay = isset($infoGallery->sliderdelay)?$infoGallery->sliderdelay:"8000";

	    }
		$index = 0;
		$countColumn = 0;

		
		$tabs = "";
		$contents = "";

		if(!isset($valueArray)){
			$valueArray =  array('');
		}
		

		foreach ($valueArray as $key => $value) {

			$pathInfo = $upload_dir['basedir'].'/megallery/'.$galleryName.'/info/'.$value.'.data';

			$title = '&nbsp;';
			$description = '&nbsp;';
			$link = '';
			$linkshow = '';

			$title = null;
			$description = null;
			$link = null;
			$target = null;

			if(file_exists($pathInfo)){
				$pathInfoJson = file_get_contents($pathInfo);				
				$pathInfoObj = json_decode($pathInfoJson);
				$title = isset($pathInfoObj->title)?$pathInfoObj->title:null;
				$description = isset($pathInfoObj->description)?$pathInfoObj->description:null;
				$link = isset($pathInfoObj->link)?$pathInfoObj->link:null;
				$target = isset($pathInfoObj->target)?$pathInfoObj->target:null;
			}

			if($infoGallery_mode == "compact"){				
				$active = "";
				if($tabs == ""){
					$active = "active";
				}

				$imageEmpty = _PLUGINURL_.'app/_public/img/empty_meddle.png';

				if(empty($value)){
					$imgtab = $imageEmpty;	
				}else{
					$imgtab = $urlGallery.$galleryName.'/'.$value;	
				}

				$tabs .= "<a data-for='formContent".$index."' data-rel='metabs_tab' data-state='".$active."' style='background:url(\"".$imgtab."\");'>";
				$tabs .= "<img src='".$imgtab."' style='width:50px;visibility:hidden'>";
				$tabs .= "</a>";

				
				
				
				$contents .= "<div id='formContent".$index."' data-rel='metabs_content'  >";
				if($link != null){
					$contents .= '<a href="'.$link.'" target="'.$target.'">';
				}
			    $contents .= "<div class='metabs_content' style='background:url(\"".$imgtab."\")'>";
			    if($title != null){
			    	$contents .= '<div class="gallery_compact_title" style="margin-top:10px;white-space:nowrap;overflow:hidden;width:219px;text-align:left">'.$title.'</div>';
				}
			    $contents .= "<img src='".$imgtab."' style='width:100%;visibility:hidden'>";
			    if($description != null){
			    	$contents .= '<div class="gallery_compact_legend">'.$description.'</div>';
				}
			    $contents .= "</div>";
			    if($link != null){
					$contents .= '</a>';
				}
			    $contents .= "</div>";

				$index++;						        						     
			}else{


				$imageEmpty = _PLUGINURL_.'app/_public/img/empty_meddle.png';

				if(empty($value)){
					$imgtab = $imageEmpty;	
				}else{
					$imgtab = $urlGallery.$galleryName.'/'.$value;	
				}

				if($countColumn >3){
					$countColumn = 0;
				}

				if($countColumn == 0 && $index > 0){
					//$html .= '</div>';
				}	

				if($countColumn == 0){
					//$html .= '<div class="row">';
				}
				$html .= '<div class="megallery_item_box" >';
					
					if($link != ''){
						$linkshow = 'href="'.$link.'"';
					}

				$html .= '<div  class="megallery_item_a" onclick="zoom(\''.$urlGallery.$galleryName.'/'.$value.'\');">';
				//$html .= '<div style="margin-top:10px;white-space:nowrap;overflow:hidden;width:219px;text-align:left">'.$title.'</div>';
				$html .= '<div class="megallery_item" style="background: #fff url(\''.$urlGallery.$galleryName.'/'.$value.'\')" >';				
				//$html .= '<div class="info">'.$index.'</div>';
				$html .= '<a class="legend" '.$linkshow.'> ‣ '.$description.'</a>';
				// $html .= '<div class="control"><a href="http://webfocosaopaulo.com.br/clientes/italiancoffe/site2/contato/#orcamento='.$description.'" > ‣ Orçamento</a></div>';
				$html .= '</div>';
				$html .= '</div>';

				$html .= '</div>';

				$index++;
				$countColumn++;



			}	
		}
		//$html .= '</div>';


		

		if($infoGallery_mode == "compact"){
			$html = "";
				$html .= "<div class='metabs2' data-metabs data-auto='true' data-delay='".$sliderdelay."'  >";
					$html .= "<div class='division'>";
						
								
						$html .= "<div class='division_content'>";
							$html .= $contents;							    
						$html .= "</div>";

						$html .= "<div class='division_tabs'>";
							$html .= "<div data-rel='tabContainer'>";
								$html .= $tabs;								
							$html .= "</div>";
						$html .= "</div>";
					$html .= "</div>";
				$html .= "</div>";
		}


		return $html;

	}


}
