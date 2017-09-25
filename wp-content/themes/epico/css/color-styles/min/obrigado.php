<?php

$xml = simplexml_load_file('config/config.xml');

if($xml->config->status != "Finish"){

    echo "<strong style=\"color:red\">Warning:</strong> <strong>Configuration file is missing or blank, please make sure all the configs are done!</strong>";

}else{





?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="<?= $xml->default->description; ?>">
        <meta name="keywords" content="<?= $xml->default->keywords; ?>">        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $xml->default->title; ?></title>
        <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />            
        <script src="js/jquery.js" ></script>

        

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

       
        <![endif]-->

        



    </head>
    <body>
    
        <div class="header ">
        <div class="content">
        <br />
        <div class="row">
            <div class="col-lg-3 col-md-3 esque">
                <a href="."><img src="images/<?= $xml->header->firstimage; ?>" alt="<?= $xml->default->alt; ?>" title="<?= $xml->default->alt; ?>" /></a>
            </div>
            <div class="col-lg-5 col-md-5 " style="text-align:center">
                 
            </div>
            <div class="col-lg-4 col-md-4 " style="text-align:center">
            <!-- <div class="chamada">Ligue agora</div> -->
            <img src="images/<?= $xml->header->secondimage; ?>" alt="<?= $xml->default->alt; ?>" title="<?= $xml->default->alt; ?>" style="margin-top: 18px;" />
            </div>
        </div>
        <br>
        </div>
        </div>
    <hr style="box-shadow: 0px 1px 7px rgb(153, 153, 153);margin: 0px 0px 14px;" /> 
    
    
    <div class="content">
        <div class="row " >
            <div class="col-lg-8 col-md-6">
                <div class="headerTitle" style="font-size: 29px;margin: 0px 0px 0px;font-weight: normal;text-transform: uppercase;display: table;">
                    <h1 id="tabTitle">
                     
                    </h1>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" style="text-align:center">
                <span id="telefone" style="font-size:35px; margin:0 0 0 0; font-weight:bold;white-space:nowrap;padding-top: 5px;display: table;margin: auto;" >
                    
                    <span>(51) 9516-5652</span>
                    
                </span>
            </div>
        </div>
            
    </div>
   
    <br />






<!-- Google Code for Lead Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 873483726;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "TNpyCOrl_WkQzpvBoAM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/873483726/?label=TNpyCOrl_WkQzpvBoAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


    

<div class="content">


    <h2>Obrigado</h2>
    <p>Sua mensagem foi enviada com sucesso, em breve entraremos em contato com você.</p>

 </div>    


        
<br><br><br><br><br><br><br><br><br><br><br><br>



    

<div class="footer">
    <div class='content'>
        <div class="col-lg-1 col-md-1  col-sm-11 " style='width:38px'>
         <!-- <img src="images/address.png" alt="icon address"> -->
        </div>
        <div class="col-lg-10 col-md-10  col-sm-10">
        <h2><span>(51) 9516-5652</span></h2>
        <p><?= $xml->content->email; ?></p>
        </div>
        <div class="col-lg-1 col-md-1  col-sm-1"><img src="images/logo.png" width="120" alt="logo" ></div>
    </div>
</div>
 


   
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/bootstrap.min.js" defer></script>


        <link rel="stylesheet" href="css/css.css">
        <link rel="stylesheet" href="css/css_mod.css">
        <link rel="stylesheet" href="css/default.css">
        
        <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,700' rel='stylesheet' type='text/css'>
        
       


        

    </body>
</html>
<?php

}

?>



