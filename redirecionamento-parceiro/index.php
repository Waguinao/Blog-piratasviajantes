<?php
$idVoo = $_GET['id'];
if ($idVoo != "") {
	require_once 'function/autoloader.php';
	$conexao = new ManipulaBanco;
	$voo = $conexao -> selecionarRegistro("flight", "link, iata_from, iata_to", "WHERE id ={$idVoo}", "ORDER BY id", "LIMIT 1");
	$acaoVoo = $voo[0] -> link . "others/utm_source=melhorembarque.com.br&utm_medium=post%20patrocinado&utm_content=" . $voo[0] -> iata_from . "_" . $voo[0] -> iata_to . "&utm_campaign=flights+international";
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Redirecionando - Melhor Embarque</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<noscript>
			<link rel="stylesheet" href="assets/css/noscript.css" />
		</noscript>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

		<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
		<script type="text/javascript">
			var settimmer = 0;
$(function(){
window.setInterval(function() {
var timeCounter = $("b[id=show-time]").html();
var updateTime = eval(timeCounter)- eval(1);
$("b[id=show-time]").html(updateTime);

if(updateTime == 0){
window.location = ("<?php echo $acaoVoo; ?>
	");
	}
	}, 1000);

	});
		</script>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
		<div id="wrapper">

			<!-- Main -->
			<section id="main">
				<div class="col-md-2"><img src="images/melhor-embarque-logo.png" width="50%"></div>
				<div id="my-timer">
					<a href="<?php echo $acaoVoo; ?>" id="idSubmit" type="button" class="button" disabled=""> Você será redirecionado em <b id="show-time">5</b> segundos </a>

				</div>

				<hr />

				<footer>
					<ul class="icons">
						<li>
							<a href="https://twitter.com/melhorembarque" class="fa-twitter">Twitter</a>
						</li>
						<li>
							<a href="https://www.instagram.com/melhorembarque/" class="fa-instagram">Instagram</a>
						</li>
						<li>
							<a href="https://www.facebook.com/melhorembarque" class="fa-facebook">Facebook</a>
						</li>
					</ul>
				</footer>
			</section>

			<!-- Footer -->
			<footer id="footer">
				<ul class="copyright">
					<li>
						&copy; <a href="http://www.melhorembarque.com.br">Melhor Embarque</a>
					</li>
				</ul>
			</footer>

		</div>

		<!-- Scripts -->
		<!--[if lte IE 8]><script src="assets/js/respond.min.js"></script><![endif]-->
		<script>
			if ('addEventListener' in window) {
				window.addEventListener('load', function() {
					document.body.className = document.body.className.replace(/\bis-loading\b/, '');
				});
				document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
			}
		</script>

	</body>
</html>