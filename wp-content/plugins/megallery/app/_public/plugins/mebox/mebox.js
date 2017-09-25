/** 
 * 
 * Esta classe possibilita a criaÃ§Ã£o personalizada de:
 *
 * 	lightbox
 * 	inputbox
 * 	ajax consulting
 *
 * @author Wallace Rio
 * @contact wallrio@gmail.com
 * 
 */
ListBox = new Array();

function MeBox(){
	
	lastId = 1;

	forceclosebox = false;
	this.id = null;
	id = null;
	var ListMeBoxArray = Array();
	var Nowfocus = null;
	var parent = this;

	var context = null;

	var background_full = null;
	var background_click = null;

	var animate_show = new Object();
	var animate_hide = new Object();

	var lightbox = null;
	loadAjax = Array();
	
	// captura a posiÃ§Ã£o absoluta do elemento
	this.getOffset = function ( el ) {
	    var _x = 0;
	    var _y = 0;
	    while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
	        _x += el.offsetLeft - el.scrollLeft;
	        _y += el.offsetTop - el.scrollTop;
	        el = el.offsetParent;
	    }
	    return { top: _y, left: _x };
	}


	this.drag = function(){
		
                return {
                	parent:this,
                    move : function(divid,xpos,ypos){
                        divid.style.left = xpos + 'px';
                        divid.style.top = ypos + 'px';
                    },
                    
                    initMoving : function(divid,container,barmove,evt){                    	
                    	jQuery(barmove).css({'cursor':'grab'});
                    },

                    startMoving : function(divid,container,barmove,evt){

                        evt = evt || window.event;

                        var posX = evt.clientX,
                            posY = evt.clientY,
                        divTop = parent.getOffset(divid).top,
                        divLeft = parent.getOffset(divid).left,
						eWi = parseInt(divid.style.width),
						eHe = parseInt(divid.style.height);
							
						divid.style.position='absolute';						

						var cWi = parseInt(document.getElementById(container).style.width);
						
						var cHe = parseInt(document.getElementById(container).style.height);
						//document.getElementById(container).style.cursor='move';
						jQuery(barmove).css({'cursor':'move'});

						divid.style.left = divLeft + 'px';
                        divid.style.top = divTop + 'px';
                                         
                        var diffX = posX - divLeft,
                            diffY = posY - divTop;

                        document.onmousemove = function(evt){
                        	jQuery(barmove).css({'cursor':'move'});
                            evt = evt || window.event;
                            var posX = evt.clientX,
                                posY = evt.clientY,
                                aX = posX - diffX,
                                aY = posY - diffY;
								if (aX < 0) aX = 0;
								if (aY < 0) aY = 0;
								if (aX + eWi > cWi) aX = cWi - eWi;
								if (aY + eHe > cHe) aY = cHe -eHe;                    

                            divid.style.left = aX + 'px';
                        	divid.style.top = aY + 'px';

                        }
                    },
                    stopMoving : function(divid,container,barmove){                    	
                        var a = document.createElement('script');
						//document.getElementById(container).style.cursor='default';
						jQuery(barmove).css({'cursor':'default'});
                        document.onmousemove = function(){}
                    },
                }
            }();



	ajustIcon = function(iconcustom){
		iconcustom = iconcustom.replace(':[loading]','<div class="iconloading"></div>');
		iconcustom = iconcustom.replace(':[info]','<div class="iconinfo"></div>');
		iconcustom = iconcustom.replace(':[success]','<div class="iconsuccess"></div>');
		iconcustom = iconcustom.replace(':[success_email]','<div class="iconsuccess_email"></div>');
		iconcustom = iconcustom.replace(':[error]','<div class="iconerror"></div>');
		iconcustom = iconcustom.replace(':[question]','<div class="iconquestion"></div>');
		return iconcustom;
	}

	this.replace = function(source,destination,value){
        value = String(value);        
        while(value.indexOf(source)!=-1){
            value = value.replace(source,destination);
        }
        return value;   
    }

	this.stopload = function(obj){
		clearTimeout(loadAjax[obj]);
	}

	this.load = function(obj,url,fragment,replaceData,data,type){
		var refresh = null;				
		this.loadRefresh(obj,url,fragment,refresh,replaceData,data,type);
	}

	this.loadRefresh = function(obj,url,fragment,refresh,replaceData,data,type){
		if(type == undefined){type = 'get'}
		

		jQuery.ajax({
			url: url,
			data:data,
			type:type,		
			context:this,				
			//async: false,
			success:function(result){	
				var parent=this;

				if(replaceData != undefined){
					jQuery.each(replaceData,function(index,value){					
						result = parent.replace('{{'+index+'}}',value,result);					
					});
				}
				
				

				var source = jQuery('<div>' + result + '</div>');						
				

				
				if(fragment != '' && fragment != undefined){

					if(typeof obj == 'string'){
						jQuery(obj).html(source.find(fragment).html());
					}else{
						obj(source.find(fragment).html());
					}				
				}else{	
							
					if(typeof obj == 'string'){
						jQuery(obj).html(result);
					}else{
						obj(result);
					}
				}
				if(refresh != undefined){
					loadAjax[obj] = setTimeout(function(){
						mebox.load(obj,url,fragment,refresh,replaceData,data,type);
					},refresh);
				}
			}
		});
	}
	
	/**
	 * [createBox description]
	 * @param  {id of box}
	 * @return {null}
	 */
	this.createBox = function(id,cssbase){		
		if(id == undefined)id='';
		var html = "<div class='"+cssbase+"' id='mebox"+id+"' >";
				html += "<form name='meboxForm"+id+"' >";
					html += "<div class='backg' id='mebox_background"+id+"'></div>";
					html += "<div class='boxbg' >";//style='pointer-events:none'
						html += "<div class='meboxwrapper' id='mebox_wrapper"+id+"'>";
							html += "<div class='meboxheaderout'><div></div></div>";
							html += "<div class='meboxmainout' id='mebox_boxout"+id+"'>";
								html += "<div class='meboxboxinner' id='mebox_box"+id+"'>";
									html += "<div class='meboxheaderinner'  ><div class='mebox_header'></div></div>";
									html += "<div class='maininner' id='mebox_content"+id+"' ><div></div>";
										//html += "<div class='maininnerSuccess' id='mebox_contentSuccess"+id+"' ><p>test</p></div>";																	
									html += "</div>";
									html += "<div class='meboxfooterinner' id='mebox_control"+id+"'><div></div></div>";
								html += "</div>";
							html += "</div>";
							html += "<div class='meboxfooterout'><div></div></div>";
						html += "</div>";
					html += "</div>";
				html += "</form>";
			html += "</div>";
			jQuery('body').append(html);
	};


	
	
	/**
	 * [Box create the box]
	 * @param {rules of make}
	 */
	
	inputAdd = function(objarray,actions){

		var inputControls_html = '';
		var rules = actions.rules;


		//var rules = rules['rules'];

		if(typeof objarray == 'string'){

			jQuery("#mebox"+actions.me+" #mebox_inputs"+actions.me).append(objarray);
			return;
		}

		jQuery.each(objarray,function(value,text){
			type = text[0]?text[0]:'text';
			val = text[1]?text[1]:'';		
			title = text[2]?text[2]:'';
			actMix = text[3]?text[3]:'';
			manual = text[4]?text[4]:'';

			
			if(value == null || value == 'null'){
				value = (new Date).getTime();// Math.random().toString(36).slice(2);
			}
			
			nameid = value+actions.me;

				
			
			if(type == 'textarea'){
				inputControls_html += '<textarea type="'+type+'" id="'+nameid+'" name="'+nameid+'" placeholder="'+title+'" value="'+val+'" '+manual+'></textarea>';										
			}else if(type == 'a'){
				inputControls_html += '<a id="'+nameid+'" name="'+nameid+'" title="'+title+'" '+manual+' >'+val+'</a>';										
			}else if(type == 'label'){
				inputControls_html += '<label id="'+nameid+'" name="'+nameid+'" title="'+title+'" '+manual+' >'+val+'</label>';										
			}else if(type == 'date'){
				inputControls_html += '<input type="'+'text'+'" id="'+nameid+'" name="'+nameid+'" placeholder="'+title+'" value="'+val+'" '+manual+'>';							
			}else if(type == 'br'){			
				inputControls_html += '<br '+manual+'>';

		
			}else if(type == 'fieldset'){			
				inputControls_html += '<fieldset '+manual+'>';	
			}else if(type == '/fieldset'){			
				inputControls_html += '</fieldset>';


			}else if(type == 'div'){			
				inputControls_html += '<div '+title+' '+manual+' >'+val;
			}else if(type == '/div'){			
				inputControls_html += val+'</div >';	
	
							
						
			}else if(type == 'span'){
				inputControls_html += '<span id="'+nameid+'"  title="'+title+'" '+manual+'>'+val+'</span>';	
			}else if(type == 'progress'){
				inputControls_html += '<progress id="'+nameid+'" max="'+title+'" value="'+val+'" '+manual+'></progress>';		
			}else if(type == 'progress2'){
				inputControls_html += '<div data-type="progress" id="'+nameid+'" data-max="'+title+'" data-val="'+val+'" '+manual+'><span style="width:'+val+'%"></span></div>';		

			}else if(type == 'img'){
				inputControls_html += '<img id="'+nameid+'" name="'+nameid+'" title="'+title+'" src="'+val+'" '+manual+'>';						

			}else if(type == 'select'){
				var options='';
				
				if(typeof val == 'object'){

					jQuery.each(val,function(index,value){	
						//var jsonValue = JSON.parse(value);
						var values = value[0];
						var text = value[1];
						//var actmixsub = value[2];

						//alert( values+ '==');
						//jQuery.each(value,function(index2,value2){
							options += '<option value="'+values+'" >'+text+'</option>';
						//});
						//var values = value
						//options += '<option value="'+values+'">'+index+'</option>';
					});
				}

				//val = '';
				inputControls_html += '<select id="'+nameid+'" name="'+nameid+'" title="'+title+'" '+manual+' >'+options+'</select>';	



			}else{				
				inputControls_html += '<input type="'+type+'" id="'+nameid+'" name="'+nameid+'" placeholder="'+title+'" value="'+val+'" '+manual+' >';							
			}


			
			//jQuery("#mebox"+actions.me+" #mebox_inputs > form").html(inputControls_html);
			jQuery("#mebox"+actions.me+" #mebox_inputs"+actions.me).append(inputControls_html);
			
			

			if(typeof val == 'object'){

				/*var param = rules['param_selects'];	
				jQuery.each(param,function(index3,value3){		
					alert(param);
				}*/

				/*jQuery.each(val,function(index2,value2){		


						
							if(JSON.stringify(value2) == undefined){
								var func = "jQuery('#mebox"+actions.me+" #mebox_inputs"+actions.me+"  #"+nameid+"')."+index2+"("+value2+");";
							}else{
								var func = "jQuery('#mebox"+actions.me+" #mebox_inputs"+actions.me+"  #"+nameid+"')."+index2+"("+JSON.stringify(value2)+");";
							}
							eval(func);
				
					

						

					});	
			*/
			}else{
				
			}
			

		
			
		});
		
		//var param = rules['param_selects'];
		//jQuery.each(param,function(index2,value2){	
			//alert(param);
		//}

		
		



		return inputControls_html;
	}


	this.actions = {

	}

	
	
	this.AcessBox = function(id){
		//return ListBox[0];
		num = 0;
		numIndex = 0;
		jQuery.each(ListBox,function(index,value){		

			
			if(ListBox[numIndex].me == id){
				
				num = numIndex;
				//alert(ListBox[numIndex].top.content('ooo'));				
				
			}	
			numIndex++;
			
		});

		return ListBox[num];	
		//return false;
	}
	
	this.Box = function(rules){
		
		if(rules == undefined){		
			rules = {
				icon:':[info]',
				title:'MeBox',
				content:'This is a box makes with MeBox',				
				buttonControls:{'close':['a','Close']},
				param_close:{
					click:function(){
						actions.close();
					}
				}
			}
			
		}
		


		var sufixo = '_mb';
		var callback;
		var content = '';
		var contentResult = '';
		var ajaxSuccess = null;
		//var requestAjax = null;

		// start: funcÃ§Ãµes prÃ©-definidas
	var actions	= {
		parent:this,
		me:null,
		//id: function(){return this.me},
		id:null,
		mebox:function(){
			return '#mebox'+actions.me;
		},
		drag:{
			state:false,
			enabled:function(value){
				actions.drag.state = value;
			},
			toggle:function(){
				if( actions.drag.state == true){
					actions.drag.enabled(false);	
				}else{
					actions.drag.enabled(true);
				}
				return actions.drag.state;
			}
		},
		escape:true,
		keypress:null,
		reload:function(id){
			var rules=null;

			if(id == undefined){						
				parent.Box(actions.rules);	
				return rules['rules'];			
			}

			jQuery.each(ListBox,function(index,value){
				jQuery.each(value,function(index2,value2){
					if(index2 == 'me' && value2 == id){
						rules = value;
						//alert(index2+'-'+value2);
					}
						
				});
				
			});


			parent.Box(rules['rules']);	

			return rules['rules'];

			
		},
		param:function(value,act){		
		
			var nameid = value;
			var id = actions.me;		
			var rules = actions.rules;
			
			if(rules['param_'+nameid]){
				param = rules['param_'+nameid];							
				var func=null;					
				jQuery.each(param,function(index2,value2){	

					if(type == 'submit'){
						func = "jQuery('form[name=meboxForm"+id+"]').submit("+value2+");";										
					}else{
						if(JSON.stringify(value2) == undefined){										
							 func = "jQuery('#"+nameid+id+"')."+index2+"();";
						}else{
							 func = "jQuery('#"+nameid+id+"')."+index2+"("+JSON.stringify(value2)+");";
						}
					}					
					eval(func);
				})				
			}
			


		},
		element:function(id,boxid){
			if(boxid == undefined){			
				if(id == undefined){						
					return jQuery("#mebox"+actions.me+" #mebox_inputs"+actions.me);
				}else{		

					return jQuery("#mebox"+actions.me+" #"+id+actions.me);
				}
			}else{						
				return jQuery("#mebox"+boxid+" #"+id+boxid);
			}
		}
		,
		input:{
			add:function(objarray){
				//alert(objarray);
				
				var inputControls_html = inputAdd(objarray,actions);
					
					

				//jQuery("#mebox"+actions.me+" #mebox_inputs > form").append(inputControls_html);
			},
			/*progress:function(id,value,boxid){	

				if(boxid == undefined){			
					if(id == undefined){						
						return jQuery("#mebox"+actions.me+" #mebox_inputs"+actions.me).find('span').css({'width':value});
					}else{		

						return jQuery("#mebox"+actions.me+" #"+id+actions.me).find('span').css({'width':value});
					}
				}else{						
					return jQuery("#mebox"+boxid+" #"+id+boxid).find('span').css({'width':value});
				}
			},*/
			me:function(id,boxid){	

				if(boxid == undefined){			
					if(id == undefined){						
						return jQuery("#mebox"+actions.me+" #mebox_inputs"+actions.me);
					}else{		

						return jQuery("#mebox"+actions.me+" #"+id+actions.me);
					}
				}else{						
					return jQuery("#mebox"+boxid+" #"+id+boxid);
				}
			},
			content:function(value,id){		
				
				if(id == undefined){
					jQuery("#mebox"+actions.me+" #mebox_inputs"+actions.me).html(value);
				}else{							
					jQuery("#mebox"+actions.me+" #"+id+actions.me+"").html(value);
				}


			},
			form:function(id,boxid){		
				if(boxid == undefined){			
					if(id == undefined){												
						return jQuery('form[name=meboxForm'+actions.me+']');//jQuery("#mebox"+actions.me+" #mebox_inputs");
					}else{						
						return jQuery('form[name=meboxForm'+actions.me+']');//jQuery("#mebox"+actions.me+" #"+id+actions.me+"");
					}
				}else{						
					return jQuery('form[name=meboxForm'+boxid+']');//jQuery("#mebox"+boxid+" #"+id+boxid+"");
				}
			},
			hide:function(id,boxid){				
				if(boxid == undefined){								
					if(id == undefined){	
					
						jQuery("#mebox"+actions.me+" #mebox_inputs"+actions.me).css({'display':'none'});
					}else{												
						jQuery("#mebox"+actions.me+" #"+id+actions.me).css({'display':'none'});
					}
				}else{						
					jQuery("#mebox"+boxid+" #"+id+boxid).css({'display':'none'});;
				}


			},
			serialize:function(form){
				data = form.serialize();
				
				data = parent.replace(actions.me+'=','=',data); //data.replace(actions.me+'=','=');
				//this.replace = function(source,destination,value)
				return data;
			},
			serializeObject: function(form){
			    var o = {};
			    var a = form.serializeArray();
			    jQuery.each(a, function(index,value) {		
				    var nameajust = String(value.name).replace(actions.me,'');				    
			        if (o[value.name] !== undefined) {			        	
			            if (!o[value.name].push) {			            	
			                o[nameajust] = [o[value.name]];
			            }
			            o[nameajust].push(value.value || '');
			        } else {
			            o[nameajust] = value.value || '';
			        }
			    });
			    return o;
			},
			FormData:function(form){

				var forms = jQuery(form).get(0);


				

				jQuery.each(forms,function(index,value){
					
					value.name = value.name.replace(actions.me,'');
					
				});

				//forms.name = '11';
				//alert(JSON.stringify(forms));

				//forms.typeAction = 'importbase';

				
				var data = new FormData(forms);
				//alert(JSON.stringify(data));
				//data = form.FormData();
				//alert(JSON.stringify(formdata));
				//data = data.replace(actions.me+'=','=');
				return data;
			},
			getFileContent:function(nameInput,callback){
				
				var file = this.me('file')[0].files[0];//document.getElementById("fileimportbase").files[0];
							if (file) {
							    var reader = new FileReader();
							    reader.readAsText(file, "UTF-8");
							    reader.onload = function (evt) {
							    	callback({
							    		'status':'success',
							    		'data':evt.target.result
							    	});							    								       
							    }
							    reader.onerror = function (evt) {
							        callback({
							    		'status':'error',
							    		'data':'null'
							    	});
							    }
							}

			}
		},
		result:{
			show:function(content,icon,id){

				if(icon == undefined || icon == null){icon = '';}
				if(content == undefined || content == null){content = '';}

				var html = '';
				html += '<div class="meboxalert" >';
				html += '<div class="icon"><div class="iconcustom">'+ajustIcon(icon)+'</div></div>';
				html += '<span>'+content+'</span>';					
				html += '</div>';



					if(id == undefined){	
						
						if(jQuery( "#mebox"+actions.me+" #mebox_inputs"+actions.me+" > .inputResult").html() != undefined){
						jQuery( "#mebox"+actions.me+" #mebox_inputs"+actions.me+" > .inputResult  .meboxalert .icon .iconcustom").html(ajustIcon(icon));
						jQuery( "#mebox"+actions.me+" #mebox_inputs"+actions.me+" > .inputResult .meboxalert span").html(content);
						return;
					}
				
					jQuery( "#mebox"+actions.me+" #mebox_inputs"+actions.me+" ").append('<div class="inputResult"><div>'+html+'</div></div>');
				}else{												
					if(jQuery( "#mebox"+id+" #mebox_inputs"+id+" > .inputResult").html() != undefined){
						jQuery( "#mebox"+id+" #mebox_inputs"+id+" > .inputResult  .meboxalert .icon .iconcustom").html(ajustIcon(icon));
						jQuery( "#mebox"+id+" #mebox_inputs"+id+" > .inputResult .meboxalert span").html(content);
						return;
					}
					
					jQuery( "#mebox"+id+" #mebox_inputs"+id+" ").append('<div class="inputResult"><div>'+html+'</div></div>');	
				}

				
			},
			hide:function(){										
				jQuery( "#mebox"+actions.me+" #mebox_inputs"+actions.me+" > .inputResult").remove();				
			}
		},
		rules:rules,		
		parameters: function(id){
			//if(id == undefined){
			//	return this.parameters;
			//}else{
				return parent.parameters;
			//}
		},
		disable:function(value,id){
			if(id == undefined){
				jQuery("#mebox"+actions.me+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner *").attr('disabled', true).attr('href',null);
				//jQuery("#mebox"+id+" p.control a").click(function(){});
				//alert(1);
				jQuery("#mebox"+actions.me+" p.control a").css({'background': 'red'});
			}else{							
				jQuery("#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner *").attr('disabled', true).attr('href', null);
				jQuery("#mebox"+id+" p.control a").click(function(){});
			}
		},
		requestAjax:null,
		ajax:{
				abort:function(){					
					JSON.stringify(actions.requestAjax.abort());
					
				},
				get:function(url,data,callback){				
					var refresh = null;
					var fragment = null;
					if(typeof url == 'object'){
						jQuery.each(url,function(index,value){							
							url = index;
							fragment = value;
						});						
					}						
					parent.load(callback,url,fragment,null,data,'get')
				},
				post:function(url,data,callback){				
					var refresh = null;
					var fragment = null;
					if(typeof url == 'object'){
						jQuery.each(url,function(index,value){							
							url = index;
							fragment = value;
						});						
					}						
					parent.load(callback,url,fragment,null,data,'post')
				},
				postdata:function(url,data,callback){		
					
					jQuery.ajax({
						type : 'POST',
						url:url,
						data:data,
						processData: false,
					    contentType: false,
					    success:function(data){
					    	
					    	callback(data);
					    }
					});		
				
				},
				load:function(obj,url,fragment,replaceData,data,type){				
					/*var refresh = null;
					var fragment = null;
					if(typeof url == 'object'){
						jQuery.each(url,function(index,value){							
							url = index;
							fragment = value;
						});						
					}						*/
					parent.load(obj,url,fragment,replaceData,data,type)
				}
			
		},
		gofunction: function(value){

			act = window[value];
			act(this);
		},	
		close:function(id,callback){		

			if(id == undefined){
				
				
					Nowfocus = actions.me;	
					parent.HideBox(Nowfocus,callback);
								
				
			}else{
				Nowfocus = id;

				parent.HideBox(id,callback);
			}
			
		},
		parameters:null,
		title:function(value,id){
			if(id == undefined){
				jQuery("#mebox"+actions.me+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner > div.meboxheaderinner > div").html(value);
			}else{							
				jQuery("#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner > div.meboxheaderinner > div").html(value);
			}
			
		},
		info:{
			content: function(value,id){
				
				if(id == undefined){
					jQuery("#mebox"+actions.me+" .control span:nth-child(2) > span").html(value);
				}else{							
					jQuery("#mebox"+id+" .control span:nth-child(2) > span").html(value);
				}
			},
			icon:function(value,id){
				
				if(id == undefined){
					jQuery("#mebox"+actions.me+" .control span:nth-child(1) > span").html(ajustIcon(value));
				}else{							
					jQuery("#mebox"+id+" .control span:nth-child(1) > span").html(ajustIcon(value));
				}
			}
			
		},
		
		top:{
			content:function(value,id){
				if(id == undefined){				
					jQuery("#mebox"+actions.me+" #mebox_topcontent").html(value);
				}else{							
					jQuery("#mebox"+id+" #mebox_topcontent").html(value);
				}
			},
			icon:function(value,id){
				
				if(id == undefined){
					jQuery("#mebox"+actions.me+" #mebox_topicon").html(ajustIcon(value));
				}else{							
					jQuery("#mebox"+id+" #mebox_topicon").html(ajustIcon(value));
				}
			},
			hide:function(id){
				
				if(id == undefined){
					jQuery("#mebox"+actions.me+" #mebox_topcontent").html('');
					jQuery("#mebox"+actions.me+" #mebox_topicon").html('');
					jQuery("#mebox"+actions.me+" .meboxalert").remove();
					
				}else{							
					jQuery("#mebox"+id+" #mebox_topicon").html('');
					jQuery("#mebox"+id+" #mebox_topcontent").html('');
					jQuery("#mebox"+id+" .meboxalert").remove();
				}
			}
		},
		middle:{
			content:function(value,id){				
				if(id == undefined){
					jQuery("#mebox"+actions.me+" #mebox_contentresult").html(value);					
				}else{							
					jQuery("#mebox"+id+" #mebox_contentresult").html(value);
				}
			},
			hide:function(id,boxid){				
				if(boxid == undefined){								
					if(id == undefined){													
						jQuery("#mebox"+actions.me+" #mebox_contentresult").css({'display':'none'});
					}else{												
						jQuery("#mebox"+actions.me+" #mebox_contentresult").css({'display':'none'});
					}
				}else{						
					jQuery("#mebox"+id+" #mebox_contentresult").css({'display':'none'});;
				}


			}
		},
		content:function(value,id){

			var callback;
			
				content = value;
				if(typeof content == 'object'){
					jQuery.each(content,function(index,value){

						if(index == 'get' || index == 'post'){																
									 url = value[0];
									 param = value[1];
									 callback = value[2];									
								jQuery.ajax({
								type:index,
								url:url,
								data:param,
								success:function(data){		

									actions.middle.content(data);
									if(callback != undefined){
										callback(data);
									}
									
								}
							});
						}
					});
				}else{
					if(id == undefined){
						jQuery("#mebox"+actions.me+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner > div.maininner > div").html(value);
					}else{							
						jQuery("#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner > div.maininner > div").html(value);
					}	
				}
					

			
		},
		wrapper_style:function(value,id){
			if(id == undefined){
				//Nowfocus = this.me;
				id = actions.me;
			}
			
			
			jQuery( "#mebox"+id+" > form > div.boxbg  ").animate(value.animate.pre,value.animate.durationPre,function(){
				jQuery( "#mebox"+id+" > form > div.boxbg > div.meboxwrapper ").css(value.style);	
				jQuery( "#mebox"+id+" > form > div.boxbg  ").animate(value.animate.in,value.animate.durationIn,function(){
									
				});
			});
			
		},
		icon:{
			content:function(value){
				jQuery("#mebox"+this.me+" div.meboxalert > icon > custom").html(ajustIcon(value));
			},
			hide:function(value){
				jQuery("#mebox"+this.me+" > form > box > span > forms > content > div > section > icon").css({'display':'none'});
			},
			show:function(value){
				jQuery("#mebox"+this.me+" > form > box > span > forms > content > div > section > icon").css({'display':'block'});
			}
		},
		contentbox:function(value,id){			
			if(id == undefined){

				jQuery("#mebox"+actions.me+" > form > box > span > forms > content").html(value);
			}else{							
				jQuery("#mebox"+id+" > form > box > span > forms > content").html(value);
			}
		},
		control:{
			buttonControls:function(value){
				buttonControls_html = '';
				buttonControls = value;
				//alert(buttonControls);
						jQuery.each(buttonControls,function(value,text){						
							var type = text[0];
							var name = text[1];

							action = null;
							action_html = '';


							
							if(type == 'a'){
								buttonControls_html = '<a id="'+value+id+'" name="'+value+id+'" '+action_html+' >'+name+'</a>' + buttonControls_html;
							}else{
								buttonControls_html = '<input type="'+type+'" id="'+value+id+'" name="'+value+id+'" '+action_html+' value="'+name+'" >'+ buttonControls_html;
							}

						});
				
						jQuery("#mebox"+actions.me+" p.control").html(buttonControls_html);

					
						jQuery.each(buttonControls,function(value,text){						
							action = null;
							action_html = '';
						
							type = text[0];
							title = text[1];
							nameid = value;	

							if(rules['param_'+nameid]){
								param = rules['param_'+nameid];			

								var func=null;					
								jQuery.each(param,function(index2,value2){	

									if(type == 'submit'){
										func = "jQuery('form[name=meboxForm"+id+"]').submit("+value2+");";										
									}else{
										if(JSON.stringify(value2) == undefined){										
											 func = "jQuery('#"+nameid+id+"')."+index2+"("+value2+");";
										}else{
											 func = "jQuery('#"+nameid+id+"')."+index2+"("+JSON.stringify(value2)+");";
										}
									}
									
									eval(func);
								})
								
							}
							
						});
					//}
			}
		},
		

	};
	// end: funcÃ§Ãµes prÃ©-definidas



		animate_show = {
							'pre':{'opacity':0.5,'marginTop':'-=100'},
							'duration':300,
							'in':{'opacity':1,'marginTop':'+=100'}
						};

		animate_hide = {
							'pre':{'opacity':0.5},
							'duration':300,
							'in':{'opacity':0,'marginTop':'-=100'}
						};

						

		var height = jQuery('body').height();
		var width = jQuery('body').width();

		this.id = lastId;
		var id = lastId+sufixo;

		var exit = false;

		if(rules != null){							
					//alert(rules['id']);
					if(rules['id']){
						id = rules['id'];

						// utilizado para impedir duplicaÃ§Ã£o de box
						jQuery.each(ListMeBoxArray,function(i){
							if(ListMeBoxArray[i] == id){								
								exit = true;		
							}							
						});

						
						this.id = id;
					}
		}		
		
		// utilizado para impedir duplicaÃ§Ã£o de box
		if(exit == true){			
			return;
		}

		var cssbase = 'mebox';
		if(rules['cssbase'] != undefined){				
			cssbase = rules['cssbase'];			
		}


		this.createBox(id,cssbase);
		
		
		this.forceclosebox = false;

	
		ListMeBoxArray.push(id);
		Nowfocus = id;

		lastId++;

		

			actions.me = id;
			actions.id = id;
			

			 


			if(rules['context']!=undefined){				
				context = rules['context'];
			}

		//if(rules['type'] == 'loading'){			
			/*if(rules['loading_before'] != undefined){				
				var loading_before = rules['loading_before'];
				loading_before(actions);
			}*/
		//}	

			

			if(rules['full']==true){
				//jQuery("#mebox"+id+" > bg").css({'opacity':rules['background_opacity']});
				background_full = jQuery("body").css('overflow');
				jQuery("body").css({'overflow':'hidden'});
				
			}
			
 			if(rules['positionBox'] != undefined){		
				positionBox = rules['positionBox'];								
			}
			

			if(rules['animate_show'] != undefined){		
				animate_show = rules['animate_show'];				
				actions.animate_show = animate_show;
			}
			if(rules['animate_hide'] != undefined){		
				animate_hide = rules['animate_hide'];				
				actions.animate_hide = animate_hide;
			}


			if(rules['fixed'] == true){
				jQuery("#mebox"+id).css({'position':'fixed'});
				//jQuery("#mebox"+id+" box").css({'position':'fixed'});
			}	


				

				if(rules['parameters'] != undefined){	
					actions.parameters = rules['parameters'];
				}	

				

				if(rules != undefined){	
					this.rules = rules;
				}

				// loading enquanto nÃ£o atualiza o box
				var loadinghtml = '';
			
				var html = '';
				
				
				var inputControls = null;
				var buttonControls = null;
				var action = null;
				var buttonControls_html = '';
				var inputControls_html = '';
								
				var iconpre = '<div class="iconinfo"></div>';
				var iconcustom = '';

				loadinghtml += '<div >';	
				loadinghtml += '<div class="meboxalert" >';
				loadinghtml += '<div class="icon"><div class="iconcustom"><div class="iconloading"></div></div></div>';
				loadinghtml += '<span>'+'Aguarde um momento...'+'</span>';					
				loadinghtml += '</div>';					
				//html += '<contentInput>'+inputControls_html;+'</contentInput>';					
				loadinghtml += '</div>';
				jQuery( "#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner > div.maininner > div").html(loadinghtml);



				if(rules != null){							
					
					if(rules['icon']!=undefined){
						iconcustom = rules['icon'];
						
						iconcustom = ajustIcon(iconcustom);
						
					}

					icon ='<div class="iconcustom">';
					icon += (iconcustom!=undefined)?iconcustom:iconpre;
					icon += '</div>';
					
					if(rules['content'] != undefined){
						content = rules['content'];
					}


					if(rules['ajaxSuccess'] != undefined){
						ajaxSuccess = rules['ajaxSuccess'];
					}
					


					if(rules['ajax'] != undefined){

						ajax = rules['ajax'];						
						if(typeof ajax == 'object'){
							jQuery.each(ajax,function(index,value){

								

								if(index == 'get' || index == 'post' || index == 'postdata' || index == 'getdata'){																
											 url = value[0];
											 param = value[1];
											 callback = value[2];		

											 var fragment = null;
											if(typeof url == 'object'){
												jQuery.each(url,function(index,value){							
													url = index;
													fragment = value;
												});						
											}	

											
											

										var dataAjax = {
										//type:index,
										url:url,
										data:param,
										//processData: false,
					      				//contentType: false,
										success:function(data){		
											
											var resultdata = '';
												if(typeof url == 'object'){
												  data = JSON.stringify(data);																	 
												}
												
											var source = jQuery('<div>' + data + '</div>');						
							
											if(fragment != undefined){
												//actions.middle.content(source.find(fragment).html());
												if(typeof ajaxSuccess == 'function'){
													ajaxSuccess(source.find(fragment).html(),actions);
												}
												if(typeof callback == 'function'){
													callback(data,actions);
												}
												
											}else{												
												//actions.middle.content(data);																							
												if(typeof ajaxSuccess == 'function'){
													ajaxSuccess(data,actions);
												}
												if(typeof callback == 'function'){
													callback(data,actions);
												}
												
											}
												
											
											
											
										}
									}

									//alert(jQuery.isEmptyObject(param));
									//if(index == 'postdata'){											
									if(typeof param == 'object' && jQuery.isEmptyObject(param) == true || index == 'postdata' ){											
										dataAjax['type'] = 'post';
										dataAjax['processData'] = false;
										dataAjax['contentType'] = false;								
									}else{
										dataAjax['type'] = index;
									}

									//alert(JSON.stringify(dataAjax));

									actions.requestAjax = jQuery.ajax(dataAjax);


								}
							});
						}						
					}

					//alert(requestAjax);
					// if(rules['inputControls'] != undefined){
					// 	inputControls = rules['inputControls'];

					// 	jQuery.each(inputControls,function(value,text){																							
					// 			for (var k in text) {
					// 			  name = k;
					// 			  valuename = text[k];
					// 			}
					// 			inputControls_html += '<input type="'+value+'" name="'+name+'" placeholder="'+valuename+'">';							

					// 	});
					// }
							

					if(rules['inputControls'] != undefined){
						inputControls = rules['inputControls'];						

						inputControls_html = inputAdd(inputControls,actions);
					}

					
					if(rules['buttonControls'] != undefined){

						buttonControls = rules['buttonControls'];
						

						buttonControls_html = '';
						jQuery.each(buttonControls,function(value,text){						
							var type = text[0];
							var name = text[1];

							action = null;
							action_html = '';


							/*
							if(rules['param_'+value] != undefined){								
								window['param_'+value+id] = rules['param_'+value];	
								action = window['param_'+value+id]+'(actions)';									
								action_html	= 'onclick="mebox.id=\''+id+'\';mebox.action(\''+id+'\','+action+')"';
							}*/

							
							if(type == 'a'){
								buttonControls_html = '<a id="'+value+id+'" name="'+value+id+'" '+action_html+' >'+name+'</a>' + buttonControls_html;
							}else{
								buttonControls_html = '<input type="'+type+'" id="'+value+id+'" name="'+value+id+'" '+action_html+' value="'+name+'" >'+ buttonControls_html;
							}

						});
					}
				}
				
				
				/*
				if(rules['background_click'] != undefined){					
					jQuery( "#mebox"+id+" > form > div.backg, #mebox"+id+" > div.boxbg > div.meboxwrapper").click(function(e) {					
						window['background_click'] = rules['background_click'];	
						background_click = window['background_click'];					
						background_click();
					});
				}*/
				
				jQuery( "#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner ").click(function(ev) {
				  ev.stopPropagation();
				});



				


				//jQuery( "#mebox"+id+" > box > span > forms[name='box'] > content").click(function(){
					//Nowfocus = id;				
				//});	

				
				//if(rules['type'] == 'loading'){
/*
					html += '<div >';						
					html += loadinghtml;		
					if(rules['buttonControls'] != undefined){
						html += '<p class="control">';
						html += buttonControls_html;
						
						html += '</p>';
					}
					html += '</div>';
					
					this.ShowBox(function(ids){						
						jQuery( "#mebox"+ids+" > boxbg > div.meboxwrapper > div.meboxmainout > box > main").html(html);	

						if(rules['loading_after'] != undefined){	
							loading_after = rules['loading_after'];						
							loading_after(actions);
						}
					},id);*/

				//}else if(rules['type'] == 'lightbox'){
					/*
					var img = rules['img'];

					html += '<div >';	
					html += '<section class="alert" >';
					html += '<icon>'+icon+'</icon>';
					html += '<content >'+content+'</content>';
					
					html += '</section>';					
					//html += '<contentInput>'+inputControls_html;+'</contentInput>';
					html += '1<p class="control">';
					html += buttonControls_html;
					
															
					html += '</p>';
					html += '</div>';


					this.ShowBox(function(ids){						
						
						jQuery( "#mebox"+ids+" > box > span > forms[name='box'] > content ").css({
							'height':(height-(height*0.30))+'px',
							'width':(width-(width*0.40))+'px',
							
						});	

						jQuery( "#mebox"+ids+" > box > span > forms[name='box'] > content").css({
							
							'background':'url('+img+')',
							'background-size':'inherit'
						});	

						if(rules['loading_after'] != undefined){	
							loading_after = rules['loading_after'];						
							loading_after(actions);
						}

						jQuery( "#mebox"+ids+" > boxbg > div.meboxwrapper > main > box > main").html(html);	


					},id);	*/


				//}else{

					if(rules['contentResult'] != undefined){	
						contentResult = rules['contentResult'];
					}

					html += '<div class="inputtb">';	
						html += '<div >';	
							html += '<div class="meboxalert" >';
							//if(iconcustom != ''){
								html += '<div class="icon" id="mebox_topicon">'+icon+'</div>';
							
								html += '<span class="mebox_content" id="mebox_topcontent" >'+content+'</span>';								
							html += '</div>';			
						
						//html += '<contentInput>'+inputControls_html;+'</contentInput>';					
						html += '</div>';

						//if(inputControls_html){		
						html += '<div class="inputs" id="mebox_inputs'+id+'" >'+inputControls_html+'</div>';		
						//}
						

						html += '<div   id="mebox_contentresult" class="mebox_contentresult">'+contentResult+'</div>';		

						var control = '';
						control += '<div class="control">';
						control += '<span><span>';
						control += '';																		
						control += '</span></span>';
						control += '<span><span>';
						control += '';																		
						control += '</span></span>';
						control += '<span><span>';
						control += buttonControls_html;																		
						control += '</span></span>';
						control += '</div>';


					if(rules['headerOut'] != undefined){
						jQuery( "#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxheaderout").html(rules['headerOut']);						
					}
					if(rules['footerOut'] != undefined){
						jQuery( "#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxfooterout").html(rules['footerOut']);						
					}


					if(rules['title'] != undefined){
						jQuery( "#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner > div.meboxheaderinner > div").html(rules['title']);	
					}

					

						
					
					if(rules['footer'] != undefined){
						jQuery( "#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner > div.meboxfooterinner > div").html(rules['footer']);	
					}else{
						if(buttonControls != undefined){
							jQuery( "#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner > div.meboxfooterinner > div").html(control);	
						}
					}

					if(rules['info'] != undefined){
						jQuery("#mebox"+id+" p.control span:first-child > label").html(rules['info']);
					}

					//var window_height = jQuery(window).height();
					//var window_width = jQuery(window).width();



					
					

					//jQuery( "#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner > div.maininner").css({'max-width':window_width-(window_width*0.3)});

					// lightbox = null;
					// if(rules['lightbox'] != undefined){		
					// 	lightbox = rules['lightbox'];				
					// }
					// if(lightbox != undefined && lightbox != null){
					// 	jQuery( "#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner > div.maininner").css({'width':window_width-(window_width*0.3),'height':window_height-(window_height*0.3)});
					// 	jQuery( "#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner > div.maininner").css({'background':'url('+lightbox+')','background-size':'cover'});
					// 	jQuery( "#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner > div.maininner > div").html(content);	
					//}else{
						jQuery( "#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner > div.maininner > div").html(html);	
					//}


					/*
					if(rules['content_size'] != undefined){		

						jQuery( "#mebox"+id+" > div.boxbg > div.meboxwrapper > div.meboxmainout > div.meboxboxinner img").css({
							'width':window_width-(window_width*(1-rules['content_size'].width)),
							'height':window_height-(window_height*(1-rules['content_size'].height))
						});	
					}*/


					/*
					var bg = 'bg';
					
					if(rules['param_'+bg]){

								param = rules['param_'+bg];

								jQuery.each(param,function(index,value){								
									
									if(JSON.stringify(value) == undefined){
										var func = "jQuery('#mebox_background"+parent.id+"')."+index+"("+value+");";
										var func = "jQuery('#mebox_wrapper"+parent.id+"')."+index+"("+value+");";
									}else{
										var func = "jQuery('#mebox_background"+parent.id+"')."+index+"("+JSON.stringify(value)+");";
										var func = "jQuery('#mebox_wrapper"+parent.id+"')."+index+"("+JSON.stringify(value)+");";
									}
									eval(func);
								})
					}*/

					var boxout = 'boxout';
					
					if(rules['param_'+boxout]){

								param = rules['param_'+boxout];

								type = null;null;
								val = null;
								title = null;
								actMix = null;
								obj = "#mebox_"+boxout+id;					
								//obj ='#mebox_contentresult';
								nameid = null;
								
								parent.setAttr(obj,param,nameid,id,type,val,title,actions);
								/*inputs = 'contentresult';
								jQuery.each(param,function(index,value){								

									if(JSON.stringify(value) == undefined){
										var func = "jQuery('#mebox_"+inputs+"')."+index+"("+value+");";
									}else{
										var func = "jQuery('#mebox_"+inputs+"')."+index+"("+JSON.stringify(value)+");";
									}
									eval(func);
								})*/
					}



					var inputs = 'control';
					
					if(rules['param_'+inputs]){

								param = rules['param_'+inputs];

								type = null;null;
								val = null;
								title = null;
								actMix = null;
								obj = "#mebox_"+inputs+id;					
								//obj ='#mebox_contentresult';
								nameid = null;
								
								parent.setAttr(obj,param,nameid,id,type,val,title,actions);
								/*inputs = 'contentresult';
								jQuery.each(param,function(index,value){								

									if(JSON.stringify(value) == undefined){
										var func = "jQuery('#mebox_"+inputs+"')."+index+"("+value+");";
									}else{
										var func = "jQuery('#mebox_"+inputs+"')."+index+"("+JSON.stringify(value)+");";
									}
									eval(func);
								})*/
					}

					//id='mebox"+id+"'

					var mebox = 'mebox';
					
					if(rules['param_'+mebox]){

								param = rules['param_'+mebox];

								type = null;null;
								val = null;
								title = null;
								actMix = null;
								obj = "#mebox"+id;					
								//obj ='#mebox_contentresult';
								nameid = null;
								
								parent.setAttr(obj,param,nameid,id,type,val,title,actions);
								/*inputs = 'contentresult';
								jQuery.each(param,function(index,value){								

									if(JSON.stringify(value) == undefined){
										var func = "jQuery('#mebox_"+inputs+"')."+index+"("+value+");";
									}else{
										var func = "jQuery('#mebox_"+inputs+"')."+index+"("+JSON.stringify(value)+");";
									}
									eval(func);
								})*/
					}



					var inputs = 'inputs';
					
					if(rules['param_'+inputs]){

								param = rules['param_'+inputs];

								type = null;null;
								val = null;
								title = null;
								actMix = null;
								obj = "#mebox_"+inputs+id;					
								//obj ='#mebox_contentresult';
								nameid = null;
								
								parent.setAttr(obj,param,nameid,id,type,val,title,actions);
								/*inputs = 'contentresult';
								jQuery.each(param,function(index,value){								

									if(JSON.stringify(value) == undefined){
										var func = "jQuery('#mebox_"+inputs+"')."+index+"("+value+");";
									}else{
										var func = "jQuery('#mebox_"+inputs+"')."+index+"("+JSON.stringify(value)+");";
									}
									eval(func);
								})*/
					}



					var background = 'background';
					
					if(rules['param_'+background]){

								param = rules['param_'+background];

								/*jQuery.each(param,function(index,value){								

									if(JSON.stringify(value) == undefined){
										var func = "jQuery('#mebox_"+background+parent.id+"')."+index+"("+value+");";
									}else{
										var func = "jQuery('#mebox_"+background+parent.id+"')."+index+"("+JSON.stringify(value)+");";
									}
									eval(func);
								})*/

								type = null;null;
								val = null;
								title = null;
								actMix = null;
								obj = "#mebox_"+background+id;	
								nameid = null;				
								parent.setAttr(obj,param,nameid,id,type,val,title,actions);
					}



					var headerouts = 'headerOut';
					
					if(rules['param_'+headerouts]){

								param = rules['param_'+headerouts];

								type = null;null;
								val = null;
								title = null;
								actMix = null;
								obj = "#mebox"+id+" > form > div.boxbg > div.meboxwrapper > div.meboxheaderout";	
								nameid = null;				
								parent.setAttr(obj,param,nameid,id,type,val,title,actions);
					}

					


					var wrapper = 'wrapper';
					if(rules['param_'+wrapper]){
								param = rules['param_'+wrapper];								
								/*jQuery.each(param,function(index,value){								

									if(JSON.stringify(value) == undefined){
										var func = "jQuery('#mebox_"+wrapper+parent.id+"')."+index+"("+value+");";
									}else{
										var func = "jQuery('#mebox_"+wrapper+parent.id+"')."+index+"("+JSON.stringify(value)+");";
									}
									eval(func);
								})*/

								type = null;null;
								val = null;
								title = null;
								actMix = null;
								obj = "#mebox_"+wrapper+id;
								nameid = null;
								parent.setAttr(obj,param,nameid,id,type,val,title,actions);
					}

					// var content = 'content';
					// if(rules['param_'+content]){
					// 			param = rules['param_'+content];								
					// 			jQuery.each(param,function(index,value){								

					// 				if(JSON.stringify(value) == undefined){
					// 					var func = "jQuery('#mebox_"+content+parent.id+"')."+index+"("+value+");";
					// 				}else{
					// 					var func = "jQuery('#mebox_"+content+parent.id+"')."+index+"("+JSON.stringify(value)+");";
					// 				}
					// 				eval(func);
					// 			})
					// }

					

					var box = 'box';
					if(rules['param_'+box]){
								param = rules['param_'+box];	

								/*jQuery.each(param,function(index,value){								

									if(JSON.stringify(value) == undefined){
										//alert(value);
										var func = "jQuery('#mebox_"+box+id+"')."+index+"("+value+");";
									}else{
										var func = "jQuery('#mebox_"+box+id+"')."+index+"("+JSON.stringify(value)+");";
									}
									eval(func);
								})*/
						
								type = null;
								val = null;
								title = null;
								actMix = null;
								obj = "#mebox_"+box+id;	
								
								nameid = null;
								
								parent.setAttr(obj,param,nameid,id,type,val,title,actions);
								
							}



					// start: atribui atributos nos inputs
					if(rules['inputControls'] != undefined){
						inputControls = rules['inputControls'];	
						
						var inputControls_index = 0;

						jQuery.each(inputControls,function(value,text){
							/*type = text[0];
							title = text[1];
							actMix = text[2];*/

							type = text[0]?text[0]:'text';
							val = text[1]?text[1]:'';		
							title = text[2]?text[2]:'';
							actMix = text[3]?text[3]:null;							


							nameid = value;						
							
							if(inputControls_index == 0){								
								eval("jQuery('#"+nameid+id+"').focus();");
							}
							inputControls_index++;
								

							if(rules['param_'+nameid]){
								param = rules['param_'+nameid];							
								obj = "#"+nameid+id;
								parent.setAttr(obj,param,nameid,id,type,val,title,actions);


								

							}


							

							if(actMix != null){
								if(rules['param_'+actMix]){
									param = rules['param_'+actMix];							
									obj = "#"+nameid+id;
									parent.setAttr(obj,param,nameid,id,type,val,title,actions);

									/*jQuery.each(param,function(attribute,value2){			
									//	alert(JSON.stringify(param));
										if(JSON.stringify(value2) == undefined){										
											var func = "jQuery('#"+nameid+id+"').bind('"+attribute+"',{id:'"+nameid+id+"',type:'"+type+"',val:'"+val+"',title:'"+title+"'},"+value2+");";										
											//var func = "jQuery('#"+nameid+id+"')."+attribute+"("+value2+");";										
										}else{
											if(attribute.indexOf('_hover') != -1){
												var attribute_ajust = String(attribute).replace('_hover','');
												var func = "jQuery('#"+nameid+id+"').mouseover(function(){jQuery(this)."+attribute_ajust+"("+JSON.stringify(value2)+");});";																						
											}else if(attribute.indexOf('_out') != -1){
												var attribute_ajust = String(attribute).replace('_out','');
												var func = "jQuery('#"+nameid+id+"').mouseout(function(){jQuery(this)."+attribute_ajust+"("+JSON.stringify(value2)+");});";										
											}else{
												var func = "jQuery('#"+nameid+id+"')."+attribute+"("+JSON.stringify(value2)+");";										
											}
										}																									
										eval(func);
									});*/

								}
							}

							

						})
					}
					// end: atribui atributos nos inputs



						
					if(rules['escape'] != undefined){
						actions.escape = rules['escape'];						
					}

					if(rules['keypress'] != undefined){
						actions.keypress = rules['keypress'];											
					}



					if(rules['focus'] != undefined){
						focus = rules['focus'];						
						jQuery("#mebox"+id+" #"+focus+id).focus();
					}
				

					//alert("#mebox"+actions.me+" #mebox_inputs > form");
					/*jQuery("#mebox"+actions.me+" #mebox_inputs > form").submit(function(){						
						alert(1);
						return false;
					});
*/
					jQuery('form[name=meboxForm'+id+']').submit(function(){							
						return false;
					});



					if(rules['buttonControls'] != undefined){
						buttonControls = rules['buttonControls'];
						jQuery.each(buttonControls,function(value,text){						
							action = null;
							action_html = '';
						
							type = text[0];
							title = text[1];
							nameid = value;	

							if(rules['param_'+nameid]){
								param = rules['param_'+nameid];			

								var func=null;					
								/*jQuery.each(param,function(index2,value2){	

									if(type == 'submit'){
										func = "jQuery('form[name=meboxForm"+id+"]').submit("+value2+");";										
									}else{
										if(JSON.stringify(value2) == undefined){										
											 func = "jQuery('#"+nameid+id+"')."+index2+"("+value2+");";
										}else{
											 func = "jQuery('#"+nameid+id+"')."+index2+"("+JSON.stringify(value2)+");";
										}
									}
									
									eval(func);
								})*/
								//type = null;
								val = null;
								//title = null;
								actMix = null;
								obj = "#"+nameid+id;		
								parent.setAttr(obj,param,nameid,id,type,val,title,actions);
								
							}
							
						});
					}


					if(rules['before'] != undefined){				
						var before = rules['before'];
						before(actions);
					}


					this.actions = actions;
					
					ListBox.push(this.actions);

						

					if(rules['drag'] != undefined){				
						var drag = rules['drag'];
						
					
						if(drag == true){

							// define o codigo para mover o box
							var barmove = "#mebox_box"+id+" .inputtb > div:nth-child(1)";
							jQuery(barmove).mousemove(function(event){								
								var container = "mebox_wrapper"+id;
								//var barmove = document.querySelector("#mebox_box"+id+" .inputtb > div:nth-child(1)");
								var element = document.querySelector("#mebox_box"+id);
								parent.drag.initMoving(element,container,barmove,event);							
							});
							jQuery(barmove).mousedown(function(event){	
							
								if(drag == false){
									return;
								}				
								var container = "mebox_wrapper"+id;
								//var barmove = document.querySelector("#mebox_box"+id+" .inputtb > div:nth-child(1)");
								var element = document.querySelector("#mebox_box"+id);
								parent.drag.startMoving(element,container,barmove,event);						
							});
							jQuery(barmove).mouseup(function(event){	
								var container = "mebox_wrapper"+id;		
								
								var element = document.querySelector("#mebox_box"+id);							
								parent.drag.stopMoving(element,container,barmove);					
							});



							// define o codigo para mover o box
							var barmove2 = "#mebox_box"+id+" .meboxheaderinner";
							jQuery(barmove2).mousemove(function(event){
								var container = "mebox_wrapper"+id;
								//var barmove = document.querySelector("#mebox_box"+id+" .inputtb > div:nth-child(1)");
								var element = document.querySelector("#mebox_box"+id);
								parent.drag.initMoving(element,container,barmove2,event);							
							});
							jQuery(barmove2).mousedown(function(event){	
								//alert(actions.drag.state);
								if(drag == false){
									return;
								}				
								var container = "mebox_wrapper"+id;
								//var barmove = document.querySelector("#mebox_box"+id+" .inputtb > div:nth-child(1)");
								var element = document.querySelector("#mebox_box"+id);
								parent.drag.startMoving(element,container,barmove2,event);						
							});
							jQuery(barmove2).mouseup(function(event){	
								var container = "mebox_wrapper"+id;		
								
								var element = document.querySelector("#mebox_box"+id);							
								parent.drag.stopMoving(element,container,barmove2);					
							});


							// define o codigo para mover o box
							var barmove3 = "#mebox_box"+id+"  p.control span:nth-child(3)";
							jQuery(barmove3).mousemove(function(event){
								var container = "mebox_wrapper"+id;
								//var barmove = document.querySelector("#mebox_box"+id+" .inputtb > div:nth-child(1)");
								var element = document.querySelector("#mebox_box"+id);
								parent.drag.initMoving(element,container,barmove3,event);							
							});
							jQuery(barmove3).mousedown(function(event){					
								var container = "mebox_wrapper"+id;
								//var barmove = document.querySelector("#mebox_box"+id+" .inputtb > div:nth-child(1)");
								var element = document.querySelector("#mebox_box"+id);
								parent.drag.startMoving(element,container,barmove3,event);						
							});
							jQuery(barmove3).mouseup(function(event){	
								var container = "mebox_wrapper"+id;		
								
								var element = document.querySelector("#mebox_box"+id);							
								parent.drag.stopMoving(element,container,barmove3);					
							});
						}

					}



					this.ShowBox(function(ids){						
				

						if(rules['after'] != undefined){	
							after = rules['after'];						
							after(actions);
						}

					},id);	

					
				//}

	}

	
	// fecha o box	
	this.HideBox = function(id,callback,actionpre){		
		//id = parent.id;
		
		this.Act_CloseBox(id,callback);
	
	}

	this.CloseBox = function(id){

		if(id == undefined){
			id = parent.id;		
		}
		this.Act_CloseBox(id);		
		//
	}

	this.Act_CloseBox = function(id,action){	

		//id = (Nowfocus!=null)?Nowfocus:id;
		id = Nowfocus;
		
		this.forceclosebox = true;
		context = this;

		var showBox = function(){
			jQuery( "resultlogin").css({height:'0px',padding:'0px'});				
						jQuery( "resultloginText" ).html('');
															
						
						jQuery( "#mebox"+id).remove();

						if(background_full != null){
							jQuery("body").css({'overflow':background_full});
						}
						
						jQuery.each(ListMeBoxArray,function(i){
							if(ListMeBoxArray[i] == Nowfocus){
								ListMeBoxArray.splice(i,1);
							}
							//Nowfocus = ListMeBoxArray[i];
						});

						//alert(ListMeBoxArray[ListMeBoxArray.length-1]);
						Nowfocus = ListMeBoxArray[ListMeBoxArray.length-1];
						//this.actions.me = Nowfocus;
						//alert(id+'=='+Nowfocus+'---'+ListMeBoxArray);


						

						//context.actions = rules['me'];
						//alert('>>'+rules['me']);


						if(action || action != undefined){action()};
		}
	

		if(animate_show == false){
			showBox();
			return;
		}
		
		jQuery( "#mebox"+id+" > form > div.boxbg").css(animate_hide.pre).animate(animate_hide.in, animate_hide.duration, function(){	
							
				jQuery( "#mebox"+id).animate({
				
			
				}, 0,function(){

						showBox();

						

				});
						
				
		});

		
		
		
		//Nowfocus = ListMeBoxArray
		//if(rules['background_full']==true){
				//jQuery("#mebox"+id+" > bg").css({'opacity':rules['background_opacity']});
				
			//}

	}
	

	this.setAttr = function(obj,param,nameid,id,type,val,title,actions){
			
		jQuery.each(param,function(attribute,value2){		

			if(JSON.stringify(value2) == undefined){							
				if(type == 'submit'){
					var	func = "jQuery('form[name=meboxForm"+id+"]').submit("+value2+");";
				}else{								
					var func = "jQuery('"+obj+"').bind('"+attribute+"',{id:'"+nameid+id+"',type:'"+type+"',val:'"+val+"',title:'"+title+"'},"+value2+");";										
				}												
			}else{

				if(attribute.indexOf('_hover') != -1){
					var attribute_ajust = String(attribute).replace('_hover','');
					var func = "jQuery('"+obj+"').mouseover(function(){jQuery(this)."+attribute_ajust+"("+JSON.stringify(value2)+");});";																						
				}else if(attribute.indexOf('_out') != -1){
					var attribute_ajust = String(attribute).replace('_out','');
					var func = "jQuery('"+obj+"').mouseout(function(){jQuery(this)."+attribute_ajust+"("+JSON.stringify(value2)+");});";										
				}else if(attribute.indexOf('_active') != -1){
					var attribute_ajust = String(attribute).replace('_active','');
					var func = "jQuery('"+obj+"').mousedown(function(){jQuery(this)."+attribute_ajust+"("+JSON.stringify(value2)+");});";															
				}else{

					var func = "jQuery('"+obj+"')."+attribute+"("+JSON.stringify(value2)+");";										
				}
			}
																								
			eval(func);																							
			//setTimeout(function(){eval(func);},1000);
		});	
	}

	// mostra  box
	this.ShowBox = function(action,id){		

		
		// start: captura e define o atributo posittion
		/*if(positionBox){
			var positionBox_element = positionBox['element'];	
			var positionBox_position = (positionBox['position']!=undefined)?positionBox['position']:'absolute';			
			var positionBox_TopRelative = (positionBox['top']!=undefined)?positionBox['top']:'0px';	
			var positionBox_LeftRelative = (positionBox['left']!=undefined)?positionBox['left']:'0px';	

			var positionBox_top = jQuery(positionBox_element).offset().top;
			var positionBox_left = jQuery(positionBox_element).offset().left;
			var positionBox_height = jQuery(positionBox_element).css('height');
				positionBox_height = positionBox_height.replace('px','');

		


			if(String(positionBox_TopRelative).indexOf('%')!= -1){
				positionBox_TopRelative = positionBox_TopRelative.replace('%','');
				if(positionBox_TopRelative < 1){
					var positionBox_height_pos = 0;
				}else if(positionBox_TopRelative >= 100){
					positionBox_TopRelative =1;
					var positionBox_height_pos = Number(positionBox_height)+(Number(positionBox_height)*positionBox_TopRelative);
				}else{
					positionBox_TopRelative = '0.'+positionBox_TopRelative;
					var positionBox_height_pos = Number(positionBox_height)+(Number(positionBox_height)*positionBox_TopRelative);
				}			
			}else{
				positionBox_TopRelative = positionBox_TopRelative.replace('px','');
				
				var positionBox_height_pos = Number(positionBox_TopRelative);				
			}



			if(String(positionBox_LeftRelative).indexOf('%')!= -1){
				
				positionBox_LeftRelative = positionBox_LeftRelative.replace('%','');
				if(positionBox_LeftRelative < 1){
					var positionBox_width_pos = 0;
				}else if(positionBox_LeftRelative >= 100){
					positionBox_LeftRelative =1;
					var positionBox_width_pos = Number(positionBox_height)+(Number(positionBox_height)*positionBox_LeftRelative);
				}else{
					positionBox_LeftRelative = '0.'+positionBox_LeftRelative;
					var positionBox_widtht_pos = Number(positionBox_height)+(Number(positionBox_height)*positionBox_LeftRelative);
				}		
			}else{
				positionBox_LeftRelative = positionBox_LeftRelative.replace('px','');				
				var positionBox_width_pos = Number(positionBox_LeftRelative);				
			}


			jQuery( "#mebox"+id+" > form > div.boxbg .meboxboxinner").css({				
				'position':positionBox_position,
				'top':positionBox_top+positionBox_height_pos+'px',
				'left':positionBox_left+positionBox_width_pos+'px'
			});
		// end: captura e define o atributo posittion
			
			
			
		}*/



		var context = this;
			jQuery( "#mebox"+id).css({visibility: "visible"}).animate({
				
			
				}, 0, function() {	

					//alert(animate_show.pre);
					//var this = context;
					if(animate_show.pre != undefined){
						jQuery( "#mebox"+id+" > form > div.boxbg ").css(animate_show.pre);
					}

					jQuery( "#mebox"+id+" > form > div.boxbg ").animate(animate_show.in, animate_show.duration, function() {						
						
						if(action){action(id);}							

						if(this.forceclosebox == true){							
							this.forceclosebox = false;
						}else{		
							
							

								// fecha popup ao clicar em ESQ (firefox)
								jQuery(document).bind('keyup', function(e) {													
									var code = e.keyCode || e.which;	
									

									context.keyup(context,code,e,ListBox,parent.actions);
								
									
									 
								});	

								// fecha popup ao clicar em ESQ (chrome)
								jQuery(document).keydown(function(e) {  //keypress did not work with ESC;							
								    if (event.which == '27') {
								      	if(rules['escape'] == true &&   id == Nowfocus){								
									 	context.CloseBox(id);								 
								    	context.forceclosebox = false;
								    	}
								    }
								    else if (window.event.which){						     
								    }
								}); 

							
								
						}

					});
			});
	}	


	this.keyup = function(context,code,e,ListBox,actions){

			jQuery.each(ListBox,function(index,value){
				jQuery.each(value,function(index2,value2){
					if(index2 == 'me' && value2 == Nowfocus){
						rules = value;
						//alert(index2+'-'+value2);
					}
						
				});
				
			});

		

			 if(rules['escape'] == true && code == 27) {	
			 //alert(id+'-'+Nowfocus);								 	
			 	//if(id == Nowfocus){	

			 	context.CloseBox(Nowfocus);								 
		    	context.forceclosebox = false;
		    	//}
			 }


			 if(rules['escape'] != null && rules['escape'] != true && rules['escape'] != false && code == 27){									 	
			 	var escapes = rules['escape'];	
			 			 	 
			 	escapes(e,rules['rules'],actions);
			 }

			var keypress = rules['keypress'];									
			var keyarray = String(keypress.up.key).split(',');
				
			/* verifica se existe o atributo up dentro de keypress	
			* e tambÃ©m verifica se existe o atributo composto por underline e o numero da tecla ex: _13, se existir
			* executa o cÃ³digo desta funÃ§Ã£o dentro do atributo, ex: _13
			*/
			jQuery.each(keypress.up,function(index,value){
				if(String(index).indexOf("_") != -1){
					var key = String(index).replace('_','');
					if(code == key){
						value(actions);
					}
				}
			});

			// executa se key for indefinido, executa ao pressionar qualquer tecla, passando o parametro da tecla
			if(keypress.up.key == undefined){
				keypress.up.call(code,e);
			}

			// executa se key estiver definido, executa conforme tecla registrado pela key
			for(var keyarrays in keyarray){									 
			 	if(code == keyarray[keyarrays]) {

				 	keypress.up.call(code,e);										 
				 }
			}
	}

}


var mebox = new MeBox();
