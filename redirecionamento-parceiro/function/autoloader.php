<?php
function __autoload($classe) {
	include_once "class/{$classe}.class.php";
}
?>