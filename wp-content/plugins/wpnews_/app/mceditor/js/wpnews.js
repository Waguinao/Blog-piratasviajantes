
(function() {

    javascriptUrls='';
    tinymce.create('tinymce.plugins.wpnewsbt', {
        init : function(ed, url) {

            javascriptUrls=url.substring(0,url.length-15);           
            // Register command for when button is clicked
            ed.addCommand('wpnews_addshortcode', function(a,donationId) {
                var maxcolumn = document.getElementsByName('maxcolumn')[0].value;
                var maxwords = document.getElementsByName('maxwords')[0].value;
                var duration = document.getElementsByName('duration')[0].value;
                var titlehide = document.getElementsByName('titlehide')[0].value;
                var titlenews = document.getElementsByName('titlenews')[0].value;
                var slug = document.getElementsByName('slug')[0].value;             
                tinymce.execCommand('mceInsertContent', false,'[wpnews slug="'+slug+'" maxcolumn="'+maxcolumn+'" maxwords="'+maxwords+'" duration="'+duration+'" titlehide="'+titlehide+'" titlenews="'+titlenews+'"]');
           
        }),

            // Register buttons - trigger above command when clicked
            ed.addButton('wpnews', {title : 'wpnews', image: javascriptUrls + 'assets/img/icon.png',
            onclick:function()
            {
           
                url = javascriptUrls + 'app/mceditor/php/actions.php';                
                ajax(url,function(result){  

                   // var urlcss = javascriptUrls + 'app/show/_assets/css/show.css';                
                   // ajax(urlcss,function(resultcss){                                           
                        box(result);
                   // });                 
                   
                });


            }});
        }
    });

    


    tinymce.PluginManager.add('wpnews', tinymce.plugins.wpnewsbt);
})();

/**
 * Request Ajax
 * @param  {string}   url      
 * @param  {Function} callback
 *
 */
function ajax(url,callback){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        callback(xhttp.responseText);    
    }
    }
    xhttp.open("GET", url, true);
    xhttp.send();
}

/**
 * show input box
 * @param  {json} categories [list of categories]
 *
 */
function box(categories){

     


    var categoriesObj = JSON.parse(categories);

    slugOptions = '<option value="" disabled selected>Select the category</option>';
    for (var i = 0; i < categoriesObj.length ;  i++) {
        slugOptions += '<option value="'+categoriesObj[i].slug+'">'+categoriesObj[i].name+'</option>';
    }

   // var customcss = "";

    var html = "<div class='wpnews_box' data-box='box1'>";
        html += "<div data-element='background'></div>";
        html += "<form name='wpnews_form' onsubmit='box_submit(); return false;'>";
            html += "<div data-element='box'>";
            
            html += "<div data-element='title'>WpNews</div>";

            html += "<div data-element='main'>";
            
            html += "<label>Category:<select  name='slug' >"+slugOptions+"</select></label>";
            html += "<label>Number of column:<input type='number' name='maxcolumn' value='3' min='1' max='6'></label>";
            html += "<label>Number of character:<input type='number' name='maxwords' value='150' ></label>";
            html += "<label>Duration of slider:<input type='number' name='duration' value='15000' min='1' ></label>";
            html += "<label>Show/Hide title post:<select  name='titlehide' ><option value='true' selected>Show</option><option value='false'>Hide</option></select></label>";
            html += "<label>Title Slider(empty use category name):<input type='text' name='titlenews'></label>";

            html += "<label><br>For customize layout, change the file 'stylenews.css' in plugin editor</label>";
            //html += "<label>Custom css:<textarea name='customcss'>"+customcss+"</textarea></label>";

            html += "</div>";

            html += "<div data-element='control'><input type='submit' value='Save'><a onclick='box_cloxe()'>Cancel</a></div>";
            html += "</div>";
        html += "</form>";
        
        html += "</div>";
        
        var node = document.createElement("DIV");                             
        node.id="wpnews_box1";
        node.innerHTML = html;
        
        document.body.appendChild(node); 
}

/**
 * close the input box 
 */
function box_cloxe(){
    var d =  document.body;
    var olddiv = document.getElementById('wpnews_box1');
    d.removeChild(olddiv);  
}

/**
 * insert shortcode in editor
 * @return {boolean} 
 */
function box_submit(){
   
  tinymce.execCommand('wpnews_addshortcode', false);
  var d =  document.body;//document.getElementById('wpnews_box1');
  var olddiv = document.getElementById('wpnews_box1');
  d.removeChild(olddiv);
  return false;
}

/**
 * [wpnewsaddshort description]
 * @param  {[type]} result [description]
 * @param  {[type]} status [description]
 * @return {[type]}        [description]
 */
/*function wpnewsaddshort(result,status){
    
    var resultObj = JSON.parse(result);

    var options="";
    $.each(resultObj,function(index,value){
        id = value.ID;
        post_title = value.post_title
        options += "<option value='"+id+"'>"+post_title+"</option>";
    });

    var select = '<select id="wpnewsShortCodeSelect" style="display: block;width:100%;margin-bottom: 10px;" >'+options+'</select>';
        select += '<div style="font-style:italic;">For correct showing, use the attribute parent, in page attributes section on page edition.</div>';
        select += '<div style="font-style:italic;">example: product page > [parent of] > model page > [parent of] > category page ></div>';

    box.questions(':[info]',select,function(){
        tinymce.execCommand('wpnews_addshortcode', false);
    });



}*/