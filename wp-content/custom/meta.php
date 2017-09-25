<link rel="stylesheet" href="<?php echo WP_CONTENT_URL; ?>/custom/plugins/filtro-me/filtro-me.css">
<script   type="text/javascript" src="<?php echo WP_CONTENT_URL; ?>/custom/plugins/filtro-me/filtro-me.js"></script>

<link rel="stylesheet" href="<?php echo WP_CONTENT_URL; ?>/custom/plugins/windbox/windbox.css" media="none" onload="if(media!='all')media='all'">
<link rel="stylesheet" href="<?php echo WP_CONTENT_URL; ?>/custom/plugins/windbox/windbox_lightbox.css" media="none" onload="if(media!='all')media='all'" >
<link rel="stylesheet" href="<?php echo WP_CONTENT_URL; ?>/custom/plugins/windbox/windbox_onlyimage.css" media="none" onload="if(media!='all')media='all'" >
<script type="text/javascript" src="<?php echo WP_CONTENT_URL; ?>/custom/plugins/windbox/windbox.js"></script>


	
	<link rel="stylesheet" href="<?php echo WP_CONTENT_URL; ?>/custom/css/menu.css">
	<link rel="stylesheet" href="<?php echo WP_CONTENT_URL; ?>/custom/css/custom.css">
	<script src="<?php echo WP_CONTENT_URL; ?>/custom/js/menu.js"></script>
	<script src="<?php echo WP_CONTENT_URL; ?>/custom/js/custom.js"></script>

<script   type="text/javascript" src="<?php echo WP_CONTENT_URL; ?>/custom/js/default.js"></script>
<script   type="text/javascript" src="<?php echo WP_CONTENT_URL; ?>/custom/js/popup.js"></script>


<script type="text/javascript">
<?php

		 $sandBox = isset($_GET['sandbox'])?$_GET['sandbox']:null;

			

		   if($sandBox != null){		 	
		   	echo "windbox('popup').show();";		  
		   }	
		 
	?>

	
	/*if(cookie.get('popup_blackfriday') != 'seen'){				
	   	windbox('blackfriday').show();
	   	cookie.set('popup_blackfriday','seen');	   
	}*/

	if(cookie.get('popup_check') != 'seen'){		
			setTimeout(function(){	
				windbox('popup').show();
				cookie.set('popup_check','seen');
			},20000);				
	}

</script>
