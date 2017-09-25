/**
 * [MeTabs] v.1.1
 * Criar abas e container
 *
 * Desenvolvido por: Wallace Rio
 * wallrio.com
 * 
 */

(function(){

	function MeTabs(){
		this.animateStart = null;
		this.animateStop = null;
		this.animateEnd = null;

		this.timeNext = null;
		this.timePrev = null;

		this.options = Array();

		this.rules = {
			animateStop:
				[{				
			
					'opacity':1,
					  'marginLeft':'+=100px',
					'duration':200,
					'wait':1
				}]
			,			
			animateEnd:
				[{
				 'opacity':0,
				  'marginLeft':'-100px',
				'duration':1,
				'wait':1
				}]		
		}

		this.animate = function(id,options){				
			if($(id)){
				$(id).attr({'data-animate':JSON.stringify(options)});
			}	
		}
		
		this.init = function(options){
			var parent = this;

			$.each($('[data-metabs]'),function(index,value){
				
				var objMetabs = $(value);
				var mode = objMetabs.attr('data-mode');
				var autostep = (objMetabs.attr('data-auto') != undefined)?objMetabs.attr('data-auto'):'false';
				var datadelay = (objMetabs.attr('data-delay') != undefined)?objMetabs.attr('data-delay'):3000;
				var datausehash = (objMetabs.attr('data-usehash') != undefined)?objMetabs.attr('data-usehash'):"false";

				if(datausehash == 'true'){
					mode = '';
				}

				if(autostep == 'true'){			
					metabs.autoNext(objMetabs.find('[data-rel="tabContainer"] > a:not([data-state="active"])'),datadelay);
				}

				

				if(mode == 'continue'){			
					objMetabs.find('[data-rel="tabContainer"] > a:not([data-state="active"])').attr({'disabled':'disabled'});		
					metabs.block(objMetabs);			
				}else{					

					//var idTab = $(this).find('[data-rel="tabContainer"] > a[data-state="active"]').attr('data-for');
					//objMetabs.parent().find('[data-for="'+idTab+'"]').click();
					
					
					
					//var objTab = objMetabs.find('[id="'+idTab+'"]').click();
					//metabs.toogle(metabs.toogle($(this),rules),rules);		

					objMetabs.find('[data-rel="tabContainer"] > a').click(function(param){						
						var rules = parent.rules;	
						


						metabs.toogle($(this),rules);		

					});

				}

				

				if(datausehash == 'true'){
					var hash = window.location.hash;
					hash = hash.replace('#','');								
					objMetabs.parent().find('[data-for="'+hash+'"]').click();	

					if(window.attachEvent){
						window.attachEvent ("onmouseup", function(){
							parent.hashChanged(objMetabs);
						});
						window.addEventListener("hashchange", function(){
							parent.hashChanged(objMetabs);
						}, true);
					}else{
						window.addEventListener("hashchange", function(){
							parent.hashChanged(objMetabs);
						}, true);
					}

					
				}else{
					var idTab = objMetabs.find('[data-rel="tabContainer"] > a[data-state="active"]').attr('data-for');
					objMetabs.parent().find('[data-rel="metabs_content"][id="'+idTab+'"]').attr({'data-status':'active'});						
					metabs.toogle( objMetabs.find('[data-rel="tabContainer"] > a[data-state="active"]') ,parent.rules);	
				}
				
			});
		}

		this.hashChanged = function(objMetabs){
			var hash = window.location.hash;
			hash = hash.replace('#','');			
			objMetabs.parent().find('[data-for="'+hash+'"]').click();	
		}

		this.autoPrev = function(obj){
			this.timePrev = setInterval(function(){							
					metabs.prev(obj);
					
				},1000);
		}

		this.autoNext = function(obj,datadelay){	

			this.timeNext = setInterval(function(){							
					
					metabs.next(obj);				
				},datadelay);		
		}


		this.next = function(obj){

			var parent = this;	
			var bot = null;

			if(typeof obj == 'string'){
				bot = $(obj).find('[data-rel="tabContainer"] > a[data-state="active"]');				
			}else{
				bot = $(obj).parents('[data-metabs]').find('[data-rel="tabContainer"] > a[data-state="active"]');				
			}
			
			var total = bot.parents('[data-metabs]').find('[data-rel="tabContainer"] > a').length-1;
			var index = bot.index();
			
			
			
			var rules = null;

			if(index == total){
				bot.parent().find('a:first-child').click();				
				return;
			}
			
			var animate = $(obj).parents('[data-metabs]').attr('data-animate');		
			


			if(animate){		

				str = JSON.stringify(eval('('+animate+')'));
				rules = JSON.parse(str);		
			}else{
				rules = this.rules;
				//alert(JSON.stringify(rules));
			}

			//alert(animate);
				//$(id).attr({'data-animate':JSON.stringify(options)});

			metabs.toogle(bot.next(),rules);	
		
			bot.next().removeAttr('disabled');		
			bot.prev().click(function(){
					
					metabs.toogle($(this),rules);	
			});
			bot.next().click(function(){
							
					metabs.toogle($(this),rules);	
			});
			bot.click(function(){
							
					metabs.toogle($(this),rules);	
			});
		}


		this.prev = function(obj){

			var bot = null;

			if(typeof obj == 'string'){
				bot = $(obj).find('[data-rel="tabContainer"] > a[data-state="active"]');	
			}else{
				bot = $(obj).parents('div').find('[data-rel="tabContainer"] > a[data-state="active"]');	
			}

			
			bot.prev().click();	
		}


		this.block = function(obj){		
			var parent = this;
				
			$(obj).find('[data-rel="tabContainer"] > a:not([data-state="active"])').attr({'data-block':'true'});		
			$(obj).find('[data-rel="tabContainer"] > a').click(function(){});

			$('a[data-type="nextTab"]').click(function(){														
			});

			$('a[data-type="prevTab"]').click(function(){			
				parent.prev();					
			});
		}


		this.toogle = function(obj,rules){
		//alert(JSON.stringify(rules));
			animateStop = rules['animateStop'];
			animateEnd = rules['animateEnd'];

			var parent = this;
			
			if(animateStop == null || animateStop == undefined){
				animateStop = {'opacity':1};
			}

			if(animateEnd == null || animateEnd == undefined){
				animateEnd = {'opacity':1};
			}
			
			this.animateStop = animateStop;
			this.animateEnd = animateEnd;

			var idTabContent = obj.attr('data-for');
			
			obj.parent().css({
				'height':'auto',
				'min-height':obj.parent().css('height')

			});
			
			
			
			
			// atualiza botao da tabs
			obj.parent().find('a').attr({'data-state':''});
			obj.attr({'data-state':'active'});

			var preload = obj.attr('data-preload');
			if(preload){eval(preload);}

			var usehash = $(obj).parents('[data-metabs]').attr('data-usehash');		
			if(usehash == "true"){
				this.preload_method(obj.parent().find('a[data-state="active"]').attr('data-for'));
			}

			parent.changeContent(obj,idTabContent);
		
		}


		this.show = function(obj,idTabContent){	

			var act = obj.parents('div').find('[data-for="'+idTabContent+'"]').attr('data-onload');
			eval(act);		

		}

		this.posload_method = function(){
			
		}


		this.preload_method = function(id){
			window.location.hash = id;
		}

		

		this.checkShow = function(thiss,obj,idTabContent){
			var parent = this;
			obj.parents('div').parent().find('div#'+idTabContent+'').parent().find('[data-rel="metabs_content"]').css({'display':'none'});

			var form = obj.attr('data-for');	
			var index = obj.index()+1;
			
			var posload = obj.attr('data-posload');

			var total = obj.parents('[data-metabs]').find('div[data-rel="metabs_content"]').length;
		

			var animate = obj.parents('[data-metabs]').attr('data-animate');				
			if(animate){		
				var str = JSON.stringify(eval('('+animate+')'));							
				rules = JSON.parse(str);	

			}else{				
				rules = parent;
			}




			for(var a = 0;a<= rules.animateStop.length-1;a++){	

				obj.parents('[data-metabs]').find('div[data-rel="metabs_content"]').stop();	
				
				$('#'+form).css({'display':'table','width':'100%','opacity':0})

					

					$('#'+form).animate(rules.animateStop[a],rules.animateStop[a].duration,function(){				
						

						var tabText = obj.html();
						obj.parents('[data-metabs]').attr({'data-activetab':tabText});
						var onactive = obj.parents('[data-metabs]').attr('data-onactive');	
						//alert(obj.parents('[data-metabs]').attr('data-activetab'));	
						eval(onactive);

						if(posload){eval(posload);}

						parent.posload_method();

					if(index == total){	
						var oncomplete = $(thiss).parents('[data-metabs]').attr('data-oncomplete');						
						if(oncomplete){eval(oncomplete);}									
					}			
					index++;
				});				
			}	
		
		}


		this.changeContent = function(obj,idTabContent){

			var parent = this;
			var index = 1;
			var ObjanimateEnd = null;
			var elemParent = undefined;

			var total = obj.parents('[data-metabs]').find('div[data-rel="metabs_content"]').length;

			
			//alert(obj.parents('[data-metabs]').html());

			var animate = obj.parents('[data-metabs]').attr('data-animate');				
			if(animate){		
				var str = JSON.stringify(eval('('+animate+')'));							
				rules = JSON.parse(str);	

			}else{				
				rules = parent;
			}

			//alert(JSON.stringify(rules));

			if(obj.parents('[data-metabs]').attr('id') == 'metabs_banner'){
				//return;
			}

									
			for(var i = 0;i<= rules.animateEnd.length-1;i++){		
				obj.parents('[data-metabs]').find('div[data-rel="metabs_content"]').stop();	

				
				obj.parents('[data-metabs]').find('div[data-rel="metabs_content"]').animate(rules.animateEnd[i],rules.animateEnd[i].duration,function(){				

					

					if(index == total){
						var onload = obj.attr('data-onload');
						if(onload){eval(onload);}
						//alert(obj.html());
						parent.checkShow(obj,obj,idTabContent);
					}			
					index++;
				});		

			}
		
		}


		if ( window.attachEvent ) { 
			window.attachEvent( "onload", function(){
				metabs.init();
			} );
		}else{		
			window.addEventListener( "load", function(){								
				metabs.init();
			}, false );
		}


	}


	metabs = new MeTabs();

})();


