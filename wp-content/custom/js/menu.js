if(!menuSlider)
	function menuSlider(){}


menuSlider.addEvent = function(objs,event,callback,mode,par1,par2,par3,par4){		
	if(mode == undefined)
		mode = true;

	if(objs == undefined)
		objs = window; 
	if(objs.addEventListener){ 				
		return objs.addEventListener(event,function(e){
			e.preventDefault();
			if(callback){
				var returns = callback(objs,e,par1,par2,par3,par4);
				return returns;
			}
		},mode); 
	}else if(objs.attachEvent){
		return objs.attachEvent('on'+event,function(e){
			e.preventDefault();
			if(callback){
				var returns = callback(objs,e,par1,par2,par3,par4);
				return returns;
			}
		}); 
	}
}


menuSlider.addEvent(window,'load',function(){
	
	

	document.querySelector('.menuSlider-action').onclick = function(){
		var status = this.getAttribute('data-status');	
		if(status == 'active')	
			this.removeAttribute('data-status');			
		else
			this.setAttribute('data-status','active');			
		
	}

	var menuSliderButtonAll = document.querySelectorAll('.mega-menuSliderButton');

	for (var i = 0; i < menuSliderButtonAll.length; i++) {		
				
		menuSliderButtonAll[i].querySelector('a').onclick = function(e){		
			
			e.preventDefault();

			var actionMenuSlide = document.querySelector('.menuSlider-action');	
			var status = actionMenuSlide.getAttribute('data-status');				
			if(status == 'active')	
				actionMenuSlide.removeAttribute('data-status');			
			else
				actionMenuSlide.setAttribute('data-status','active');	

			return false;
		}
	};


	/*document.querySelector('body').onclick = function(e){
		if(e.target.getAttribute('data-menuslide')==null){					
			document.querySelector('.menuPainel').removeAttribute('data-status');			
		}				
	}*/
});