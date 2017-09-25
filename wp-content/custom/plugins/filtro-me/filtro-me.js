/**
 * Filtro de links para o Melhor Embarque v1.5
 * ---------------------------------------
 * Este script cria um filtro para os links das promoçoes de passagens contidos nos posts, ao ser inicializado
 * criara um box.
 *
 * Developed by Wallace Rio <wallrio@gmail.com>
 * 
 */

// table design --------------------------------------------------------------------------------
(function(){
	
	var self = this;

	/**
	 * monitora novas tabelas do filtro	 
	 */
	this.monitorTable = function(){
		var tableList = document.querySelectorAll('[data-design-table]');	
		for (var i = 0; i < tableList.length; i++) {
			var element = tableList[i];

			if(element.dataDesignTableInit == 1)continue;
			element.dataDesignTableInit = 1;

			this.make(element);

		}
		setTimeout(function(){			
			this.monitorTable();
		},300);
	}

	/**
	 * altera a tabela
	 */
	this.make = function(element){		

		var tHeadList = element.querySelectorAll('[data-design-table] tr:first-child th');
		var tBodyList = element.querySelectorAll('[data-design-table] tr td');			
		var a=-1,tr,tdContent;
		for (var i = 0; i < tBodyList.length; i++) {

			tr = tBodyList[i];
			
			a++;			
			if(a>tHeadList.length-1)a=0;
						
			if(tHeadList[a]== undefined)continue;

			tdContent = tr.innerHTML;			
			tr.innerHTML = '<span data-design-table-th-label >'+tHeadList[a].innerHTML+'</span>'+'<span data-design-table-th-content >'+tdContent+'</span>';
			
		}
	}

	this.__construct = function(){
		this.monitorTable();
	}

	this.__construct();
	
})();




// box struct --------------------------------------------------------------------------------
(function(){

	var self = this;

	this.listCount = 0;
	this.listCountArray = 0;
	this.list = Array();
	this.listNew = Array();
	this.firstEl;
	this.countainer;

	/**
	 * monitora links na página
	 * @return null
	 */
	this.monitor = function(){

		var element,					
			list = Array(),			
			linkFlightList = document.querySelectorAll('a:not([data-filtromeLink])[href*="http://www.viajanet.com.br/busca/voos-resultados#"],a:not([data-filtromeLink])[href*="https://www.viajanet.com.br/busca/voos-resultados#"],a:not([data-filtromeLink])[href*="http://decolar.com/rededeafiliados/tracking"],a:not([data-filtromeLink])[href*="http://despegar.com/reddeafiliados/tracking/link"]');

		var linkFlightListBR = document.querySelectorAll('a:not([data-filtromeLink])[href*="http://www.viajanet.com.br/busca/voos-resultados#"] + br,a:not([data-filtromeLink])[href*="https://www.viajanet.com.br/busca/voos-resultados#"] + br,a:not([data-filtromeLink])[href*="http://decolar.com/rededeafiliados/tracking"] + br,a:not([data-filtromeLink])[href*="http://despegar.com/reddeafiliados/tracking/link"] + br');		
		for (var i = 0; i < linkFlightListBR.length; i++) {
			var elementBr = linkFlightListBR[i];
			elementBr.parentNode.removeChild(elementBr);
		}
	
		for (var i = 0; i < linkFlightList.length; i++) {
			element = linkFlightList[i];

			if(element.filtromeinit == 1) continue;
			element.filtromeinit = 1;

			if(i == 0){
				this.firstEl = element;
				var containerEl = document.createElement('div');
				containerEl.setAttribute('data-filtromeContainer','');
				this.countainer = containerEl;
				element.parentNode.insertBefore(containerEl,element);			
			}

			this.list[this.listCountArray] = {
				value:element.href,
				title:element.textContent
			};

			this.listCountArray++;
			
			if(i > 0){
				if(element.parentNode.tagName.toLowerCase() == 'li'){
					element.parentNode.parentNode.removeChild(element.parentNode);
				}else{
					element.parentNode.removeChild(element);
				}
			}
					
		}		

		if(this.listCount != this.list.length ){
			this.listCount = this.list.length;
			this.refresh();


			if(this.firstEl.parentNode.tagName.toLowerCase() == 'li'){
				this.firstEl.parentNode.parentNode.style='padding:0px;';
				this.firstEl.parentNode.style='list-style: none;';
				this.firstEl.parentNode.removeChild(this.firstEl);
			}else{
				this.firstEl.parentNode.removeChild(this.firstEl);
			}
			
		}


		setTimeout(function(){
			this.monitor();
		},300); 


		// remove a tag p quanto contiver apenas um ponto '.'
		setTimeout(function(){			
			var linkFlightPDot = document.querySelectorAll('p');
			for (var i = 0; i < linkFlightPDot.length; i++) {
				var contentP = linkFlightPDot[i].innerHTML;
				contentP = contentP.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/gm, '');
				contentP = contentP.replace(/(\r\n|\n|\r)/gm,"");
				contentP = contentP.replace(/ 	/gm," ");
			 	if(contentP == '.')
			 		linkFlightPDot[i].parentNode.removeChild(linkFlightPDot[i]);
			}
		},1000); 

		
	}

	/**
	 * esta função é chamada a cada novo link que não foi incluido no filtro	
	 */
	this.refresh = function(){
		this.makeBoxHtml();
		
	}

	/**
	 * converte numero do mes para extenso
	 * @param  {integer|string} numberMonth [numero do mÊs]
	 * @return {string}             [mês por extenso]
	 */
	this.convertNumberToMonth = function(numberMonth){
		var monthsArray = {
			"01":"Janeiro",
			"02":"Fevereiro",
			"03":"Março",
			"04":"Abril",
			"05":"Maio",
			"06":"Junho",
			"07":"Julho",
			"08":"Agosto",
			"09":"Setembro",
			"10":"Outubro",
			"11":"Novembro",
			"12":"Dezembro"
		};
		return monthsArray[numberMonth];
	}

	/**
	 * cria o box do filtro
	 * @return {string} [html do filtro]
	 */
	this.makeBoxHtml = function(){

		for (var i = 0; i < this.list.length; i++) {
			var value = this.list[i].value,title = this.list[i].title;
				
			var titleMatch = title.match(/^(.*) – (.*) a partir de R\$ (.*) \((.*)\) – (.*) – (.*)/i);
			var titleMatch2 = title.match(/^(.*) – (.*) a partir de:? R\$ (.*) \((.*)\) – (.*) – (.*) – (.*).*/i);
			var titleMatch3 = title.match(/^(.*) – (.*) a partir de:? R\$ (.*) \((.*)\) – (.*) – (.*) – (.*) – (.*).*/i);
			
			//viajanet
			var titleMatch4 = value.match(/^(.+)?\/busca\/voos-resultados#\/(.*).*$/i);
			
			var target = titleMatch4[2];

			var targetDateStartArray = target.match(/^(.*)\/(.*)\/(.*)\/(.*)\/(.*)\/(.*)\/(.*)\/(.*)\/(.*)\/(.*)\/(.*)\/(.*)\/(.*)\/(.*)\/(.*)\/(.*)+$/i);
			var targetOrigem = targetDateStartArray[1];
			var targetDestino = targetDateStartArray[2];
			var targetTrajeto = targetDateStartArray[3];
			var targetDateStart = targetDateStartArray[4];
			var targetDateEnd = targetDateStartArray[5];

			var data = {
				'origem':targetOrigem,
				'destino':targetDestino,
				'trajeto':targetTrajeto,
				'datestart':targetDateStart,
				'dateend':targetDateEnd
			}
			
			if(titleMatch!=null) this.listNew[i] = {url:value,match:titleMatch,data:data};
			if(titleMatch2!=null) this.listNew[i] = {url:value,match:titleMatch2,data:data};
			if(titleMatch3!=null) this.listNew[i] = {url:value,match:titleMatch3,data:data};
		}
	
		var source = {},target = {},price = {},dateStart = {},dateEnd = {};
			
		var sourceCount = 0;

		for (var i = 0; i < this.listNew.length; i++) {

			if(this.listNew[i] == undefined) continue;

			var stringAll = this.listNew[i][0];
			source[this.listNew[i].match[1]] = this.listNew[i].match[1];
			target[this.listNew[i].match[2]] = this.listNew[i].match[2];			
			price[this.listNew[i].match[3]] = this.listNew[i].match[3];		
			// dateStart[this.listNew[i].match[5]] = this.listNew[i].match[5];			
			// dateEnd[this.listNew[i].match[6]] = this.listNew[i].match[6];			
			dateStart[this.listNew[i].data['datestart']] = this.listNew[i].data['datestart'];			
			dateEnd[this.listNew[i].data['dateend']] = this.listNew[i].data['dateend'];	

		}
	
		var sourceOption = '';			
		sourceOption += '<option value="[all]">Origem - Todos</option>';		
		for(key in source){
			sourceOption += '<option value="'+source[key]+'" >'+source[key]+'</option>';		
		}

		var targetOption = '';	
		targetOption += '<option value="[all]">Destino - Todos</option>';		
		for(key in target){
			targetOption += '<option value="'+target[key]+'">'+target[key]+'</option>';		
		}

		var permanenciaOption = '';	
		permanenciaOption += '<option value="[all]">Permanência - Todos</option>';					
		permanenciaOption += '<option value="0-3">até 3 dias</option>';
		permanenciaOption += '<option value="4-6">de 4 a 6 dias</option>';
		permanenciaOption += '<option value="7-10">de 7 a 10 dias</option>';
		permanenciaOption += '<option value="11-15">de 11 a 15 dias</option>';
		permanenciaOption += '<option value="16-1000">16 dias ou mais</option></select>';

		var priceOption = '';
		priceOption += '<option value="[all]" selected disabled>Preço</option>';		
		priceOption += '<option value="[all]">[Todos]</option>';		
		for(key in price){
			priceOption += '<option value="'+price[key]+'">'+price[key]+'</option>';		
		}

		var index = 0;
		var dateStartNew = [];
		var dateStartOption = '';
		dateStartOption += '<option value="[all]" selected >Mês - Todos</option>';			
		for(key in dateStart){
			var dateStartAdjustArray = dateStart[key].split('-');
			var dateStartAdjust = dateStartAdjustArray[1]+'/'+dateStartAdjustArray[2];
			var date1 = new Date( dateStartAdjustArray[2]+'-'+dateStartAdjustArray[1]+'-'+dateStartAdjustArray[0] );
			dateStartNew[index] = {timestamp:date1.getTime(),date:dateStartAdjust};
			index++;
		}
	
		dateStartNew.sort(function(a, b) {			
		    return parseFloat(a.timestamp) - parseFloat(b.timestamp);
		});
		
		var dateStartNewUnique = []	;
		for(key in dateStartNew){
			dateStartNewUnique[dateStartNew[key].date] = {timestamp:dateStartNew[key].timestamp,date:dateStartNew[key].date};
		}

		for(key in dateStartNewUnique){
			var dateNewArray = dateStartNewUnique[key].date.split('/');
			var dateNew = self.convertNumberToMonth(dateNewArray[0])+'/'+dateNewArray[1];
			dateStartOption += '<option value="'+dateStartNewUnique[key].date+'">'+dateNew+'</option>';		
		}

		var dateEndOption = '';
		dateEndOption += '<option value="[all]" selected disabled>Volta</option>';		
		dateEndOption += '<option value="[all]">[Todos]</option>';		
		for(key in dateEnd){
			dateEndOption += '<option value="'+dateEnd[key].timestamp+'">'+dateEnd[key].date+'</option>';		
		}

		

		var html = '';
		var sourceInputHtml = '<select data-filtromeSourceSelect >'+sourceOption+'</select>';
		var targetInputHtml = '<select data-filtromeTargetSelect >'+targetOption+'</select>';
		var priceInputHtml = '<select data-filtromePriceSelect >'+priceOption+'</select>';
		var dateStartInputHtml = '<select data-filtromeDateStartSelect >'+dateStartOption+'</select>';
		var dateEndInputHtml = '<select data-filtromeDateEndSelect >'+dateEndOption+'</select>';
		var permanenciaInputHtml = '<select data-permanenciaSelect >'+permanenciaOption+'</select>';
		var chooseButton = '<button data-filtromeButtonFilter >Filtrar</button>';

		var inputList= {
			sourceInputHtml:sourceInputHtml,
			targetInputHtml:targetInputHtml,
			priceInputHtml:priceInputHtml,
			dateStartInputHtml:dateStartInputHtml,
			dateEndInputHtml:dateEndInputHtml
		}

		html += '<label>Encontrado '+this.listNew.length+' promoções</label>';			
		html += '<table data-design-table-header>';			
		html += '<tr data-filtromeContainerControl>';
			html += '<th ><label>Filtros</label>'+sourceInputHtml+''+targetInputHtml+''+dateStartInputHtml+''+permanenciaInputHtml+'</th>';
			// html += '<th >'+sourceInputHtml+'</th>';
			// html += '<th >'+targetInputHtml+'</th>';
			// html += '<th >'+priceInputHtml+'</th>';
			// html += '<th ></th>';
			html += '<th ></th>';
			html += '<th></th>';		
			// html += '<th>Data de Ida<br>'+dateStartInputHtml+'</th>';
			// html += '<th>Data de Volta<br>'+dateEndInputHtml+'</th>';		
		html += '</tr>';
		html += '<tr >';

		html += '</tr>';
		html += '</table>';


		html += '<div data-filtromeContainerBody ><tr><td><p>Selecione um destino, origem e clique em filtrar</p></td></tr></div>';
		html += '</div>';
		this.countainer.innerHTML = html;

		setTimeout(function(){
			this.setAction();
		},1000);
		
		this.showList('[all]','[all]','[all]','[all]','[all]','[all]');
	}

	/**
	 * mostra o html baseado na filtragem
	 */
	this.showList = function(sourceInput,targetInput,priceInput,dateStartInput,dateEndInput,permanenciaInputInput){
		document.querySelector('[data-filtromeContainerBody]').innerHTML = this.getListHtml(sourceInput,targetInput,priceInput,dateStartInput,dateEndInput,permanenciaInputInput);

	}

	/**
	 * monta o HTML baseado na filtragem
	 */
	this.getListHtml = function(sourceInput,targetInput,priceInput,dateStartInput,dateEndInput,permanenciaInputInput){
		var html = '';

		
		

		html += '<table data-design-table>';			
		html += '<tr >';	
			html += '<th>Origem</th>';
			html += '<th>Destino</th>';			
			html += '<th >Ida</th>';
			html += '<th>Volta</th>';		
			html += '<th>Perm.</th>';		
			html += '<th>Valor</th>';		
			// html += '<th>Data de Ida<br>'+dateStartInputHtml+'</th>';
			// html += '<th>Data de Volta<br>'+dateEndInputHtml+'</th>';
		html += '</tr>';

		var AdaptList = [];
		var index = 0;
		for (var i = 0; i < this.listNew.length; i++) {
			if(this.listNew[i] == undefined) continue;
			var stringAll = this.listNew[i].match[0];
			var source = this.listNew[i].match[1];
			var target = this.listNew[i].match[2];			
			var price = this.listNew[i].match[3];
			/*var dateStart = this.listNew[i].match[5];
			var dateEnd = this.listNew[i].match[6];*/
			var dateStart = this.listNew[i].data.datestart;
			var dateEnd = this.listNew[i].data.dateend;
			
			var dateStartArray = dateStart.split('-');			
			var newDateStart = dateStartArray[2]+"/"+dateStartArray[1]+'/'+dateStartArray[0];
			var newDateMDStart = dateStartArray[0]+"/"+dateStartArray[1];
			var newDateMYStart = dateStartArray[1]+"/"+dateStartArray[2];

			var url = this.listNew[i].url;
			
			if(sourceInput != '[all]' && sourceInput != '' && sourceInput != undefined && sourceInput != source)continue;
			if(targetInput != '[all]' && targetInput != '' && targetInput != undefined && targetInput != target)continue;			
			if(priceInput != '[all]' && priceInput != '' && priceInput != price)continue;			
			if(dateStartInput != '[all]' && dateStartInput != '' && dateStartInput != undefined && dateStartInput != newDateMYStart)continue;
			if(dateEndInput != '[all]' && dateEndInput != '' && dateEndInput != undefined && dateEndInput != dateEnd)continue;
			
			
			var dateEndArray = dateEnd.split('-');
			var newDateEnd = dateEndArray[2]+"/"+dateEndArray[1]+'/'+dateEndArray[0];
			var newDateMDEnd = dateEndArray[0]+"/"+dateEndArray[1];
		
			var date1 = new Date(newDateStart);
			var date2 = new Date(newDateEnd);
			var timeDiff = Math.abs(date1.getTime() - date2.getTime());
			var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
			var permanencia = diffDays;


			var permanenciaInputInputArray = permanenciaInputInput.split('-');
			if( ( permanencia >= permanenciaInputInputArray[0] &&
				  permanencia <= permanenciaInputInputArray[1] ) ||  ( permanenciaInputInput == '[all]' ) 
				){}else{continue};
			
			
			AdaptList[index] = {
				'source':source,
				'target':target,
				'price':price,
				'dateStart':newDateMDStart,
				'dateEnd':newDateMDEnd,
				'permanencia':permanencia
			};
			
			index++;
		}

		AdaptList.sort(function(a, b) {
		    return parseFloat(a.price) - parseFloat(b.price);
		});

	
		var listcount = AdaptList.length;

		for (var i = 0; i < listcount; i++) {
			var item = AdaptList[i];
			
			price = item.price;
			price = parseFloat(price).toFixed(3);
			
			html += '<tr onclick=window.open("'+url+'","_blank")>';			

				html += '<td class="tdCource">';							
				html += ''+item.source+'';						
				html += '</td>';
				html += '<td class="tdTarget">';
				html += ''+item.target+'';						
				html += '</td>';
				
				html += '<td class="tdIda">';
				html += ''+item.dateStart+'';								
				html += '</td>';
				html += '<td class="tdVolta">';
				html += ''+item.dateEnd+'';			
				html += '</td>'	

				html += '<td class="tdPermanencia">';
				html += ''+item.permanencia+' dias';			
				html += '</td>'	

				html += '<td class="tdPrice">';
				html += '<label>R$ '+price+'</label>';						
				html += '</td>';								
			html += '</tr>';		
		}

		if(index < 1){
			html = '<tr><td><p>Nenhum resultado encontrado</p></td></tr>';		
		}else{
			html += '</table>';
		}

		return html;
	}

	/**
	 * define as ações dos listbox's
	 */
	this.setAction = function(){
		
		var act = function(){
			var sourceInputEl = document.querySelector('[data-filtromeSourceSelect]');
			var targetInputEl = document.querySelector('[data-filtromeTargetSelect]');			
			var priceInputInputEl = document.querySelector('[data-filtromePriceSelect]');			
			var dateStartInputInputEl = document.querySelector('[data-filtromeDateStartSelect]');			
			var dateEndInputInputEl = document.querySelector('[data-filtromeDateEndSelect]');			
			var permanenciaInputEl = document.querySelector('[data-permanenciaSelect]');			

			var sourceInput = sourceInputEl.options[sourceInputEl.selectedIndex].value;
			var targetInput = targetInputEl.options[targetInputEl.selectedIndex].value;
			var priceInputInput = '[all]';//priceInputInputEl.options[priceInputInputEl.selectedIndex].value;
			var dateStartInputInput = dateStartInputInputEl.options[dateStartInputInputEl.selectedIndex].value;
			var dateEndInputInput = '[all]';//dateEndInputInputEl.options[dateEndInputInputEl.selectedIndex].value;
			var permanenciaInputInput = permanenciaInputEl.options[permanenciaInputEl.selectedIndex].value;
			if(document.querySelector('[data-filtromeContainerBody] [data-design-table]'))
			document.querySelector('[data-filtromeContainerBody] [data-design-table]').style['visibility'] = 'hidden';
			document.querySelector('[data-filtromeContainerBody]').innerHTML = self.getListHtml(sourceInput,targetInput,priceInputInput,dateStartInputInput,dateEndInputInput,permanenciaInputInput);
			setTimeout(function(){
				if(document.querySelector('[data-filtromeContainerBody] [data-design-table]'))
				document.querySelector('[data-filtromeContainerBody] [data-design-table]').style['visibility'] = 'visible';
			},500);
			
		}

		
		document.querySelector('[data-filtromeSourceSelect]').onchange = function(){
			act();
		}

		document.querySelector('[data-filtromeTargetSelect]').onchange = function(){
			act();
		}
	
		document.querySelector('[data-filtromeDateStartSelect]').onchange = function(){
			act();
		}


		document.querySelector('[data-permanenciaSelect]').onchange = function(){
			act();
		}
		
	}

	this.__construct = function(){
		this.monitor();
	}

	this.__construct();
	window.filtrome = this;
})();

