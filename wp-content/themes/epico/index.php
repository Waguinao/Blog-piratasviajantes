<?php
/**
 * Template principal do site
 *
 * Inclui codigo e tags para todo o conteudo
 *
 * @package Epico
 * @subpackage Index
 * @since 1.0.0
 */
?>
<?php get_header(); // Carrega o template header.php. ?>

	<?php if ( is_active_sidebar( 'after-promocional' ) ) : ?>
			<!-- <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary"> -->
				<?php //dynamic_sidebar( 'after-promocional' ); ?>
			<!-- </div> -->
		<?php endif; ?>

		<div class="botaoPostTop">
		<?php echo do_shortcode('[uwl_about_me id="4"]'); ?>
		</div>

	<div id="main-container">
	
	<?php 
		 if ( is_single() ) :
		 // $thumb_id = get_post_thumbnail_id();
		// $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
		// $thumb_url = $thumb_url_array[0];

		$thumb_url = wp_get_attachment_url( get_post_thumbnail_id() );

		if($thumb_url == ''){
			$content = get_the_content();
			preg_match_all('/<img[^>]+>/i',$content, $result); 
			$result = array_filter($result);
			preg_match_all('/src=[\'"]?([^\'" >]+)[\'" >]/',$content, $result2); 
			// print_r($result2);
			$thumb_url = $result2[1][0];
		}

		 echo '<div class="topo" style="background:url('.$thumb_url.')"></div>';
		endif;
	?>
	
	<?php //hybrid_get_menu( 'breadcrumbs' ); // Carrega o template menu/breadcrumbs.php. ?>

		<div class="wrap">

	<?php

		$siteLayout = get_theme_mod( 'epico_sidebar_layout', 1 ); // Opcoes do customizador

		$contentClass = ''; ?>

	<?php if ( $siteLayout == 0 ) {

		$contentClass = 'content-right';

	} else if ( $siteLayout == 1 ) {

		$contentClass = 'content-left';

	} ?>

		<main id="content" class="content <?php echo esc_html( $contentClass ); ?>" role="main" itemscope="itemscope" itemtype="http://schema.org/Blog">

				<?php if ( is_active_sidebar( 'before-content' ) ) : // Se a area de widgets possui widgets. ?>

						<aside id="sidebar-before-content">

							<?php dynamic_sidebar( 'before-content' ); // Apresenta a area de widgets auxiliar. ?>

						</aside><!-- #sidebar-promo .aside -->

				<?php endif; // Finaliza a checagem por widgets. ?>

				<?php if ( ! is_front_page() && ! is_singular() && ! is_404() ) : // Se NAO estiver na pagina inicial, em um post unico ou na pagina 404 ?>

					<?php locate_template( array( 'content/loop-meta.php' ), true ); // Carrega o template content/loop-meta.php. ?>

				<?php endif; // Finaliza a chegagem por paginas. ?>

				<?php if ( have_posts() ) : // Checa se algum post foi encontrado. ?>

					<?php while ( have_posts() ) : // Inicia o loop para os posts encontrados. ?>

						<?php the_post(); // Carrega os dados do post. ?>
		
						<?php hybrid_get_content_template(); // Carrega um dos templates em content/*.php. ?>

						<?php if ( is_singular() ) : // Se estiver visualizando um post unico ou pagina. ?>

							<?php hybrid_get_sidebar( 'after-content' ); // Mostra a area de widget after-content. ?>

							<?php $authorbox_switch = get_theme_mod( 'epico_author_box_switch', 1 ); ?>

							<?php if ( is_singular( 'post' ) && $authorbox_switch == 1 ) locate_template( array( 'content/author-box.php' ), true ); // Carrega o template da caixa do autor ?>

							<?php $related_switch = get_theme_mod( 'epico_related_posts_switch', 1 ); ?>

							<?php $related = epico_get_related_posts( get_the_ID(), 6 ); ?>

							<?php if( $related->have_posts() && ! is_page() && $related_switch == 1 ): ?>

								<div class="epico-related-posts">

									<h3 class="epico-related-posts-title"><i class="fa fa-plus-square-o" ></i> <?php echo __( "Related posts", "epico" ); ?></h3>

									<ul>
										<?php while( $related->have_posts() ): $related->the_post(); ?>
											<li>
												<?php 
												if (1==1) { 
												
													?>

													<?php 

													 if (has_post_thumbnail()) { 
														$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'epico-rel-posts'); 
													}else{

													
															$content = get_the_content();
															preg_match_all('/<img[^>]+>/i',$content, $result); 
															$result = array_filter($result);
															preg_match_all('/src=[\'"]?([^\'" >]+)[\'" >]/',$content, $result2); 
															// print_r($result2);
															$thumb[0] = $result2[1][0];														
													}

													?>

													<div class="wrap-img-relpost">

														<a class="img-hyperlink" href="<?php the_permalink() ?>" title="<?php the_title() ?>">

															<img src="<?php echo $thumb[0] . '"' . 'alt="' . epico_get_thumbnail_field() . '"' . 'title="' . epico_get_thumbnail_field( 'title' ) . '"' ?> />

														</a>

													</div>

												<?php } else { ?>

													<div class="wrap-img-relpost">

														<a class="img-hyperlink rel-default" href="<?php the_permalink() ?>" title="<?php the_title() ?>">

															<img src="<?php echo get_template_directory_uri() . '/img/icons/rel_post_default.svg"' . ' alt="' . __( "Thumbnail", "epico") . ' title="' . __( "Post image", "epico") . '"' ?> />

														</a>

													</div>

												<?php } ?>

												<?php the_title( '<h4 ' . hybrid_get_attr( 'related-post-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h4>' ); ?>

											</li>
										<?php endwhile; ?>
									</ul>
								</div>
							<?php endif;

							wp_reset_postdata(); ?>

							<?php $navposts_switch = get_theme_mod( 'epico_post_nav_switch', 1 ); ?>

							<?php if ( is_singular( 'post' ) && $navposts_switch == 1 ) locate_template( array( 'content/nav-posts.php' ), true ); // Carrega o template da navegacao de artigos ?>

							<?php comments_template( '', true ); // Carrega o template comments.php. ?>

						<?php endif; // Finaliza a chegagem de posts unicos ou paginas.. ?>

					<?php endwhile; // Finaliza o loop com os posts encontrados. ?>


					<?php if ( ! is_singular() ) : // Caso NAO esteja visualizando uma pagina ou post unico. ?>

						<?php locate_template( array( 'content/loop-nav.php' ), true ); // Carrega o template content/loop-nav.php. ?>

					<?php endif; // Finaliza a chegagem por outros conteudos que nao sejam post unicos ou paginas. ?>

				<?php else : // Se nenhum post for encontrado. ?>

					<?php locate_template( array( 'content/error.php' ), true ); // Carrega o template content/error.php. ?>

				<?php endif; // Finaliza a checagem por posts. ?>


			</main><!-- #content -->


				<?php hybrid_get_sidebar( 'primary' ); // Carrega o template sidebar/primary.php. ?>


		</div><!-- .wrap -->
		<?php if ( is_home() ||  is_front_page() ) : ?>      
			<?php
				$page = get_posts(
				    array(
				        'name'      => 'footer-text',
				        'post_type' => 'page'
				    )
				);
				if ( $page ){
				    $content_footer_text = $page[0]->post_content;
				}

			?>
			
			<div class="footer-text">		
				<div class="wrap">
					<?php echo $content_footer_text; ?>
				</div>
			</div>
		<?php endif; ?>
	</div><!-- #main-conteiner -->

	<?php get_footer(); // Carrega o template footer.php template. ?>