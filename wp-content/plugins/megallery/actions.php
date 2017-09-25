<?php

// load wordpress functions
    require( '../../../wp-load.php' );
    require_once _PLUGINPATH_."Acts.php";

    $type = $_POST['type'];
    $data = $_POST['data'];
    $data2 = null;

    $upload_dir = wp_upload_dir();
    $pathGallery = $upload_dir['basedir'].'/megallery/';
    $urlGallery = $upload_dir['baseurl'].'/megallery/';

    if(!is_dir($pathGallery))
        mkdir($pathGallery);
    //print_r($_FILES);
    

    switch ($type) {
        case 'sendItem':

            $gallery = $_POST['gallery'];
            

            /*$files = $_FILES['file'];

            $file_name = $files['name'];
            $file_type = $files['type'];
            $file_tmp_name = $files['tmp_name'];
            $file_error = $files['error'];
            $file_size = $files['size'];*/
            $filesAll = array_values($_FILES);

            //print_r($filesAll);

            for ($i=0;$i<=count($filesAll)-1;$i++) {
                $files = $filesAll[$i];
                //$files = $files['file'];

                $file_name = $files['name'];
                $file_type = $files['type'];
                $file_tmp_name = $files['tmp_name'];
                $file_error = $files['error'];
                $file_size = $files['size'];

                $title = $file_name;
                $title = substr($title,0,strrpos($title, '.'));

                $description = $title;
                $link = '';
                $target = '';

                $file_name = strtolower($file_name);
                $file_name = str_replace(' ', '-', $file_name);

                //echo $file_name.'-';
                move_uploaded_file($file_tmp_name, $pathGallery.$gallery.'/'.$file_name);  
                
               // $file_name = substr($file_name,0,strrpos($file_name, '.'));

                $ItemArray = Acts::saveItem($pathGallery,$gallery,$file_name,$title,$description,$link,$target);
            }

            //move_uploaded_file($file_tmp_name, $pathGallery.$gallery.'/'.$file_name);
            
            $data = $data;
            $status = 'success';
        break;
        case 'getGallery':

            $ItemArray = Acts::getGallerys();

            if($ItemArray == null){
                $data = 'nodir' ;
                $status = 'nodir';
                break;
            }

        $gallerys = $ItemArray;
        $gallerys_html = "";
        $gallerys_html .= "<nav class='menuListGallery'>";
        $gallerys_html .= "<ul>";
        foreach ($gallerys as $key => $value) {
            $gallerys_html .= "<li><a onclick=manager.selGallery('".json_encode($value)."',this);>".$value['name']."</a></li>";
        }
        $gallerys_html .= "</ul>";
        $gallerys_html .= "</nav>";
        
                        
                            
            $data = $gallerys_html ;
            $status = 'success';

        break;
        case 'delGallery':
            $gallery = $data['gallery'];
            $ItemArray = Acts::delGallery($pathGallery,$gallery);

            $data = $data ;
            $status = 'success';
        break;
        case 'saveGallery':
            
            $ItemArray = Acts::saveGallery($data);

            $data = $data ;
            $status = 'success';

        break;
        case 'makeGallery':

            $gallery = $data['gallery'];
            $ItemArray = Acts::makeGallery($pathGallery,$gallery);

            $data = $data ;
            $status = 'success';
        break;
        case 'saveItem':
        
            $gallery = $data['gallery'];
            $item  = $data['item'];
            $title  = $data['title'];
            $description  = $data['description'];
            $link  = $data['link'];
            $target  = $data['target'];

            $ItemArray = Acts::saveItem($pathGallery,$gallery,$item,$title,$description,$link,$target);

            $data = null;
            $status = 'success';

        break;
        case 'loadItem':
           
            $gallery = $data['gallery'];
            $item  = $data['item'];

            $ItemArray = Acts::loadItem($pathGallery,$gallery,$item);

            $data = $ItemArray;
            $status = 'success';
        break;

        case 'delItem':
           
            $gallery = $data['gallery'];
            $item  = $data['item'];

            $ItemArray = Acts::delItem($pathGallery,$gallery,$item);

            $data = null;
            $status = 'success';
        break;
        case 'loadGallery':
            
            $galleryArray = Acts::loadGallery($data);
           
            if($galleryArray == null){
                //$galleryHtml = "<div>Not found itens</div>";
                $galleryHtml = "<div><a class='btadd_item' onclick=manager.item().add()><img src='". _PLUGINURL_."/app/_public/img/add_item.png'></a></div>";
            }else{
                $galleryHtml = "<div><a class='btadd_item' onclick=manager.item().add()><img src='". _PLUGINURL_."/app/_public/img/add_item.png'></a></div>";
                $galleryHtml .= Acts::HtmlGallery($urlGallery,$data,$galleryArray);
            }

            $pathInfoGallery = $pathGallery.''.$data.'/info/info.json';

            $data = $galleryHtml;
            if(file_exists($pathInfoGallery)){
                $data2 = file_get_contents($pathInfoGallery);
            }

            $status = 'success';
            
            break;    
        default:
            $status = 'error';
            $data = 'null';
            break;
    }

    $resultArray = array("status" => $status,"data"=>$data,"data2"=>$data2);
    echo json_encode($resultArray);

