<?php
/**
 * Template Name: Lista de autores
 *
 *
 * @package Epico
 * @subpackage Header
 * @since 1.0.2
 */
?>
<?php get_header(); // Carrega o template header.php. ?>


	

	<div id="main-container">

		<div class="wrap">

<?php

	$siteLayout = get_theme_mod( 'epico_sidebar_layout', 1 ); // Opcoes do customizador

	$contentClass = ''; ?>

<?php if ( $siteLayout == 0 ) {

	$contentClass = 'content-right';

} else if ( $siteLayout == 1 ) {

	$contentClass = 'content-left';

}

	// Get all users order by amount of posts
	$allUsers = get_users('orderby=post_count&order=DESC');

	$users = array();

	// Remove subscribers from the list as they won't write any articles
	foreach($allUsers as $currentUser)
	{
		if(!in_array( 'subscriber', $currentUser->roles ))
		{
			$users[] = $currentUser;
		}
	}

?>

			<main id="content" class="content <?php echo esc_html( $contentClass ); ?>" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

			<?php if ( is_active_sidebar( 'before-content' ) ) : // Se a area de widgets possui widgets. ?>

					<aside id="sidebar-before-content">

						<?php dynamic_sidebar( 'before-content' ); // Apresenta a area de widgets auxiliar. ?>

					</aside><!-- #sidebar-promo .aside -->

			<?php endif; // Finaliza a checagem por widgets. ?>

				<article <?php hybrid_attr( 'post' ); ?>>

					<header class="entry-header">

						<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>

						<?php $show_featured = get_post_meta( get_the_ID(), 'epico-show-featured', TRUE ); ?>

						<?php if ( 'on' === $show_featured ) { // Caso o show_featured estiver marcado como `on`. ?>

							<?php the_post_thumbnail(); ?>

						<?php } ?>

						
					</header><!-- .entry-header -->

					<div <?php //hybrid_attr( 'entry-content' ); ?>>


						<!-- Google - pesquisa personalizada -->
						<script>
					  (function() {
					    var cx = '001767882515951022115:jydpy4kbngk';
					    var gcse = document.createElement('script');
					    gcse.type = 'text/javascript';
					    gcse.async = true;
					    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
					    var s = document.getElementsByTagName('script')[0];
					    s.parentNode.insertBefore(gcse, s);
					  })();
					</script>
					<gcse:searchresults-only></gcse:searchresults-only>
					<!-- Google - pesquisa personalizada -->



					</div><!-- .entry-content -->

					<footer class="entry-footer">

						<?php edit_post_link(); ?>

					</footer><!-- .entry-footer -->

					<?php include( locate_template( '/inc/zen-mode.php' ) ); // Adiciona codigo do modo Zen. ?>

				</article><!-- .entry -->

				<?php hybrid_get_sidebar( 'after-content' ); // Mostra a area de widget after-content. ?>

			</main><!-- #content -->

				<?php hybrid_get_sidebar( 'primary' ); // Carrega o template sidebar/primary.php. ?>

		</div><!-- .wrap -->

	</div><!-- #main-conteiner -->

		<?php get_footer(); // Carrega o template footer.php template. ?>
