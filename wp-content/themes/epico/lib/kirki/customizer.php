<?php
/**
 * Opcoes do customizador avancado
 * @package Kirki
 */

// Finaliza se o customizador nao estiver instalado
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

function epico_customizer_config() {

	$args = array(
		'logo_image'               => get_template_directory_uri() . '/img/logo.png',
		'description'              => __( 'O tema Épico, da Uberfácil, é a solução ideal para você criar o seu blog profissional! Neste painel você encontra todas as opções para personalizar o seu Épico como achar melhor!', 'kirki' ),
		'color_accent'             => '#D8D8D8',
		'color_back'               => '#3C4B51',
		'color_accent_text'        => '#D8D8D8',
		'border_color'             => '4F5C62',
		'buttons_color'            => '#385155',
		'color_font'               => '#FFFFFF',
		'controls_color'           => '#FFFFFF',
		'arrows_color'             => '#778084',
		'section_background_color' => '#F7F5EE',
	);

	return $args;

}
add_filter( 'kirki/config', 'epico_customizer_config' );


/* Include sections and controls for the customizer */

include_once( $epico_dir . '/lib/kirki/customizer/branding.php' 	);
include_once( $epico_dir . '/lib/kirki/customizer/layout.php' 		);
include_once( $epico_dir . '/lib/kirki/customizer/social.php' 		);
include_once( $epico_dir . '/lib/kirki/customizer/footer.php' 		);
include_once( $epico_dir . '/lib/kirki/customizer/advanced.php' 	);