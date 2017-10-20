		<div class="<?php echo sanitize_html_class( $custom_id ); ?>"  id="<?php echo esc_attr( $custom_id ); ?>" itemscope itemtype="http://schema.org/Person">

			<?php if( isset( $atts[ 'img_src' ] ) ){ ?>

			<a class="<?php echo sanitize_html_class( $custom_id ); ?>-img-link" <?php echo ( ( 0 == $atts[ 'target' ] ) ? 'target="_blank"' : '' )  ?> href="<?php echo esc_url( implode(", ", (array)$atts['button_url']) ); ?>"><img class="<?php echo sanitize_html_class( $custom_id ); ?>-img" src="<?php echo esc_url( implode(", ", (array)$atts['img_src']) ); ?>" alt="<?php echo esc_attr( implode(", ", (array)$atts['img_alt']) ); ?>" itemprop="image" /></a>

			<?php } ?>


			<?php if( isset( $atts[ 'title' ] ) ){ ?>

			<h3 class="<?php echo sanitize_html_class( $custom_id ); ?>-title" itemprop="givenName">

				<?php echo balanceTags( $atts['title'] ); ?>

			</h3>

			<?php } ?>

			<?php if( isset( $atts[ 'intro_p' ] ) ){?>

			<p class="<?php echo sanitize_html_class( $custom_id ); ?>-intro"><?php echo balanceTags( $atts['intro_p'] ); ?></p>

			<?php } ?>


			<?php if( isset( $atts[ 'button_txt' ] ) ){ ?>

			<a class="<?php echo sanitize_html_class( $custom_id ); ?>-button" id="<?php echo esc_attr( $custom_id ); ?>" <?php echo ( ( 0 == $atts[ 'target' ] ) ? 'target="_blank"' : '' )  ?> href="<?php echo esc_url( implode(", ", (array)$atts['button_url']) ); ?>" itemprop="url"><?php echo esc_html( implode(", ", (array)$atts['button_txt']) ); ?></a>

			<?php } ?>

		</div>
