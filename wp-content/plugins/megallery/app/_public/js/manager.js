var itemFocus = {};

var galleryFocus = null;



function Manager(){

	this.wordToDirectory = function(s){
            var r=s.toLowerCase();
            r = r.replace(new RegExp("\\s", 'g'),"");
            r = r.replace(new RegExp("[àáâãäå]", 'g'),"a");
            r = r.replace(new RegExp("æ", 'g'),"ae");
            r = r.replace(new RegExp("ç", 'g'),"c");
            r = r.replace(new RegExp("[èéêë]", 'g'),"e");
            r = r.replace(new RegExp("[ìíîï]", 'g'),"i");
            r = r.replace(new RegExp("ñ", 'g'),"n");                            
            r = r.replace(new RegExp("[òóôõö]", 'g'),"o");
            r = r.replace(new RegExp("œ", 'g'),"oe");
            r = r.replace(new RegExp("[ùúûü]", 'g'),"u");
            r = r.replace(new RegExp("[ýÿ]", 'g'),"y");
            r = r.replace(new RegExp("\\W", 'g'),"");

            r = r.toLowerCase();
            r = r.replace(/ /gi,'-');
            return r;
    };

	this.item = function(){
		var functions = {
			add:function(){

					var gallery = galleryFocus.name;

				var rules = {
					icon:':[info]',
					content:'Adicionar nova imagem para a galeria',
					fixed:true,
					full:false,
					inputControls:{
						'file':['file'],
						'type':['hidden','sendItem'],
						'gallery':['hidden',gallery],
						'br1':['br'],
						'progress':['progress2',0,100]
					},
					buttonControls:{'send':['submit','Enviar'],'cancel':['a','Cancel']},
					before:function(actions){
						actions.input.me('file').attr({'multiple':'multiple'});					
					},
					param_progress:{
						css:{
							'width':'97%',

						}
					},
					param_file:{
						attr:{'required':true},
						change:function(){						
							actions.input.me('send').css({'visibility':'visible'});
						}
					},					
					param_send:{
						css:{'visibility':'hidden'},
						click:function(){

							actions.top.icon(":[loading]");
							actions.top.content("Aguarde um momento...");
							//actions.input.hide();
							actions.input.me('send').css({'visibility':'hidden'});

							form = actions.input.form();	   			                       						
	            			 var inputsArray = actions.input.serializeObject(form);									
	            			 
	            			//var formdata = actions.input.FormData(form);									

							var name = actions.input.me('gallery').val();
							name = manager.wordToDirectory(name);

							//var url = path._PLUGINURL_ + 'uploads.php';
							var url = path._PLUGINURL_ + 'actions.php';
							
							var imgFile = form.find('[type="file"]').get(0);
							var imgfileList = imgFile.files;
							var formdata = new FormData();
							if (imgfileList && imgfileList != null && imgfileList.length > 0) {								
								for (var i = 0; i <= imgfileList.length-1; i++) {	

									name = manager.wordToDirectory(imgfileList[i].name);
									
							        formdata.append(name, imgfileList[i]);

							    }												
							}
							
							/*var other_data = form.find(':input').serializeArray();
							jQuery.each(other_data, function (key, input) {								
							    formdata.append(input.name, input.value);
							});*/
							jQuery.each(inputsArray, function (key, input) {	
								//alert(key+'-'+ input);							
							    formdata.append(key, input);
							});
						
							jQuery.ajax({
								url:url,
								type:'post',
								data:formdata,
								cache: false,
								processData: false,
					      		contentType: false,
								success:function(result){																		
									var resultObj = JSON.parse(result);
									if(resultObj.status == "success"){
										//manager.getGallery();	
										//alert(galleryFocus.name);	
										manager.selGallery(JSON.stringify(galleryFocus));								
										actions.close();
									}else{
										actions.top.icon(":[error]");
										actions.top.content("Ocorreu um erro");
									}
								},
								beforeSend: function(){},	
						        error: function(){},
						        xhr: function() {  // Custom XMLHttpRequest
					            	var myXhr = $.ajaxSettings.xhr();
						            if(myXhr.upload){ // Check if upload property exists
						                myXhr.upload.addEventListener('progress',
						                	function progresshandleMark(e){
											    if(e.lengthComputable){
											    	//alert(e.loaded+'-'+e.total);
											    	var porc = e.loaded*100/e.total;
											    	actions.input.me('progress').find('span').css({'width':porc+'%'})
											    	//setProgress('#progressMark',e.loaded,e.total);	
											    }
											}
										, false); 
						            }
						            return myXhr;
						        }
							});
					
						}
					},
					param_cancel:{
						click:function(){
							actions.close();
						}
					}
				}
				mebox.Box(rules);
			}
		}
		return functions;
	}

	this.clearSel = function(){
		galleryFocus = null;
		$('#galleryContent').html("");
		document.getElementById('gallery_shortcode').innerHTML = "";		
		document.getElementById('gallery_title').innerHTML = "";		
		document.getElementById('gallery_count').innerHTML = "";	

		$('[name=megallery_form_id]').val("");
		$('[name=megallery_form_title]').val("");
		$('[name=megallery_form_description]').val("");
		$('[name=megallery_form_link]').val("");

		$('[name=parameters_item]').css({'display':'none'});
	}

	this.gallery = function(){
		
		var functions = {
			save:function(){				
				var name = galleryFocus.name;
								
				//var item_item = itemFocus.item;
				var gallery_mode = $('[name=gallery_mode]').val();
				var gallery_delay = $('#gallerymaster_delay').val();
				//var item_description = $('[name=megallery_form_description]').val();
				//var item_link = $('[name=megallery_form_link]').val();
				$('#gallerymaster_status').html("Saving...<img src='"+path._PLUGINURL_+"/app/_public/img/loading.gif'>");


				var url = path._PLUGINURL_ + 'actions.php';

				var data = {"type":"saveGallery","data":{"gallery":name,"gallery_mode":gallery_mode,"gallery_delay":gallery_delay}};

				$.ajax({
					url:url,
					type:'post',
					data:data,
					success:function(result){						
						var resultObj = JSON.parse(result);
						if(resultObj.status == "success"){
							$('#gallerymaster_status').html("<img src='"+path._PLUGINURL_+"/app/_public/img/success.png'>");

						}else{
							$('#gallerymaster_status').html("Ocorreu um erro");
						}
					}
				});


			},
			del:function(){
				var callbackSim = function(){
					var name = galleryFocus.name;

					var url = path._PLUGINURL_ + 'actions.php';
					var data = {"type":"delGallery","data":{"gallery":name}};


							$.ajax({
								url:url,
								type:'post',
								data:data,
								success:function(result){
									
									var resultObj = JSON.parse(result);
									if(resultObj.status == "success"){																				
										//window.location.reload();
										
										manager.clearSel();
										manager.getGallery();
										actions.close();

									}else{
										actions.top.icon(":[error]");
										actions.top.content("Ocorreu um erro");
									}
								}
							});
					
						
				}
				var callbackNao = function(){
					
				}
				box.questions(":[question]","Quer realmente apagar <strong>"+galleryFocus.name+"</strong> ?",callbackSim,callbackNao)
			},
			add : function(){
				
				var rules = {
					icon:':[info]',
					content:'Insira um nome para a galeria',
					fixed:true,
					full:true,
					inputControls:{'gallery':['text',null,'Galeria']},
					buttonControls:{'make':['submit','Criar'],'cancel':['a','Cancel']},
					param_gallery:{
						attr:{'required':true}
					},					
					param_make:{
						click:function(){

							actions.top.icon(":[loading]");
							actions.top.content("Aguarde um momento...");
							actions.input.hide();


							var name = actions.input.me('gallery').val();													
                			name = manager.wordToDirectory(name);
							
							var url = path._PLUGINURL_ + 'actions.php';

							var data = {"type":"makeGallery","data":{"gallery":name}};

							$.ajax({
								url:url,
								type:'post',
								data:data,
								success:function(result){
									var resultObj = JSON.parse(result);
									if(resultObj.status == "success"){
										manager.clearSel();
										manager.getGallery();										
										actions.close();
									}else{
										actions.top.icon(":[error]");
										actions.top.content("Ocorreu um erro");
									}
								}
							});
					
						}
					},
					param_cancel:{
						click:function(){
							actions.close();
						}
					}
				}
				mebox.Box(rules);
			}
		}
		return functions;
	}

	this.setItemFocus = function(options){
		var gallery = options['gallery'];
		var item = options['item'];

		var title = options['title'];
		var description = options['description'];

		

		itemFocus = {
			'gallery':gallery,
			'item':item,
			'title':title,
			'description':description,
		}
	}

	this.getItemFocus = function(){
		return {'gallery':gallery,'item':item}
	}



	this.saveItem = function(){
		//var itemFocus = this.getItemFocus()
		var item_gallery = itemFocus.gallery;
		var item_item = itemFocus.item;
		var item_title = $('[name=megallery_form_title]').val();
		var item_description = $('[name=megallery_form_description]').val();
		var item_link = $('[name=megallery_form_link]').val();
		var item_target = $('[name=megallery_form_target]').val();
		 
		
		//$('#gallery_status').html('Saving... ['+item_item+']');	
		$('#gallery_status').html("Saving...<img src='"+path._PLUGINURL_+"/app/_public/img/loading.gif'>");

		var url = path._PLUGINURL_ + 'actions.php';
	
		$.ajax({
			url:url,
			type:'post',
			data:{'type':'saveItem','data':{"gallery":item_gallery,"item":item_item,'title':item_title,'description':item_description,'link':item_link,'target':item_target}},
			success:function(result){
				
				var resultObj = JSON.parse(result);
				
				var itemObj = JSON.parse(resultObj.data);
				

				if(resultObj.status == 'success'){

					$('#gallery_status').html("<img src='"+path._PLUGINURL_+"/app/_public/img/success.png'>");

					manager.setItemFocus({'gallery':gallery,'item':item,'title':itemObj.title,'description':itemObj.description,'link':itemObj.link});
					
					

					//$('#gallery_status').html('success');	
					/*$('[name=megallery_form_gallery]').val(gallery);
					$('[name=megallery_form_id]').val(item);
					$('[name=megallery_form_title]').val(itemObj.title);
					$('[name=megallery_form_description]').val(itemObj.description);*/
					
					
				}else if(resultObj.status == 'error'){
					$('#gallery_status').html('Erro ao carregar');
				}else{
					$('#gallery_status').html('Erro ao carregar');
				}
			}
		});




	}


	this.selItem = function(gallery,item){

		$('#megallery_form_id').val(item);


		
		$('#gallery_status').html("<img src='"+path._PLUGINURL_+"/app/_public/img/loading.gif'>");
		//$('#gallery_status').html('Loading... ['+item+']');	
		//document.getElementById('galleryContent').innerHTML = 'Loading...'+value;	

		$('[name=megallery_form_id]').val('');
		$('[name=megallery_form_title]').val('');
		$('[name=megallery_form_description]').val('');
		$('[name=megallery_form_link]').val('');

		var url = path._PLUGINURL_ + 'actions.php';
		
		$.ajax({
			url:url,
			type:'post',
			data:{'type':'loadItem','data':{"gallery":gallery,"item":item}},
			success:function(result){
				
				var resultObj = JSON.parse(result);
				
				var itemObj = (resultObj.data);
				

				if(resultObj.status == 'success'){

					manager.setItemFocus({'gallery':gallery,'item':item,'title':itemObj.title,'description':itemObj.description});
					
					$('[name=parameters_item]').css({'display':'table'});

					$('[name=megallery_form_gallery]').val(gallery);
					$('[name=megallery_form_id]').val(item);
					$('[name=megallery_form_title]').val(itemObj.title);
					$('[name=megallery_form_description]').val(itemObj.description);
					$('[name=megallery_form_link]').val(itemObj.link);
					$('[name=megallery_form_target]').val(itemObj.target);
					
					//$('#gallery_status').html('success');
					$('#gallery_status').html("<img src='"+path._PLUGINURL_+"/app/_public/img/success.png'>");
				}else if(resultObj.status == 'error'){
					$('#gallery_status').html('Erro ao carregar');
				}else{
					$('#gallery_status').html('Erro ao carregar');
				}
			}
		});


		
	}


	this.delItem = function(gallery,item){
		var input = confirm("Deseja realmente apagar o item '"+item+"' ?");
		if(input == false){
			return false;
		}
					
				$('#megallery_form_id').val(item);


				
				$('#gallery_status').html("<img src='"+path._PLUGINURL_+"/app/_public/img/loading.gif'>");
				//$('#gallery_status').html('Loading... ['+item+']');	
				//document.getElementById('galleryContent').innerHTML = 'Loading...'+value;	

				$('[name=megallery_form_id]').val('');
				$('[name=megallery_form_title]').val('');
				$('[name=megallery_form_description]').val('');
				$('[name=megallery_form_link]').val('');

				var url = path._PLUGINURL_ + 'actions.php';
				
				$.ajax({
					url:url,
					type:'post',
					data:{'type':'delItem','data':{"gallery":gallery,"item":item}},
					success:function(result){
							
						var resultObj = JSON.parse(result);
						
						var itemObj = JSON.parse(resultObj.data);
						

						if(resultObj.status == 'success'){					
							manager.loadGallery(gallery);
						}else if(resultObj.status == 'error'){
							$('#gallery_status').html('Erro ao carregar');
						}else{
							$('#gallery_status').html('Erro ao carregar');
						}
					}
				});


		
	}

	this.selGallery = function(value,obj){
		
		$('#box_galleryinfo').css({"visibility":"hidden"});

		manager.clearSel();

		var valueObj = JSON.parse(value);
		
		galleryFocus = valueObj;

		$('[name=gallery_mode]').html("<option value='gallery' disabled selected >Select</option><option value='gallery'  >Gallery</option><option value='compact' >Compact</option>");

		

		$('.menuListGallery > ul > li > a').attr({"data-status":""});
		$(obj).attr({"data-status":"active"});

		document.getElementById('gallery_title').innerHTML = galleryFocus.title;		
		document.getElementById('gallery_count').innerHTML = galleryFocus.count;	
		$('#galleryContent').html("<img src='"+path._PLUGINURL_+"/app/_public/img/loading.gif'>");
	
			this.loadGallery(galleryFocus.name);	

			$('.megallery_content_tool [data-icon="del"]').css({'visibility':'visible'});
	}

	this.loadGallery = function(value){
		
		$('#gallery_status').html("<img src='"+path._PLUGINURL_+"/app/_public/img/loading.gif'>");

		//$('#gallery_status').html('Loading... ['+value+']');	
		//document.getElementById('galleryContent').innerHTML = 'Loading...'+value;	
		$('#box_galleryinfo').css({"visibility":"visible"});

		var url = path._PLUGINURL_ + 'actions.php';
	
		$.ajax({
			url:url,
			type:'post',
			data:{'type':'loadGallery','data':value},
			success:function(result){
			
				var resultObj = JSON.parse(result);
				
				var galleryInfo = JSON.parse(resultObj.data2);

				

				if(resultObj.status == 'success'){	

					$('#galleryContent').html(resultObj.data);
					$('#gallery_shortcode').html('[megallery id="'+value+'" ]');
					

					if(JSON.stringify(galleryInfo) == 'null'){
						$('#gallery_status').html('');
						return;
					}else{
						$('[name=gallery_mode]').html("<option value='gallery' disabled "+((galleryInfo.mode!="gallery" && galleryInfo.mode!="compact")?"selected":"")+" >Select</option><option value='gallery' "+((galleryInfo.mode=="gallery")?"selected":"")+" >Gallery</option><option value='compact' "+((galleryInfo.mode=="compact")?"selected":"")+" >Compact</option>");					
						$('#gallerymaster_delay').val(galleryInfo.delay);
					}
					

					//$('#gallery_status').html('success');
					$('#gallery_status').html("<img src='"+path._PLUGINURL_+"/app/_public/img/success.png'>");

				}else if(resultObj.status == 'error'){
					$('#gallery_status').html('Erro ao carregar');
				}else{
					$('#gallery_status').html('Erro ao carregar');
				}


			}
		});

	}



	this.getGallery = function(){

		manager.clearSel();

		$('.megallery_content_tool [data-icon="del"]').css({'visibility':'hidden'});

		$('#listGallery').html("<img src='"+path._PLUGINURL_+"/app/_public/img/loading.gif'>");
		//$('#gallery_status').html('Loading...');	
		$('#gallery_status').html("<img src='"+path._PLUGINURL_+"/app/_public/img/loading.gif'>");
		//document.getElementById('galleryContent').innerHTML = 'Loading...'+value;	


					

		var url = path._PLUGINURL_ + 'actions.php';
		
		$.ajax({
			url:url,
			type:'post',
			data:{'type':'getGallery','data':null},
			success:function(result){	
	
				var resultObj = JSON.parse(result);
		
				if(resultObj.status == 'success'){
					$('#listGallery').html(resultObj.data);
					//$('#gallery_shortcode').html('[megallery id="'+value+'" ]');
					
					//$('#gallery_status').html('success');
					$('#gallery_status').html("<img src='"+path._PLUGINURL_+"/app/_public/img/success.png'>");
				}else if(resultObj.status == 'error'){
					$('#listGallery').html('Erro ao carregar');
					$('#gallery_status').html('Erro ao carregar');
				}else if(resultObj.status == 'nodir'){
					$('#listGallery').html('List Empty');
					$('#gallery_status').html('List Empty');
				}else{
					$('#gallery_status').html('Erro ao carregar');
				}
			}
		});

	}

}

var manager = new Manager();


manager.getGallery();