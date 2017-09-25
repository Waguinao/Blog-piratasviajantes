		<div class="<?php echo sanitize_html_class( $custom_id ); ?>" id="ep-<?php echo esc_attr( $custom_id ); ?>" itemscope itemtype="http://schema.org/ItemList">
			<?php if(isset($atts['title'])){ ?>

			<h3 class="<?php echo sanitize_html_class( $custom_id ); ?>-title <?php echo esc_attr( implode(", ", (array)$atts['icon']) ); ?>" itemprop="name">
				<?php echo balancetags( implode(", ", (array)$atts['title']) ); ?>
			</h3>

			<meta itemprop="itemListOrder" content="http://schema.org/ItemListOrderDescending" />

			<?php } ?>

			<?php if(isset($atts['article'])){ ?>

			<ul class="<?php echo sanitize_html_class( $custom_id ); ?>-list">
				<?php $i = 0; foreach((array) $groups['article'] as $increment=>$context){ $i++; ?>

					<li class="<?php echo sanitize_html_class( $custom_id ); ?>-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a class="<?php echo sanitize_html_class( $custom_id ); ?>-link" id="<?php echo sanitize_html_class( $custom_id ) . $i; ?>" <?php echo ( ( 0 == $atts[ 'target' ] ) ? 'target="_blank"' : '' )  ?> href="<?php echo esc_url (get_permalink( $context['article'] ) ); ?>" itemprop="url">
							<span itemprop="name"><?php echo esc_html( get_the_title( $context['article'] ) ); ?></span>
						</a>
						<meta itemprop="position" content="<?php echo $i; ?>" />
					</li>

				<?php } ?>

			</ul>

			<?php } ?>

		</div>
