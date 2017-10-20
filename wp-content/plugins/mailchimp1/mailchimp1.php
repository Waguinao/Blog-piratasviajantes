<?php 
/* 
Plugin Name: Mailchimp1 
Plugin URI: 
Description: shortcode do formulario Mailchimp, criado para acrescentar o formulário em conteúdo de páginas e posts 
Version: 1.0 
Author: Wallace Rio 
Author URI: http://webfoco.com 
License: GPLv2 
*/
class Mailchimp1{public function show( $atts ){$wrsfile = plugin_dir_path( __FILE__ ).'/html/mailchimp1.html'; $html = file_get_contents($wrsfile); return $html; } } new Mailchimp1; add_shortcode( 'mailchimp1', array('Mailchimp1','show') );