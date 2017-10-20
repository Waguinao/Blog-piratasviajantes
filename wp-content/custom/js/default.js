var cookie = {
	set:function(cname, cvalue, exdays) {
		    var d = new Date();
		    d.setTime(d.getTime() + (exdays*24*60*60*1000));
		    var expires = "expires="+ d.toUTCString();
		    document.cookie = cname + "=" + cvalue + "; " + expires;
		 
	},
	get:function(cname) {
	    var name = cname + "=";
	    var ca = document.cookie.split(';');
	    for(var i = 0; i <ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') {
	            c = c.substring(1);
	        }
	        if (c.indexOf(name) == 0) {
	            return c.substring(name.length,c.length);
	        }
	    }
	    return "";
	} 
}


windbox('popupsuccess',{
	icon:"",
	title:"<p style='color:#fff;text-align: center;padding: 11px;'>Estamos quase no final,<br>basta confirmar seu cadastro através do email que enviamos para você! </p>",	
	content:{
        value:""
    },    
    input:{
    	"ok":{
			container:'content',
			type:'submit',
			value:"Ok",
			css:{
				out:{
					"background":"#cdd500",
					"color":"#005baa",
					"border-radius":"1px",
					"border":"0px",
					"padding":"8px 12px",
					"font-weight":"bold",
					"margin-left":"3px"
				}
			},
			click:function(){
				action.close();
				action.close('popup');
			}
		}
    }

});


var popupPorcent = '70%';
if(windbox().windowSize().width>700)
	var popupPorcent = '50%';

windbox('popup',{
	icon:"",
	title:"",	
	content:{
         img:{              
            size:0.4,               
            src:'http://www.melhorembarque.com.br/wp-content/custom/js/lightbox_3.png'
            // src:'http://localhost/github/melhorembarque-blog/sitenovo/wp-content/custom/js/lightbox_3.png'
            // src:'http://sitenovo.melhorembarque.com.br/wp-content/custom/js/lightbox_3.png'
        }       
    },
	// content:{
		// value:"Receba nossas ofertas, <strong>seu cadastro é grátis.</strong>"
		// value:"<img src='http://www.melhorembarque.com.br/wp-content/custom/js/Lightbox_2.jpg' style='height:100%'>"
	// },
	// fixed:true,
	css:{
		box:{
			out:{					
				'width':popupPorcent,
				'text-align':'center'			
				
			},
			hover:{		
				'width':popupPorcent,
				'text-align':'center'		
				
			}
		}
	},
	
	input:{

	
		"email":{
			container:'control-center',
			type:'text',
			placeholder:"Email",
			required:true,
			css:{
				out:{
					"width":"100%",
					"margin":"auto",
					"border-radius":"1px",
					"text-align":"left",
					"margin-bottom":"3px",
					"padding":"0px 6px",
					"border":"0px",
					"max-width":"none"
					
				}
			}		
		},
		"close":{
			container:'header-right',
			type:'a',
			value:"",
			cssclass:"popupclosewindow",
			click:function(){
				action.close();
			}
		},
		

		/*"state":{
			container:'content',
			type:'select',
			required:true,
			options:[
				{'value':'','text':'Selecione seu Estado','selected':true},
				{'value':'Acre','text':'Acre'},
				{'value':'Alagoas','text':'Alagoas'},
				{'value':'Amapá','text':'Amapá'},
				{'value':'Amazonas','text':'Amazonas'},
				{'value':'Bahia','text':'Bahia'},
				{'value':'Ceará','text':'Ceará'},
				{'value':'Distrito Federal','text':'Distrito Federal'},
				{'value':'Espírito Santo','text':'Espírito Santo'},
				{'value':'Goiás','text':'Goiás'},
				{'value':'Maranhão','text':'Maranhão'},
				{'value':'Mato Grosso','text':'Mato Grosso'},
				{'value':'Mato Grosso do Sul','text':'Mato Grosso do Sul'},
				{'value':'Minas Gerais','text':'Minas Gerais'},
				{'value':'Pará','text':'Pará'},
				{'value':'Paraíba','text':'Paraíba'},
				{'value':'Paraná','text':'Paraná'},
				{'value':'Pernambuco','text':'Pernambuco'},
				{'value':'Piauí','text':'Piauí'},
				{'value':'Rio de Janeiro','text':'Rio de Janeiro'},
				{'value':'Rio Grande do Norte','text':'Rio Grande do Norte'},
				{'value':'Rio Grande do Sul','text':'Rio Grande do Sul'},
				{'value':'Rondônia','text':'Rondônia'},
				{'value':'Roraima','text':'Roraima'},
				{'value':'Santa Catarina','text':'Santa Catarina'},
				{'value':'São Paulo','text':'São Paulo'},
				{'value':'Sergipe','text':'Sergipe'},
				{'value':'Tocantins','text':'Tocantins'}
			]
		},*/
		
		/*"col2":{
			container:"content",
			type:"column",	
			css:{				
					'out':{				
				}
			}		
		},*/

		
		"ok":{
			container:'control-center',
			type:'submit',
			value:"QUERO RECEBER <br>AS MELHORES PROMOÇÕES!",
			css:{
				out:{
					"background":"#cdd500",
					"color":"#005baa",
					"border-radius":"1px",
					"border":"0px",
					"padding":"8px 12px",
					"font-weight":"bold",
					"white-space": "pre-wrap",
					"width":"100%",
					"margin":"auto",
					"box-shadow": "none",
					"border-radius": "4px",
					"margin-top": "10px"
				}
			},
			click:function(){			
				var email = action.input('email').value;
		
			
				jQuery.ajax({
				  type: 'get',				 
				  url: 'http://melhorembarque.us10.list-manage.com/subscribe/post-json',				 	
				 	data: "u=2d39588dfed0f7cd514473855&id=146ce87ca1&EMAIL="+email,			
				 	contentType: "application/x-www-form-urlencoded",				
				  success: function(response) { 
				  	
				   },
				    error: function(response) { 
			
				   },
				    complete: function(response) { 				    
						windbox('popupsuccess').show();			
				   },
				});


				


				return false;
			}
		},
		/*"close2":{
			container:'control-center',
			type:'a',
			value:"Fechar",
			css:{
				out:{					
					"width":"auto",
					"margin":"auto",
					"display": "table"
					
				}
			},
			// cssclass:"popupclosewindow",
			click:function(){
				action.close();
			}
		},*/
	}
});


function adjustImage(){
	var window_width = jQuery(window).width();	
	if(window_width<800)
		jQuery('.entry-content img').width(window_width-15);
	else
		jQuery('.entry-content img').css({'width':'auto'});
}

jQuery(document).ready(function(){
	adjustImage();	
});

jQuery(window).resize(function(){
	adjustImage();	
});