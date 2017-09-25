<?php
/**
 * Template Name: Iframes
 */
?>
<?php get_header(); // Carrega o template header.php. ?>

	<?php if ( is_active_sidebar( 'after-promocional' ) ) : ?>
			<!-- <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary"> -->
				<?php dynamic_sidebar( 'after-promocional' ); ?>
			<!-- </div> -->
		<?php endif; ?>

		<div class="botaoPostTop">
		<?php echo do_shortcode('[uwl_about_me id="4"]'); ?>
		</div>


		<?php
			ob_start();
			// $content = get_the_content(); 
			the_content(); 
			$content = ob_get_contents();
			ob_end_clean();

			echo $content;

		  ?>

		<Br>
		<Br>

	<?php get_footer(); // Carrega o template footer.php template. ?>