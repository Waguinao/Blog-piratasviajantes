<?php if( 1 == $atts[ 'override' ] ) {

	$icon_color_before  = esc_attr( implode( ", ", ( array )$atts[ 'icon_color' ] ) );
	$icon_color_replace = str_replace( '#', '%23', $icon_color_before );

	echo '
	[class*=epc-s] .widget_social-id #es-' . esc_attr( $custom_id ) . ' li > a {
		background: ' . esc_attr( implode( ", ", ( array )$atts[ 'icon_bkg_color' ] ) ) . ';
		}

	[class*=epc-s] .widget_social-id #es-' . esc_attr( $custom_id ) . ' li > a:before {
		color: ' . esc_attr( implode( ", ", ( array )$atts[ 'icon_color' ] ) ) . ' !important;
		}

	[class*=epc-s] .widget_social-id #es-' . esc_attr( $custom_id ) . ' li > a.google-plus:before {
		content: url(\'data:image/svg+xml;utf8,<svg width="100%" height="100%" viewBox="0 0 60 60" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;"><g id="Layer1"><path d="M42.684,31.153l0,-2.306l-2.306,0l0,-2.306l-2.306,0l0,2.306l-2.306,0l0,2.306l2.306,0l0,2.306l2.306,0l0,-2.306l2.306,0ZM25.388,28.847l0,2.767l4.612,0c-0.231,1.153 -1.384,3.46 -4.612,3.46c-2.768,0 -4.959,-2.307 -4.959,-5.074c0,-2.767 2.191,-5.074 4.959,-5.074c1.614,0 2.652,0.692 3.228,1.269l2.191,-2.076c-1.384,-1.384 -3.229,-2.191 -5.419,-2.191c-4.498,0 -8.072,3.575 -8.072,8.072c0,4.497 3.574,8.072 8.072,8.072c4.612,0 7.725,-3.229 7.725,-7.841c0,-0.577 0,-0.923 -0.115,-1.384l-7.61,0Z" style="fill:' . $icon_color_replace . ';fill-rule:nonzero;"/></g></svg>\');
		}

	#es-' . esc_attr( $custom_id ) . ' {
		background: ' . esc_attr( implode( ", ", ( array )$atts[ 'bkg_color' ] ) ) . ' !important;
		}

	.widget_social-id h3.' . esc_attr( $custom_id ) . '-title {
		color: ' . esc_attr( implode( ", ", ( array )$atts[ 'text_color' ] ) ) . ' !important;
		}';

} ?>
