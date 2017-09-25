// alert(window.location);
windbox('blackfriday',{
	icon:"",
	title:"",	
	cssclass:'windbox_onlyimage',
	forcecenter:true,
	fixed:true,
	content:{
         img:{              
            size:0.9,                       
            // src:'http://localhost/github/melhorembarque-blog/estrutura/wp-content/custom/img/popup_blackfriday.gif',            
            src:window.location+'/wp-content/custom/img/popup_blackfriday.gif',                        
            action:{
            	click:function(){
            		window.open('https://goo.gl/cKJRDg','_blank');
            		action.close();
            	}
            }
        }       
    },
	/*content:{
        value:""
    },    */
    css:{
		box:{
			out:{					
				'width':'90%',
				'text-align':'center'			
				
			},
			hover:{		
				'width':'90%',
				'text-align':'center'		
				
			}
		}
	},
    input:{
    	"close":{
			container:'header-right',
			type:'a',
			value:"",
			cssclass:"popupclosewindow",
			click:function(){
				action.close();
			}
		},
    }

});