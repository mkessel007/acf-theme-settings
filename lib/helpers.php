<?php

function mtm_acf_check() { // Does ACF Exist?

	if( !function_exists( 'acf_add_options_page' ) ) {
		return false;
	}
}

// Output header logo inside image tag, with link to homepage
// Optionally specify image size and class
function the_mtm_header_logo( $class = 'header-logo', $size = 'large' ) {

	if ( false !== mtm_acf_check() ) {

		if ( get_field( 'mtm_header_logo', 'option' ) ) { // make sure field value exists 

			$image = get_field( 'mtm_header_logo', 'option' );
			$alt = $image['alt'];
			$thumb = $image['sizes'][ $size ];
			?>

			<a href="<?php echo esc_url( home_url() ); ?>"><img class="<?php echo $class ?>" src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $alt ); ?>" /></a>
		
		<?php } else { // If nothing else is entered, show the blog name as usual ?> 

			<a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
		
		<?php }

	} else { // If ACF is inactive, show the blog name as usual ?> 

		<a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
	
	<?php }

}

// Outputs additional header text
function the_mtm_header_text() {

	if ( false !== mtm_acf_check() ) {

		if ( get_field( 'mtm_header_text', 'option' ) ) { // make sure field value exists 

			esc_html( the_field( 'mtm_header_text', 'option' ) ); 

		}
	}
}

// Outputs footer logo inside image tag, with link to homepage
function the_mtm_footer_logo(  $class = 'footer-logo', $size = 'large'  ) {

	if ( false !== mtm_acf_check() ) {

		if ( get_field( 'mtm_footer_logo', 'option' ) ) { // make sure field value exists 

			$image = get_field( 'mtm_footer_logo', 'option' );
			$alt = $image['alt'];
			$thumb = $image['sizes'][ $size ];
			?>

			<a href="<?php echo esc_url( home_url() ); ?>"><img class="<?php echo $class ?>" src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $alt ); ?>" /></a>

		<?php } 
	}
}

// Outputs copyright text with year and date
function the_mtm_footer_copyright() {

	$html = '';
	
	if ( false !== mtm_acf_check() ) {

		if ( get_field( 'mtm_copyright_text', 'option' ) ) { // make sure field value exists 

			$html .= '&copy; ' . date( 'Y' ) . ' ' . esc_html( get_field( 'mtm_copyright_text', 'option' ) ); 
		
		} else { // Show copyright year and site name

			$html .= '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' );  

		}

	} else { // If ACF is inactive, Show copyright year and site name

		$html .= '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' );  

	}

		echo $html;

}

// Outputs additional footer text
function the_mtm_footer_text() {

	if ( false !== mtm_acf_check() ) {

		if ( get_field( 'mtm_additional_text', 'option' ) ) { // make sure field value exists 

			esc_html( the_field( 'mtm_additional_text', 'option' ) ); 

		}
	}
}

// Outputs social icons with custom classes based on social network name
// Compatible with Font Awesome if installed
// Fallback for unsupported social networks as well
function the_mtm_social_icons( $prepend = '', $showtext = false ) {

	//$btntxt = '';

	if ( false !== mtm_acf_check() ) :

		if ( get_field( 'mtm_default_social_accounts', 'option' ) ) :
 				
 				// ACF Repeater Field
				if( have_rows( 'mtm_default_social_accounts', 'option' ) ) : ?>
			
				<div class="social-icons">
			
					<?php while( have_rows( 'mtm_default_social_accounts', 'option'  ) ) : the_row(); // Loop through each item 

						$btnclass = $prepend . sanitize_title_with_dashes( get_sub_field( 'mtm_default_social_name' ) );

						if ( $showtext ) {
							$btntxt = get_sub_field( 'mtm_default_social_name' );
						} ?>
			
						<a href="<?php the_sub_field( 'mtm_default_social_url' ); ?>"class="button button-social <?php echo $btnclass; ?>"><?php echo esc_html( $btntxt ); ?></a>
					
					<?php endwhile; ?>
			
				</div>
			
			<?php endif; // End ACF Repeater Field
		endif;
	endif;
}

// Outputs the post thumbnail with fallback for the default image
function the_mtm_post_thumbnail( $size = 'full', $class = '', $link = true, $attr ='' ) {

	if ( false !== mtm_acf_check() ) {

		if ( has_post_thumbnail() ) {
			
			if( $link ) { ?> <a href="<?php the_permalink(); ?>"> <?php } ?>
				<figure class="post--thumbnail <?php echo $class; ?>"> <?php the_post_thumbnail( $size, $attr ); ?> </figure>
			<?php if( $link ) { ?> </a> <?php }

		} elseif ( get_field( 'mtm_default_featured_image', 'option' ) ) { // make sure field value exists 

			$image = get_field( 'mtm_default_featured_image', 'option' );
			$thumb = $image['sizes'][ $size ];
			$alt = $image['alt'];

			if( $link ) { ?> <a href="<?php the_permalink(); ?>"> <?php } ?>
				<figure class="post--thumbnail default-thumbnail <?php echo $class; ?>"><img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_html( $alt ); ?>" /></figure>
			<?php if( $link ) { ?> </a> <?php }
		}
	}
}