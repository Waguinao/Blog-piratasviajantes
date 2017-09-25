if(!CustomWordPress)
function CustomWordPress(){}

CustomWordPress.addEvent = function(objs,event,callback,mode,elem2,table){
	
	if(mode == undefined)
		mode = true;

	if(objs == undefined)
		objs = window; 
	if(objs.addEventListener){ 				
		return objs.addEventListener(event,function(){
			if(callback)
				callback(objs,elem2,table);
		},mode); 
	}else if(objs.attachEvent){
		return objs.attachEvent('on'+event,function(){
			if(callback)
				callback(objs,elem2,table);
		}); 
	}
}

CustomWordPress.search = function(term){
	window.location = 'querygoogle?q='+term;
}




CustomWordPress.onscroll = function(){
	
		var headerBarHeight = 0;
		var doc = document.documentElement;
		var scrollTop = (window.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0);

		if(document.querySelector('#header'))
			headerBarHeight = document.querySelector('#header').offsetHeight;
		if(scrollTop>(headerBarHeight/4)){
			document.querySelector('#header').setAttribute('data-status','fixed');			
		}else{
			document.querySelector('#header').removeAttribute('data-status');			
		}

	
}



window.onscroll = function(){
	CustomWordPress.onscroll();
}
CustomWordPress.addEvent(window,'load',function(){

	CustomWordPress.onscroll();

	document.querySelector('#querygoogle [name="busca"]').onkeyup = function(e){
		var term = this.value;
		var key = e.keyCode;
		if(key == '13')CustomWordPress.search(term);
	}

	document.querySelector('#querygoogle').onclick = function(e){
		var term = document.querySelector('#querygoogle [name="busca"]').value;
		var elType = e.target.tagName.toLowerCase();
		if(elType == 'input')return false;

			CustomWordPress.search(term);
	}

	

});
