<?php



$protocol = ((strpos($_SERVER['SERVER_PROTOCOL'],"https")!= false)?"https://":"http://");
		$PHP_SELF = dirname($_SERVER['PHP_SELF']);
		$url = $protocol.$_SERVER['HTTP_HOST'].$PHP_SELF;

$itembypage = Wpnews::$parameters->itembypage;
$maxitens = Wpnews::$parameters->maxitens;
$forcenavigation = Wpnews::$parameters->forcenavigation;





$navigation = '';
if($forcenavigation == true){
	$pageCurrent = isset($_GET['navigation'])?$_GET['navigation']:1;
	$offsetPage = ($pageCurrent-1) * $itembypage;
	$args = array(
		'category_name'    => Wpnews::$parameters->slug, 
	);
	$the_query = new WP_Query( $args );
	
	$posts_count =  $the_query->found_posts;
	$pagesCount = ceil($posts_count / $itembypage);
	$navigationBefore = $pageCurrent - $itembypage;
	if($navigationBefore < 1)$navigationBefore = 0;

	$navigationAfter = $pageCurrent + $itembypage;
	if($navigationAfter > $pagesCount)$navigationAfter = $pagesCount;

	$navigation = '<nav class="navigation">';
	$navigation .= '<ul>';

	if($pageCurrent > ($itembypage))
	$navigation .= '<li date-rel="totalPage"><a href="?navigation=1">1</a></li>';

	for ($i=$navigationBefore; $i < $navigationAfter; $i++) { 

		$status = '';
		if($i+1 == $pageCurrent)
			$status = 'data-status="active"';
		
		$link = '?navigation='.($i+1);
		
		$navigation .= '<li '.$status.' >';	
		$navigation .= '<a href="'.$link.'" >'.($i+1).'</a>';
		$navigation .= '</li>';
	}
		if($pageCurrent+$itembypage < ($pagesCount))
		$navigation .= '<li date-rel="totalPage"><a href="?navigation='.$pagesCount.'">'.$pagesCount.'</a></li>';
	$navigation .= '</ul>';
	$navigation .= '</nav>';
}else{
	$offsetPage = 0;
	// $itembypage = -1;
}



 $args = array(	
	'posts_per_page'   => $itembypage,
	'offset'          => $offsetPage,
	// 'offset'           => 0,
	// 'category'         => Wpnews::$parameters->slug,
	'category_name'    => Wpnews::$parameters->slug,
	'orderby'          => 'date',
	'order'            => 'DESC',
	/*'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',*/
	'post_type'        => 'post',
	// 'post_mime_type'   => '',
	// 'post_parent'      => '',
	// 'author'	   => '',
	'post_status'      => 'publish',
	// 'suppress_filters' => true ,
	'numberposts'   => $maxitens,
);

// echo Wpnews::$parameters->slug;

// $args = array( 'numberposts' => 10, 'category_name' => Wpnews::$parameters->slug );
/*if($maxitens == null)
  $args['numberposts'] = $maxitens;*/

$posts_array = get_posts( $args ); 

/*echo '<pre>';
print_r($posts_array);
echo '</pre>';*/

$index = 0;
foreach ($posts_array as $key => $value) {
	$newsPost[$index]['content'] = $value->post_content;
	$newsPost[$index]['date_created'] = $value->post_date;
	$newsPost[$index]['title'] = $value->post_title;
	$newsPost[$index]['status'] = $value->post_status;
	$newsPost[$index]['name'] = $value->post_name;
	$newsPost[$index]['date_modified'] = $value->post_modified;
	$newsPost[$index]['guidurl'] = $value->guid;
	$newsPost[$index]['ID'] = $value->ID;
	
	$index++;
}
	
	$themeDir = get_template_directory();
	
	$template = Wpnews::$parameters->template;
	$class = Wpnews::$parameters->class;

	$linkTitle = 'continuar lendo >';
	$maxColumn = Wpnews::$parameters->maxcolumn;
	$content_box = '';
	$link_box = '';
	$index = 0;
	$indexFull = 0;
	$indexTab = 0;
foreach ($newsPost as $key => $value) {

	// print_r($value);
	//$value['guidurl']

	$ID = strip_tags($value['ID']);
	
	$post_id = $ID;

	$urlPage = $url.'?p='.$ID;

	$title = strip_tags($value['title']);	
	if(Wpnews::$parameters->titlehide == "true"){
		$title = "";
	}

	
	
	$date_modified = $value['date_modified'];
	$date_day = Date('d',strtotime($date_modified));
	$date_month = Date('M',strtotime($date_modified));

	// echo Date('Y',strtotime($date_modified)).'--'.$date_modified;

	$contentReal = $value['content'];
	$content = $value['content'];

	preg_match_all('/<img[^>]+>/i',$content, $result); 
			$result = array_filter($result);

			preg_match_all('/src=[\'"]?([^\'" >]+)[\'" >]/',$content, $result2); 			
			/*
			*/
	$post_aneximage = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
	if($post_aneximage){
		$post_img = '<img src="'.$post_aneximage.'">';
		// $post_aneximage = $post_aneximage;
	}else{
		
		$post_img = $result[0][0];
		$post_aneximage = $result2[1][0];
	}
	


	$content = strip_tags($content);
	if(Wpnews::$parameters->maxwords != null){
		$content = WPNewsFunctions::textLimit($content,Wpnews::$parameters->maxwords,'.');
	}

	$active = "";
	if($indexFull === 0){
		$active = 'data-status="active"';
	}

	if($index == 0){
		$indexTab++;

		// $link_box .= ' <a data-for="boxContent'.$key.'" data-rel="metabs_tab" '.$active.' >'.$indexTab.'</a>';
		$forcenavigation_style = '';
		if($forcenavigation == true)
			$forcenavigation_style = 'style="display:none !important"';

		$link_box .= '<a data-rel="tab" data-for="wpnews'.$key.'" '.$active.' '.$forcenavigation_style.' >'.$indexTab.'</a>';

		
       

		// $content_box .= "<div id='boxContent".$key."' data-rel='metabs_content' >";
		$content_box .= "<div data-rel='slide' data-id='wpnews".$key."'>";
		$content_box .= "<div class='row'>";
		
	}


		$content_box .= "<div class='column col9 top' data-type='nivel1'>";

		if($template == null){
			$content_box .= "<div class='row'>";
				$content_box .= "<div class='column col12 top' data-type='icon'>";
				$content_box .= $post_img;
				$content_box .= "</div>";
				$content_box .= "<div class='column col2 top'>";		
						$content_box .= "<div class='calend'><span>".$date_day."</span><label>".$date_month."</label></div>";					
						$content_box .= "<h3>".$title."</h3>";			
				$content_box .= '<p>'.$content.'<a href="'.$urlPage.'">'.$linkTitle.'</a>'.'</p>';	
				$content_box .= "</div>";

			$content_box .= "</div>";
		}else{

			$templatePreUrl = $template;				
			$templatePreUrl = str_replace('{theme-dir}', $themeDir, $templatePreUrl);

			$templatePre = file_get_contents($templatePreUrl);				

			$templatePre = str_replace('{wpnews-img}', $post_img, $templatePre);
			$templatePre = str_replace('{wpnews-img-url}', $post_aneximage, $templatePre);
			$templatePre = str_replace('{wpnews-title}', $title, $templatePre);
			$templatePre = str_replace('{wpnews-content}', $content, $templatePre);
			$templatePre = str_replace('{wpnews-content-full}', $contentReal, $templatePre);
			$templatePre = str_replace('{wpnews-url}', $urlPage, $templatePre);
			$templatePre = str_replace('{wpnews-day}', $date_day, $templatePre);
			$templatePre = str_replace('{wpnews-month}', $date_month, $templatePre);
			$templatePre = str_replace('{wpnews-moresee}', $linkTitle, $templatePre);

			$content_box .= $templatePre;
		}

		$content_box .= "</div>";
	

	if($index >= ($itembypage-1)){
		$content_box .= "</div>";
		$content_box .= "</div>";
		$index = -1;
	}
	
	$index++;
	$indexFull++;
}


	?><div class="<?php echo $class; ?>"><?php echo Wpnews::$parameters->titlenews;?><div class="itabs tabFlat <?php echo $class; ?>" data-autoslide="<?php echo Wpnews::$parameters->duration;?>"><div data-rel="progress"> <span></span> </div><div data-rel="tabs" > <?php echo $link_box; ?> </div> <div data-rel="slides"> <?php echo $content_box; ?> </div> </div> <?php echo $navigation; ?></div>
