<?php
/**
 * Template de cabecalho para o tema
 *
 * Apresenta a secao <head> ate a tag <header>
 *
 * @package Epico
 * @subpackage Header
 * @since 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?> class="no-js">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">	
	<meta name="viewport" content="initial-scale=1,minimum-scale=1, maximum-scale=1,user-scalable=no"> 	
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
	<meta name="google-site-verification" content="HmnvMTQBYjM5EVzbsacrpN7Ib3aEUT-mQHSBGk3YYWU" />
	<meta name="verification" content="2d1161c9da477b5147c9b99e2a724da0" />

	<link rel="dns-prefetch" href="//themes.googleusercontent.com">
	<link rel="dns-prefetch" href="//fonts.googleapis.com">
	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<link rel="stylesheet" type="text/css" href="<?= get_template_directory_uri(); ?>/css/promo-links.css">

	<link rel="stylesheet" type="text/css" href="<?= get_template_directory_uri(); ?>/vendor/bootstrap/dist/css/bootstrap.css">

	<script type="text/javascript" src="<?= get_template_directory_uri(); ?>/vendor/jquery/dist/jquery.min.js"></script>

	<?php wp_head(); // wp_head ?>



	<?php include WP_CONTENT_DIR."/custom/meta.php"; ?>

</head>



<body <?php hybrid_attr( 'body' ); ?>>

	<!-- Código RD Station -->
	<script type="text/javascript" async src="https://d335luupugsy2.cloudfront.net/js/loader-scripts/fe5a9a66-b5cd-4319-8236-22c3eadd7227-loader.js"></script>

	<?php uberfacil_after_body(); // Hook personalizado - utilizado por padrao para o GTM ?>

	 <?php 
	 	// if ( is_home() ||  is_front_page() ) : 
	 	if ( is_single() ) : 
	 ?>              
				<div id="page" class="posts">
			<?php else: ?>
				<div id="page" class="home">
		<?php endif; ?>

	

	<?php if ( ! is_404() ) {  // Checar se NAO e pagina 404 ?>

		<?php hybrid_get_sidebar( 'top' ); // Mostra a sidebar do topo. ?>

	<?php } ?>


	

					
		<header <?php hybrid_attr( 'header' ); ?>>

			<div class="wrap">

				<div id="branding">

				<?php  // Opcoes do customizador para a area de branding


				$siteName = get_theme_mod( 'epico_site_name', get_bloginfo( 'name', 'epico' ) );

				$logoID = get_theme_mod( 'epico_logo_upload' );

				$logoWidth = get_theme_mod( 'epico_logo_width', 280 ); ?>

				<?php if ( $logoID ) { // Utiliza o logotipo se estiver configurado. Caso contrario, usa o titulo do site. ?>

					<p id="site-title" itemscope itemtype="http://schema.org/Organization">

						<a itemprop="url" href="<?php echo esc_url( home_url() ); ?>" rel="home" title="Homepage">

							<meta itemprop="name" content="<?php echo esc_attr( $siteName ); ?>">

							<img style="width: <?php echo esc_attr( $logoWidth ); ?>px" id="logo" itemprop="image logo" src="<?php echo esc_url( $logoID ); ?>" alt="<?php echo esc_attr( $siteName ); ?>" />

						</a>

					</p>

				<?php } else { ?>

					<p id="site-title" itemscope itemtype="http://schema.org/Organization">

						<a itemprop="url" href="<?php echo esc_url( home_url() ); ?>" rel="home" title="Homepage">

							<span itemprop="name"><?php echo esc_attr( $siteName ); ?></span>

						</a>

					</p>

				<?php } ?>

					

				</div><!-- #branding -->

				<div class="nav" id="nav">

					<?php hybrid_get_menu( 'primary' ); // Carrega o template em menu/primary.php. ?>

				<!--<div id="search-wrap">

					<a id="search-toggle" href="#" title="<?php _e( 'Search', 'epico' ); ?>"><span class="search-text"><?php _e( 'Search', 'epico' ); ?></span></a>

					<?php get_search_form(); ?>

				</div>-->

				</div>

			</div><!-- .wrap -->

		</header><!-- #header -->

		<div class="menuSlider" >
						<div class="menuSlider-action" tabindex="-1"></div>
						<div class="menuSlider-wrapper">
							<div class="menuSlider-content">
								<?php if(wp_is_mobile()): ?>
									<?php if ( is_active_sidebar( 'menu-slider-mobile' ) ) : ?>									
											<?php dynamic_sidebar( 'menu-slider-mobile' ); ?>									
									<?php endif; ?>
								<?php else: ?>

									<?php if ( is_active_sidebar( 'menu-slider-desktop' ) ) : ?>									
											<?php dynamic_sidebar( 'menu-slider-desktop' ); ?>									
									<?php endif; ?>

								<?php endif; ?>

								<?php		 						
									// wp_nav_menu( array( 'theme_location' => 'primary' ) );								
								?>		
							</div>
						</div>
					</div>
					
			<?php if ( ! is_404() ) :  // Checar se NAO esta na pagina 404 ?>

				<?php hybrid_get_sidebar( 'promo' ); // Mostra sidebar-promo. ?>

			<?php endif; // Fim da opcao para checar pagina 404. ?>