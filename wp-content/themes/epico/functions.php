<?php

/*
//Função add para funcionamento do FeedBurnner (Solicitação por email Tarik)
// show post thumbnails in feeds
function diw_post_thumbnail_feeds($content) {
    global $post;
    if(has_post_thumbnail($post->ID)) {
        $content = '<div>' . get_the_post_thumbnail($post->ID) . '</div>' . $content;
    }
    return $content;
}
add_filter('the_excerpt_rss', 'diw_post_thumbnail_feeds');
add_filter('the_content_feed', 'diw_post_thumbnail_feeds');

*/
/**
 *
 * "A estrada para o sucesso esta sempre em construcao."
 *
 * Funcoes para o tema Epico
 *
 * @package    Epico
 * @subpackage Functions
 * @version    1.6.4
 * @since      1.0.0
 * @author     Uberfacil <contato@uberfacil.com>
 * @copyright  Copyright (c) 2014, Uberfacil
 * @link       http://www.uberfacil.com/temas/epico
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 */

/* Obtem o diretorio do tema e certifica de que possua a barra final. */
$epico_dir = trailingslashit( get_template_directory() );

/* Carrega o framework principal do tema. */
require_once( $epico_dir . 'core/hybrid.php' );
new Hybrid();


/* Carrega o customizador avancado */
require_once( $epico_dir . 'lib/kirki/kirki.php'				 );

/* Altera a URL utilizada pelo customizador buscar seus arquivos */
function epico_configs_customizador( $config ) {
    $config['url_path'] = get_template_directory_uri() . '/lib/kirki/';
    return $config;
}
add_filter( 'kirki/config', 'epico_configs_customizador' );


/* Carrega arquivos adicionais. */
if ( ! class_exists( 'Mobile_Detect' ) ) {
	require_once( $epico_dir . 'lib/mobile-detect/mobile-detect.php' );
}
require_once( $epico_dir . 'inc/metabox/featured-metabox.php'		 );
require_once( $epico_dir . 'inc/pointers.php'						 );
require_once( $epico_dir . 'inc/epico-theme-updater.php' 			 );
new Epico_Theme_Updater;


/*-------------------------------------------------------------
	FRAMEWORK PRINCIPAL
--------------------------------------------------------------*/

/* Configura o tema no hook 'after_setup_theme'. */
add_action( 'after_setup_theme', 'epico_theme_setup', 5 );

/**
 * Funcao de config do tema. Esta funcao adiciona suporte a
 * recursos do tema e define o as acoes e filtros do tema padrao
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function epico_theme_setup() {

	/* Argumentos da atualizacao */
	$updater_args = array(
		'repo_slug'   => 'epico',
		'dashboard' => true,
		'username'  => true,
		'key'       => '',
		'repo_uri'  => 'http://minha.uberfacil.com/epico/',
	);

	/* add support for updater */
	add_theme_support( 'auto-hosted-theme-updater', $updater_args );

	/* Carrega os arquivos com funcoes. */
	require_once( trailingslashit( get_template_directory() ) . 'inc/epico.php'	 );

	/* Registra os menus */
	add_theme_support(
		'hybrid-core-menus',
		array( 'primary', 'secondary' )
	);

	/* Habilita suporte a imagens destacadas nos artigos. */
	add_theme_support( 'post-thumbnails' );

	/* Habilita a hierarquia de templates personalizada */
	add_theme_support( 'hybrid-core-template-hierarchy' );

	/* Habilita o suporte a barras laterais do framework */
	add_theme_support( 'hybrid-core-sidebars', array( 'primary', 'promo', 'after-primary', 'before-content', 'after-content', 'subsidiary', 'footer', 'top' ) );

	/* Permite folhas de estilo individuais para as paginas. */
	add_theme_support( 'post-stylesheets' );

	/* Suporte ao script de imagens. */
	add_theme_support( 'get-the-image' );

	/* Adiciona links de feed automaticamente ao <head> da pagina. */
	add_theme_support( 'automatic-feed-links' );

	/* Breadcrumbs. */
	add_theme_support( 'breadcrumb-trail' );

	/* Paginacao. */
	add_theme_support( 'loop-pagination' );

	/* Implementacao do shortcode avancado de galeria. */
	add_theme_support( 'cleaner-gallery' );

	/* Formatos de artigo. */
	add_theme_support(
		'post-formats',
		array( 'aside', 'quote', 'status', )
	);
	/* Legendas aperfeicoadas. */
	add_theme_support( 'cleaner-caption' );

	/* Suporte para imagens de fundo personalizadas*/
	add_theme_support( 'custom-background' );

	/* Largura maxima do conteudo para imagens e outros elementos embutidos. */
	hybrid_set_content_width( 1075 );
	
	

}
		function anuncio(){
			return '	
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- 300x250 -->
		<ins class="adsbygoogle"
			 style="display:inline-block;width:300px;height:250px"
			 data-ad-client="ca-pub-7694831168422394"
			 data-ad-slot="4170561772"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>';
		}
		add_shortcode('anuncio','anuncio');
		
		
		function cropText($texto, $limite){
			if (strlen($texto) <= $limite) return $texto;
			return array_shift(explode('||', wordwrap($texto, $limite, '||'))) . "";
		}
	



// Custom by Wallace Rio -----------------------------------------

	function widgets_init() {

		register_sidebar( array(
			'name'          => 'Após Promocional',
			'id'            => 'after-promocional',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => 'Menu Slider in Mobile',
			'id'            => 'menu-slider-mobile',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => 'Menu Slider in Desktop',
			'id'            => 'menu-slider-desktop',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="title">',
			'after_title'   => '</h2>',
		) );


	}
	add_action( 'widgets_init', 'widgets_init' );


	function remove_comment_fields($fields) {   
	    unset($fields['url']);
	    return $fields;
	}
	add_filter('comment_form_default_fields','remove_comment_fields');


	function wpb_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
	}

	add_filter( 'comment_form_fields', 'wpb_move_comment_field_to_bottom' );


	function print_menu_shortcode($atts, $content = null) {
	    extract(shortcode_atts(array( 'name' => null, ), $atts));
	    return wp_nav_menu( array( 'menu' => $name, 'echo' => false ) );
	}
	add_shortcode('menu', 'print_menu_shortcode');

	

if ( ! function_exists( 'et_get_the_author_posts_link' ) ) :

function et_get_the_author_posts_link(){

	global $authordata, $themename;



	$link = sprintf(

		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',

		esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),

		esc_attr( sprintf( __( 'Posts by %s', $themename ), get_the_author() ) ),

		get_the_author()

	);

	return apply_filters( 'the_author_posts_link', $link );

}

endif;



if ( ! function_exists( 'et_get_comments_popup_link' ) ) :

function et_get_comments_popup_link( $zero = false, $one = false, $more = false ){

	global $themename;



	$id = get_the_ID();

	$number = get_comments_number( $id );



	if ( 0 == $number && !comments_open() && !pings_open() ) return;



	if ( $number > 1 )

		$output = str_replace('%', number_format_i18n($number), ( false === $more ) ? __('% Comentário', $themename) : $more);

	elseif ( $number == 0 )

		$output = ( false === $zero ) ? __('Sem comentários',$themename) : $zero;

	else // must be one

		$output = ( false === $one ) ? __('1 Comentário', $themename) : $one;



	return '<span class="comments-number">' . '<a href="' . esc_url( get_permalink() . '#respond' ) . '">' . apply_filters('comments_number', $output, $number) . '' .do_shortcode('[addtoany]'). '</a></span>';

}

endif;



if ( ! function_exists( 'et_postinfo_meta' ) ) :

function et_postinfo_meta( $postinfo, $date_format, $comment_zero, $comment_one, $comment_more ){

	global $themename;



	$postinfo_meta = '';



	if ( in_array( 'author', $postinfo ) )

		$postinfo_meta .= ' ' . esc_html__('by',$themename) . ' ' . et_get_the_author_posts_link() . ' | ';



	if ( in_array( 'date', $postinfo ) )

		$postinfo_meta .= get_the_time( $date_format ) . ' | ';



	if ( in_array( 'categories', $postinfo ) )

		$postinfo_meta .= get_the_category_list(', ')  . ' | ';



	if ( in_array( 'comments', $postinfo ) )

		$postinfo_meta .= et_get_comments_popup_link( $comment_zero, $comment_one, $comment_more );



	echo $postinfo_meta;

}

endif;



function et_add_post_meta_box() {

	add_meta_box( 'et_settings_meta_box', __( 'ET Settings', 'Divi' ), 'et_single_settings_meta_box', 'page', 'side', 'high' );

	add_meta_box( 'et_settings_meta_box', __( 'ET Settings', 'Divi' ), 'et_single_settings_meta_box', 'post', 'side', 'high' );

	add_meta_box( 'et_settings_meta_box', __( 'ET Settings', 'Divi' ), 'et_single_settings_meta_box', 'product', 'side', 'high' );

	add_meta_box( 'et_settings_meta_box', __( 'ET Settings', 'Divi' ), 'et_single_settings_meta_box', 'project', 'side', 'high' );

}

add_action( 'add_meta_boxes', 'et_add_post_meta_box' );



function et_pb_register_posttypes() {

	$labels = array(

		'name'               => _x( 'Projects', 'project type general name', 'Divi' ),

		'singular_name'      => _x( 'Project', 'project type singular name', 'Divi' ),

		'add_new'            => _x( 'Add New', 'project item', 'Divi' ),

		'add_new_item'       => __( 'Add New Project', 'Divi' ),

		'edit_item'          => __( 'Edit Project', 'Divi' ),

		'new_item'           => __( 'New Project', 'Divi' ),

		'all_items'          => __( 'All Projects', 'Divi' ),

		'view_item'          => __( 'View Project', 'Divi' ),

		'search_items'       => __( 'Search Projects', 'Divi' ),

		'not_found'          => __( 'Nothing found', 'Divi' ),

		'not_found_in_trash' => __( 'Nothing found in Trash', 'Divi' ),

		'parent_item_colon'  => '',

	);



	$args = array(

		'labels'             => $labels,

		'public'             => true,

		'publicly_queryable' => true,

		'show_ui'            => true,

		'can_export'         => true,

		'show_in_nav_menus'  => true,

		'query_var'          => true,

		'has_archive'        => true,

		'rewrite'            => apply_filters( 'et_project_posttype_rewrite_args', array(

			'feeds'      => true,

			'slug'       => 'project',

			'with_front' => false,

		) ),

		'capability_type'    => 'post',

		'hierarchical'       => false,

		'menu_position'      => null,

		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),

	);



	register_post_type( 'project', apply_filters( 'et_project_posttype_args', $args ) );



	$labels = array(

		'name'              => _x( 'Categories', 'Project category name', 'Divi' ),

		'singular_name'     => _x( 'Category', 'Project category singular name', 'Divi' ),

		'search_items'      => __( 'Search Categories', 'Divi' ),

		'all_items'         => __( 'All Categories', 'Divi' ),

		'parent_item'       => __( 'Parent Category', 'Divi' ),

		'parent_item_colon' => __( 'Parent Category:', 'Divi' ),

		'edit_item'         => __( 'Edit Category', 'Divi' ),

		'update_item'       => __( 'Update Category', 'Divi' ),

		'add_new_item'      => __( 'Add New Category', 'Divi' ),

		'new_item_name'     => __( 'New Category Name', 'Divi' ),

		'menu_name'         => __( 'Categories', 'Divi' ),

	);



	register_taxonomy( 'project_category', array( 'project' ), array(

		'hierarchical'      => true,

		'labels'            => $labels,

		'show_ui'           => true,

		'show_admin_column' => true,

		'query_var'         => true,

	) );



	$labels = array(

		'name'              => _x( 'Tags', 'Project Tag name', 'Divi' ),

		'singular_name'     => _x( 'Tag', 'Project tag singular name', 'Divi' ),

		'search_items'      => __( 'Search Tags', 'Divi' ),

		'all_items'         => __( 'All Tags', 'Divi' ),

		'parent_item'       => __( 'Parent Tag', 'Divi' ),

		'parent_item_colon' => __( 'Parent Tag:', 'Divi' ),

		'edit_item'         => __( 'Edit Tag', 'Divi' ),

		'update_item'       => __( 'Update Tag', 'Divi' ),

		'add_new_item'      => __( 'Add New Tag', 'Divi' ),

		'new_item_name'     => __( 'New Tag Name', 'Divi' ),

		'menu_name'         => __( 'Tags', 'Divi' ),

	);



	register_taxonomy( 'project_tag', array( 'project' ), array(

		'hierarchical'      => false,

		'labels'            => $labels,

		'show_ui'           => true,

		'show_admin_column' => true,

		'query_var'         => true,

	) );





	$labels = array(

		'name'               => _x( 'Layouts', 'Layout type general name', 'Divi' ),

		'singular_name'      => _x( 'Layout', 'Layout type singular name', 'Divi' ),

		'add_new'            => _x( 'Add New', 'Layout item', 'Divi' ),

		'add_new_item'       => __( 'Add New Layout', 'Divi' ),

		'edit_item'          => __( 'Edit Layout', 'Divi' ),

		'new_item'           => __( 'New Layout', 'Divi' ),

		'all_items'          => __( 'All Layouts', 'Divi' ),

		'view_item'          => __( 'View Layout', 'Divi' ),

		'search_items'       => __( 'Search Layouts', 'Divi' ),

		'not_found'          => __( 'Nothing found', 'Divi' ),

		'not_found_in_trash' => __( 'Nothing found in Trash', 'Divi' ),

		'parent_item_colon'  => '',

	);



	$args = array(

		'labels'             => $labels,

		'public'             => false,

		'can_export'         => true,

		'query_var'          => false,

		'has_archive'        => false,

		'capability_type'    => 'post',

		'hierarchical'       => false,

		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),

	);



	register_post_type( 'et_pb_layout', apply_filters( 'et_pb_layout_args', $args ) );

}

add_action( 'init', 'et_pb_register_posttypes', 0 );



if ( ! function_exists( 'et_pb_portfolio_meta_box' ) ) :

function et_pb_portfolio_meta_box() { ?>

	<div class="et_project_meta">

		<strong class="et_project_meta_title"><?php echo esc_html__( 'Skills', 'Divi' ); ?></strong>

		<p><?php echo get_the_term_list( get_the_ID(), 'project_tag', '', ', ' ); ?></p>



		<strong class="et_project_meta_title"><?php echo esc_html__( 'Posted on', 'Divi' ); ?></strong>

		<p><?php echo get_the_date(); ?></p>

	</div>

<?php }

endif;



if ( ! function_exists( 'et_single_settings_meta_box' ) ) :

function et_single_settings_meta_box( $post ) {

	$post_id = get_the_ID();



	wp_nonce_field( basename( __FILE__ ), 'et_settings_nonce' );



	$page_layout = get_post_meta( $post_id, '_et_pb_page_layout', true );



	$page_layouts = array(

		'et_right_sidebar'   => __( 'Right Sidebar', 'Divi' ),

   		'et_left_sidebar'    => __( 'Left Sidebar', 'Divi' ),

   		'et_full_width_page' => __( 'Full Width', 'Divi' ),

	);



	$layouts        = array(

		'light' => __( 'Light', 'Divi' ),

		'dark'  => __( 'Dark', 'Divi' ),

	);

	$post_bg_color  = ( $bg_color = get_post_meta( $post_id, '_et_post_bg_color', true ) ) && '' !== $bg_color

		? $bg_color

		: '#ffffff';

	$post_use_bg_color = get_post_meta( $post_id, '_et_post_use_bg_color', true )

		? true

		: false;

	$post_bg_layout = ( $layout = get_post_meta( $post_id, '_et_post_bg_layout', true ) ) && '' !== $layout

		? $layout

		: 'light'; ?>



	<p class="et_pb_page_settings et_pb_page_layout_settings">

		<label for="et_pb_page_layout" style="display: block; font-weight: bold; margin-bottom: 5px;"><?php esc_html_e( 'Page Layout', 'Divi' ); ?>: </label>



		<select id="et_pb_page_layout" name="et_pb_page_layout">

		<?php

		foreach ( $page_layouts as $layout_value => $layout_name ) {

			printf( '<option value="%2$s"%3$s>%1$s</option>',

				esc_html( $layout_name ),

				esc_attr( $layout_value ),

				selected( $layout_value, $page_layout )

			);

		} ?>

		</select>

	</p>

<?php if ( in_array( $post->post_type, array( 'page', 'project' ) ) ) : ?>

	<p class="et_pb_page_settings" style="display: none;">

		<input type="hidden" id="et_pb_use_builder" name="et_pb_use_builder" value="<?php echo esc_attr( get_post_meta( $post_id, '_et_pb_use_builder', true ) ); ?>" />

		<textarea id="et_pb_old_content" name="et_pb_old_content"><?php echo esc_attr( get_post_meta( $post_id, '_et_pb_old_content', true ) ); ?></textarea>

	</p>

<?php endif; ?>



<?php if ( 'post' === $post->post_type ) : ?>

	<p class="et_divi_quote_settings et_divi_audio_settings et_divi_link_settings et_divi_format_setting">

		<label for="et_post_use_bg_color" style="display: block; font-weight: bold; margin-bottom: 5px;">

			<input name="et_post_use_bg_color" type="checkbox" id="et_post_use_bg_color" <?php checked( $post_use_bg_color ); ?> />

			<?php esc_html_e( 'Use Background Color', 'Divi' ); ?></label>

	</p>



	<p class="et_post_bg_color_setting et_divi_format_setting">

		<label for="et_post_bg_color" style="display: block; font-weight: bold; margin-bottom: 5px;"><?php esc_html_e( 'Background Color', 'Divi' ); ?>: </label>

		<input id="et_post_bg_color" name="et_post_bg_color" class="color-picker-hex" type="text" maxlength="7" placeholder="<?php esc_attr_e( 'Hex Value', 'Divi' ); ?>" value="<?php echo esc_attr( $post_bg_color ); ?>" data-default-color="#ffffff" />

	</p>



	<p class="et_divi_quote_settings et_divi_audio_settings et_divi_link_settings et_divi_format_setting">

		<label for="et_post_bg_layout" style="font-weight: bold; margin-bottom: 5px;"><?php esc_html_e( 'Text Color', 'Divi' ); ?>: </label>

		<select id="et_post_bg_layout" name="et_post_bg_layout">

	<?php

		foreach ( $layouts as $layout_name => $layout_title )

			printf( '<option value="%s"%s>%s</option>',

				esc_attr( $layout_name ),

				selected( $layout_name, $post_bg_layout, false ),

				esc_html( $layout_title )

			);

	?>

		</select>

	</p>

<?php endif;



}

endif;



function et_metabox_settings_save_details( $post_id, $post ){

	global $pagenow;



	if ( 'post.php' != $pagenow ) return $post_id;



	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )

		return $post_id;



	$post_type = get_post_type_object( $post->post_type );

	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) )

		return $post_id;



	if ( ! isset( $_POST['et_settings_nonce'] ) || ! wp_verify_nonce( $_POST['et_settings_nonce'], basename( __FILE__ ) ) )

		return $post_id;



	if ( isset( $_POST['et_pb_page_layout'] ) ) {

		update_post_meta( $post_id, '_et_pb_page_layout', sanitize_text_field( $_POST['et_pb_page_layout'] ) );

	} else {

		delete_post_meta( $post_id, '_et_pb_page_layout' );

	}



	if ( isset( $_POST['et_pb_use_builder'] ) ) {

		update_post_meta( $post_id, '_et_pb_use_builder', sanitize_text_field( $_POST['et_pb_use_builder'] ) );

	} else {

		delete_post_meta( $post_id, '_et_pb_use_builder' );

	}



	if ( isset( $_POST['et_pb_old_content'] ) ) {

		update_post_meta( $post_id, '_et_pb_old_content', $_POST['et_pb_old_content'] );

	} else {

		delete_post_meta( $post_id, '_et_pb_old_content' );

	}



	if ( isset( $_POST['et_post_use_bg_color'] ) )

		update_post_meta( $post_id, '_et_post_use_bg_color', true );

	else

		delete_post_meta( $post_id, '_et_post_use_bg_color' );



	if ( isset( $_POST['et_post_bg_color'] ) )

		update_post_meta( $post_id, '_et_post_bg_color', sanitize_text_field( $_POST['et_post_bg_color'] ) );

	else

		delete_post_meta( $post_id, '_et_post_bg_color' );



	if ( isset( $_POST['et_post_bg_layout'] ) )

		update_post_meta( $post_id, '_et_post_bg_layout', sanitize_text_field( $_POST['et_post_bg_layout'] ) );

	else

		delete_post_meta( $post_id, '_et_post_bg_layout' );

}

add_action( 'save_post', 'et_metabox_settings_save_details', 10, 2 );

