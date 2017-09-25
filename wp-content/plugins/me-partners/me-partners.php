<?php

/**
 * Plugin Name: ME Partners
 * Plugin URI: http://www.melhorembarque.com.br/
 * Description: This plugin adds a custom post type called Partner.
 * Version: 1.0.0
 * Author: Melhor Embarque
 * Author URI: http://www.melhorembarque.com.br/
 */

define("SERVER_KEY", "Me#K&y@885AnG!");
define("ME_BACKEND_URL", "http://127.0.0.1:8000/flight");
define("ME_PARTNER_LINK", "field_57979156d885c");
define("ME_PARTNER_IMAGE", "field_5798fc6a5d225");

function me_create_partner_post_type() {

    register_post_type('me_partner', array(
        'labels' => array(
            'name' => __('Parceiros'),
            'singular_name' => __('Parceiro'),
            'add_new' => __('Adicionar novo Parceiro'),
            'add_new_item' => __('Adicionar novo Parceiro'),
            'search_items' => __('Pesquisar parceiros'),
            'not_found' => __('Não existem informações para exibição')
        ),
        'supports' => array( 'title' ),
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'has_archive' => true,
        'rewrite' => array('slug' => 'me_partner')
    ));
}

add_action('init', 'me_create_partner_post_type');

function me_partner_columns($columns) {
    unset($columns['date']);
    $columns['link'] = 'Link';
    return $columns;
}

add_filter('manage_edit-me_partner_columns', 'me_partner_columns');

function me_partner_column_content($name) {

    global $post;

    switch ($name) {

        case 'link': {
            $link = get_post_meta($post->ID, 'me_partner_link', true);
            echo $link;
            break;
        }
        
    }
    
}

add_action('manage_posts_custom_column', 'me_partner_column_content');

function title_partner_text( $input ) {

    global $post_type;

    if( is_admin() && $post_type == 'me_partner' ){
        return 'Nome do Parceiro';
    }

    return $input;
    
}

add_filter( 'enter_title_here', 'title_partner_text' );

function custom_partner_template( $page_template ){
    
    if ( is_page( 'Redirecionamento Parceiro' ) ) {
        $page_template = dirname( __FILE__ ) . '/partner-redirect.php';
    }
    
    return $page_template;
    
}

add_filter( 'page_template', 'custom_partner_template' );

function add_my_var($public_query_vars) {
    $public_query_vars[] = 'id';
    return $public_query_vars;
}

add_filter('query_vars', 'add_my_var');

function getFlight( $id ){
    
    $key = md5( $id . SERVER_KEY );
    
    $flightRequest = wp_remote_get(ME_BACKEND_URL . "?id=" . $id . "&key=" . $key);
    
    $requests = 1;
    $maxRequests = 5;
    
    while( is_wp_error($flightRequest) ){
        
        if( $maxRequests >= $requests ){
            break;
        }
        
        $flightRequest = wp_remote_get(ME_BACKEND_URL . "/123");
        
        $requests++;
        
    }
    
    if( !is_wp_error($flightRequest) ) {
        $body = json_decode($flightRequest['body']);
        return $body;
    } else {
        return false;
    }
    
}

function getRandomPartner(){
    
    $partner = -1;
    
    $args = array(
        'post_type' => 'me_partner',
        'orderby' => 'rand',
        'posts_per_page' => 1
    );
    
    $partnerQuery = new WP_Query($args);
    
    if( count( $partnerQuery->posts[0] ) > 0 ){
        $partner = $partnerQuery->posts[0];
    }
    
    return $partner;
    
}