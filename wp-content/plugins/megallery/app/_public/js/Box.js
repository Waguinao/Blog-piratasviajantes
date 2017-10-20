function Box(){
	this.questions = function(icon,description,callbackSim,callbackNao){				
				var rules = {
					id:'question',
					icon:icon,
					content:description,
					parameters:{'callbackSim':callbackSim,'callbackNao':callbackNao},
					buttonControls:{'sim':['a','Sim'],'nao':['a','Não']},
					fixed:true,
					drag:true,
					param_sim:{
						click:function(){
							actions.close();
							var callbackSim = actions.parameters.callbackSim;
							if(typeof callbackSim == 'function'){
								callbackSim();
							}
						}
					},									
					param_nao:{
						click:function(){
							actions.close();
							var callbackNao = actions.parameters.callbackNao;
							if(typeof callbackNao == 'function'){
								callbackNao();
							}
						}
					},									
					param_box:{
						 css:{
						 	'border':'1px solid transparent',						 	
						}
					}									
				}
				mebox.Box(rules);			
	}
}
var box = new Box();
