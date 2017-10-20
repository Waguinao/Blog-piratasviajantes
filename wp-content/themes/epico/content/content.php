<?php
$GLOBALS['countPost'] = !isset($GLOBALS['countPost'])?0:($GLOBALS['countPost']=$GLOBALS['countPost']+1);
$countPost = $GLOBALS['countPost'];
?>

<article <?php hybrid_attr( 'post' ); ?>>

	<meta itemprop="inLanguage" content="<?php echo get_bloginfo('language'); ?>"/>

	<?php if ( is_singular( get_post_type() )) : // Se estiver vendo um post unico. ?>

		<header class="entry-header">

			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1> 

			<div class="entry-byline">

				<span <?php hybrid_attr( 'entry-author' ); ?>><span itemprop="name"><?php is_multi_author() ? the_author_posts_link() : the_author(); ?></span></span>

				<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>

				<?php comments_popup_link( __( 'Comment', 'epico' ),  __( '1 comment', 'epico' ), __( '% comments', 'epico' ) , 'comments-link', '' ); ?>

				<?php hybrid_post_terms( array( 'taxonomy' => 'category', 'text' => __( '%s', 'epico' ) ) ); ?>

				<?php edit_post_link(); ?>

			</div><!-- .entry-byline -->

				<?php $show_featured = get_post_meta( get_the_ID(), 'epico-show-featured', TRUE ); ?>

				<?php if ( 'on' === $show_featured ) { // Se o meta box da area de artigos tiver o valor configurado para `ligado` ?>

					<?php //the_post_thumbnail(); ?>

				<?php } ?>

			<?php //include( locate_template( '/inc/social-buttons.php' ) ); // Adiciona codigo para botoes sociais. ?>

		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-content' ); ?>>

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

		 // echo '<div class="topo" style="background:url('.$thumb_url.')"></div>';
		endif;
	?>

		
			<div class="adsensepost" style="background:url(<?php echo $thumb_url; ?>)">
				
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<ins class="adsbygoogle"
					     style="display:inline-block;width:300px;height:250px"
					     data-ad-client="ca-pub-7694831168422394"
					     data-ad-slot="1674848571"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>

</div>

			<?php the_content(); ?>

			<?php wp_link_pages(); ?>

		</div><!-- .entry-content -->


	<?php else : // Se estiver visualizado a listagem de artigos (ou seja, se NAO estiver visualizando um post unico). ?>


		<?php //if ( has_post_thumbnail() ) : ?>
		<?php if ( 1==1 ) : ?>
	<?php 
		//echo $countPost;
		if($countPost <2):?>
		
		<a class="img-hyperlink2"  itemprop="image" itemscope="itemscope" itemtype="http://schema.org/ImageObject">
	<?php

		$dateNow = strtotime(date('Y-m-d H:i:s'));
			// editar banner
			if($countPost <1 && ($dateNow > strtotime('2017-08-20 00:00:00') && $dateNow < strtotime('2017-08-28 00:00:00')) ){
				
$banners[0]['imagen']="http://www.melhorembarque.com.br/wp-content/uploads/2017/08/BRS__300x250_SAO_BUE_Melhor-Embarque.jpg"; 
$banners[0]['url']="http://www.aerolineas.com.ar/pt-br/promo/promobrasil?artid=brpo289322"; 

$banners[1]['imagen']="http://www.melhorembarque.com.br/wp-content/uploads/2017/08/BRS__300x250_SAO_MVD_Melhor-Embarque.jpg"; 
$banners[1]['url']="http://www.aerolineas.com.ar/pt-br/promo/promobrasil?artid=brpo289322"; 

$banners[2]['imagen']="http://www.melhorembarque.com.br/wp-content/uploads/2017/08/BRS__300x250_SAO_SCLMelhor-Embarque.jpg"; 
$banners[2]['url']="http://www.aerolineas.com.ar/pt-br/promo/promobrasil?artid=brpo289322"; 

$banners[3]['imagen']="http://www.melhorembarque.com.br/wp-content/uploads/2017/08/BRS__300x250_SAO_BUE_Melhor-Embarque.jpg"; 
$banners[3]['url']="http://www.aerolineas.com.ar/pt-br/promo/promobrasil?artid=brpo289322"; 

$id_banner = array_rand($banners); 

echo "<a href='".$banners[$id_banner]['url']."' target='_blank'><img src='".$banners[$id_banner]['imagen']."'></a>";
	
			}else{	
			echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> <!-- 300x250 --> <ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-7694831168422394" data-ad-slot="4170561772"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script>';	
			
				

			}
	?>
	</a>
	<?php 
	else:
	?>
			<a class="img-hyperlink" itemprop="image" itemscope="itemscope" itemtype="http://schema.org/ImageObject" href="<?php the_permalink() ?>" title="<?php the_title() ?>">

				<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'epico-tiny' );

				$alt_text = epico_get_thumbnail_field();				
				
				if($image[0]){
					$thumbImgFinal = $image[0];
				}else{
					$thumb_url = wp_get_attachment_url( get_post_thumbnail_id() );

					if($thumb_url == ''){
						$content = get_the_content();
						preg_match_all('/<img[^>]+>/i',$content, $result); 
						$result = array_filter($result);
						preg_match_all('/src=[\'"]?([^\'" >]+)[\'" >]/',$content, $result2); 
						// print_r($result2);
						$thumb_url = $result2[1][0];
					}

				
					$thumbImgFinal = $thumb_url;
				}

				echo '<img itemprop="contentURL" src="' . esc_url( $thumbImgFinal ) . '" alt="' . esc_attr( $alt_text ) .'" />';
				// echo '<img itemprop="contentURL" src="' . esc_url( $image[0] ) . '" alt="' . esc_attr( $alt_text ) .'" />';

		?>

			</a>
	
	<?php
	endif;
	?>
		<?php else : ?>

			<a class="no-img-hyperlink" href="<?php the_permalink() ?>" title="<?php the_title() ?>"></a>

		<?php endif ?>

		<?php $compactloop = get_theme_mod( 'epico_compact_loop', 1 ); ?>
		

		<?php if ( 0 == $compactloop ) : // Se a listagem compacta NAO estiver ativada. ?>

			<div class="entry-byline">

				<span <?php hybrid_attr( 'entry-author' ); ?>><span itemprop="name"><?php is_multi_author() ? the_author_posts_link() : the_author(); ?></span></span>

				<meta itemprop="datePublished" content="<?php echo get_the_time( 'Y-m-d\TH:i:sP' ); ?>" />

				<?php hybrid_post_terms( array( 'taxonomy' => 'category', 'text' => __( '%s', 'epico' ) ) ); ?>

				<?php if( post_type_supports( get_post_type(), 'comments' ) ) : // Se o tipo de post suporta comentarios ?>

					<?php if( comments_open() ) : // Se os comentarios estiverem abertos ?>

						<span <?php hybrid_attr( 'comments-link-wrap' ); ?>><?php comments_popup_link( __( 'Comment', 'epico' ),  __( '1 comment', 'epico' ), __( '% comments', 'epico' ) , 'comments-link', '' ); ?></span>

					<?php endif; // Finaliza chegagem por comentarios abertos. ?>

				<?php endif; // Finaliza chegagem por suporte a comentarios. ?>

			</div><!-- .entry-byline -->

			<header class="entry-header">

				<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>

			</header><!-- .entry-header -->

			<div <?php hybrid_attr( 'entry-summary' ); ?>>

				<?php the_excerpt(); ?>


			</div><!-- .entry-summary -->

		<?php else : // Se a listagem compacta estiver ativada. ?>

			<div class="entry-byline">

				<span <?php hybrid_attr( 'entry-author' ); ?>><span itemprop="name"><?php is_multi_author() ? the_author_posts_link() : the_author(); ?></span></span>

				<meta itemprop="datePublished" content="<?php echo get_the_time( 'Y-m-d\TH:i:sP' ); ?>" />

				<?php
				$categories = get_the_category();
				$separator = ', ';
				$output = '';
				if($categories){
					foreach($categories as $category) {
						$output .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . __( 'Main category:','epico' ) . ' ' . esc_attr( sprintf( __( "%s" ), $category->name ) ) . '">' . $category->cat_name . '</a>' . $separator;
					}
				echo '<span class="entry-terms category" itemprop="articleSection">' . trim($output, $separator) . '</span>';
				}
				?>

				<span <?php hybrid_attr( 'comments-link-wrap' ); ?>><?php comments_popup_link( '',  '1', '%' , 'comments-link', '' ); ?></span>

			</div><!-- .entry-byline -->

			<header class="entry-header">

				<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
				

			</header><!-- .entry-header -->

			<div <?php hybrid_attr( 'entry-summary' ); ?>>
				<div class="social">
					<div class="social2">
						<?php 
						
							if(get_comments_number()>0){
								echo '<span class="autor">';
								comments_popup_link( __( 'Comment', 'epico' ),  __( '1 comment', 'epico' ), __( '% comments', 'epico' ) , 'comments-link', '' ); 
								echo ' Comentários';
								echo '</span>';
							}

						?> 
					
					
						

						<span class="autor"><time><?php echo get_the_date(); ?></time></span>
						
						<span class="autor"><span itemprop="name"><?php is_multi_author() ? the_author_posts_link() : the_author(); ?></span></span>
						
						<span class="autor"><?php hybrid_post_terms( array( 'taxonomy' => 'category', 'text' => __( '%s', 'epico' ) ) ); ?></span>

						

						
					</div>
				<?php edit_post_link(); ?>
				
					<?php echo cropText(get_the_content(), 380); ?> 
					
					<a href="<?php echo get_permalink(); ?>" title="Continue Lendo"> <span class="read">&raquo; Continue Lendo</span> </a>

			</div><!-- .entry-byline -->
			
				
				
			

			</div><!-- .entry-summary -->

		<?php endif; // Finaliza checagem por ativacao da listagem compacta. ?>

	<?php endif; // Finaliza chegagem por posts unicos. ?>

	<?php include( locate_template( '/inc/zen-mode.php' ) ); // Adiciona codigo do modo Zen. ?>


</article><!-- .entry -->

<?php  if ( is_single() ) : ?>

<div class="newsletter_base_page">
				<h4 class="widgettitle"></h4>
					<p class="texto_newsletter" style="float:left; text-alig:left; font-size:13px; color:#7b7b7b;"><strong>Gostou do post? Tem muito mais, todo dia e grátis!<br>Deixe seu e-mail para receber as novidades!</strong></p>
					<div id="mc_embed_signup">
					<form action="//melhorembarque.us10.list-manage.com/subscribe/post?u=2d39588dfed0f7cd514473855&amp;id=7e0390e0e2" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					    <div id="mc_embed_signup_scroll">
						
						
						<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="E-mail" required="" style="width:235px; height:22px;">
						<input type="submit" value="EU QUERO" name="subscribe" id="mc-embedded-subscribe" style="font-weight: bold;" class="button">
					    
					    <div style="position: absolute; left: -5000px;"><input type="text" name="b_2d39588dfed0f7cd514473855_7e0390e0e2" tabindex="-1" value=""></div>
					    <div class="clear"></div>
					    </div>
					</form>
					</div>
				</div>
				<!--End mc_embed_signup-->
<?php endif; ?>				