<?php
/**
 * Template para o rodape do tema
 *
 * Apresenta a secao <footer> ate o fim do HTML
 *
 * @package Epico
 * @subpackage Footer
 * @since 1.0.0
 */
?>

		<?php if ( ! is_404() ) {  // Checa se NAO e pagina 404 ?>

			<?php hybrid_get_sidebar( 'subsidiary' ); // Mostra sidebar-subsidiary. ?>

		<?php } ?>


		

		<footer <?php hybrid_attr( 'footer' ); ?>>

		<?php if ( is_active_sidebar( 'footer' ) ) { // Se houver widgets nesta area ?>
		<div id="credits-novo">

				<div class="wrap">

					<div class="credits-novo">
					<h2>&nbsp;</h2>
						
						<h3>Saiba o que estão falando sobre o Melhor Embarque</h3>

						<div class="col-md-12">
							<a href="http://exame.abril.com.br/seu-dinheiro/7-sites-para-encontrar-promocoes-de-passagens-aereas/#6" target="_blank" title="Exame"><img src="http://www.melhorembarque.com.br/wp-content/uploads/2016/12/exame.png" alt="Exame" /></a>
							<a href="http://www.infomoney.com.br/minhas-financas/turismo/noticia/5675116/site-vai-rastrear-melhores-precos-viagens-black-friday" target="_blank" title="Infomoney"><img src="http://www.melhorembarque.com.br/wp-content/uploads/2016/11/infomoney.png" alt="Infomoney" /></a>
							<a href="https://br.financas.yahoo.com/noticias/site-vai-rastrear-melhores-pre%C3%A7os-143800479.html" target="_blank" title="Yahoo"><img src="http://www.melhorembarque.com.br/wp-content/uploads/2016/11/yahoo.png" alt="Yahoo" /></a>
							<a href="http://clientesa.com.br/" target="_blank" title="Cliente SA"><img src="http://www.melhorembarque.com.br/wp-content/uploads/2016/11/cliente-sa.png" alt="Cliente SA" /></a>
							<a href="hhttp://g1.globo.com/economia/seu-dinheiro/noticia/2016/11/veja-como-aproveitar-os-descontos-da-black-friday-sem-cair-em-roubadas.html" target="_blank" title="G1"><img src="http://www.melhorembarque.com.br/wp-content/uploads/2016/11/g1.png" alt="G1" /></a>
							
							<a href="http://turismo.ig.com.br/manual-do-viajante/2016-11-22/passagens-areas-baratas.html" target="_blank" title="IG"><img src="http://www.melhorembarque.com.br/wp-content/uploads/2016/11/ig.png" alt="IF" /></a>
							
							<a href="http://www.mercadoeeventos.com.br/noticias/servicos/black-friday-veja-onde-encontrar-as-melhores-ofertas/" target="_blank" title="Mercados e Eventos"><img src="http://www.melhorembarque.com.br/wp-content/uploads/2016/11/mercado-e-eventos.png" alt="Mercado & Evento" /></a>
							<a href="http://cbndiario.clicrbs.com.br/sc/noticia-aberta/black-friday-confira-os-horarios-e-descontos-dos-shoppings-centers-em-santa-catarina-182641.html" target="_blank" title="CBN"><img src="http://www.melhorembarque.com.br/wp-content/uploads/2017/01/cbn.png" alt="CBN" /></a>
					
						
						</div>	

					</div>
					
					
					

				</div>

			</div>

			<div class="wrap footer-widgets">

				<?php hybrid_get_sidebar( 'footer' ); // Carrega o template sidebar/footer.php. ?>

			</div>

		<?php } ?>

			<div class="footer-social">
					<h2>Siga-nos:</h2>
						<div class="siga">
							
								<a href="https://www.facebook.com/melhorembarque" target="_blank"><img src="http://www.melhorembarque.com.br/wp-content/uploads/2016/12/rodape-site-melhor-embarque-01-1.png" alt="Facebook" /></a>
								<a href="https://plus.google.com/+MelhorembarqueBr" target="_blank"><img src="http://www.melhorembarque.com.br/wp-content/uploads/2016/12/rodape-site-melhor-embarque-05-1.png" alt="Google +" /></a>
								<a href="https://www.instagram.com/melhorembarque/" target="_blank"><img src="http://www.melhorembarque.com.br/wp-content/uploads/2016/12/rodape-site-melhor-embarque-02-1.png" alt="Instagram" /></a>								
								<a href="https://twitter.com/melhorembarque" target="_blank"><img src="http://www.melhorembarque.com.br/wp-content/uploads/2016/12/rodape-site-melhor-embarque-04-1.png" alt="Twitter" /></a>
								<a href="https://www.youtube.com/+melhorembarquebr" target="_blank"><img src="http://www.melhorembarque.com.br/wp-content/uploads/2016/12/rodape-site-melhor-embarque-03-1.png" alt="Youtube" /></a>
								
							
							
							
						</div>
					</div>	
			
			<div id="credits">

				<div class="wrap">
				
				
				
				


					<div class="credit">

						<p>
							<?php

							$footerText = get_theme_mod( 'epico_footer_txt', __( 'All rights reserved', 'epico' ) );

							$siteDate = Date('Y');//get_theme_mod( 'epico_date' );

							$siteNameFooter = get_theme_mod( 'epico_site_name', get_bloginfo( 'name', 'epico' ) );

							$logoFooter = get_theme_mod( 'epico_logo_image_footer' ); ?>

							<?php if ( $logoFooter ) { // Usa o logo se estiver configurado. ?>

							<span itemprop="image" itemscope="itemscope" itemtype="http://schema.org/ImageObject" id="footer-logo-img">

								<meta itemprop="name" content="<?php echo esc_attr( $siteName ); ?>">

								<a href="<?php echo esc_url( home_url() ); ?>" rel="home" title=" __( 'Homepage', 'epico' )">

									<img id="footer-logo" src="<?php echo esc_url( $logoFooter ); ?>" itemprop="contentURL" alt="<?php the_title() ?>" />

								</a>

							</span>

							<?php } ?>
							

							<span id="credit-text"><a href="<?php echo esc_url( home_url() ); ?>" rel="home" title="<?php echo esc_attr( $siteNameFooter ); ?>"><?php echo esc_attr( $siteNameFooter ); ?></a> &#183; <?php epico_copyright_footer( esc_attr( $siteDate ) ); ?>

								<?php if ( $footerText ) { ?>

									<?php echo esc_attr( $footerText ); ?>

								<?php } ?>

							</span>

						</p>

						<?php //hybrid_get_menu( 'secondary' ); // Carrega o template menu/social.php. ?>

					</div>
					
					
					

				</div>

			</div>

		</footer><!-- #footer -->

	</div><!-- #page -->

	<?php wp_footer(); // Hook do WordPress para carregar estilos e javascript ao fim do HTML. ?>

</body>

</html>