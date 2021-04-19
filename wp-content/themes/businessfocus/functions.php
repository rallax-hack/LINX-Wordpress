<?php
/*
 * This is the child theme for BusinessFocus theme.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */
function businessfocus_enqueue_styles() {
    // Include parent theme CSS.
    wp_enqueue_style( 'photofocus-style', get_template_directory_uri() . '/style.css', null, date( 'Ymd-Gis', filemtime( get_template_directory() . '/style.css' ) ) );
    
    // Include child theme CSS.
    wp_enqueue_style( 'businessfocus-style', get_stylesheet_directory_uri() . '/style.css', array( 'photofocus-style' ), date( 'Ymd-Gis', filemtime( get_stylesheet_directory() . '/style.css' ) ) );

	// Load the rtl.
	if ( is_rtl() ) {
		wp_enqueue_style( 'photofocus-rtl', get_template_directory_uri() . '/rtl.css', array( 'photofocus-style' ), $version );
	}

	// Enqueue child block styles after parent block style.
	wp_enqueue_style( 'businessfocus-block-style', get_stylesheet_directory_uri() . '/assets/css/child-blocks.css', array( 'photofocus-block-style' ), date( 'Ymd-Gis', filemtime( get_stylesheet_directory() . '/assets/css/child-blocks.css' ) ) );
}
add_action( 'wp_enqueue_scripts', 'businessfocus_enqueue_styles' );

/**
 * Add child theme editor styles
 */
function businessfocus_editor_style() {
	add_editor_style( array(
			'assets/css/child-editor-style.css',
			photofocus_fonts_url(),
			get_theme_file_uri( 'assets/css/font-awesome/css/font-awesome.css' ),
		)
	);
}
add_action( 'after_setup_theme', 'businessfocus_editor_style', 11 );

/**
 * Enqueue editor styles for Gutenberg
 */
function businessfocus_block_editor_styles() {
	// Enqueue child block editor style after parent editor block css.
	wp_enqueue_style( 'businessfocus-block-editor-style', get_stylesheet_directory_uri() . '/assets/css/child-editor-blocks.css', array( 'photofocus-block-editor-style' ), date( 'Ymd-Gis', filemtime( get_stylesheet_directory() . '/assets/css/child-editor-blocks.css' ) ) );
}
add_action( 'enqueue_block_editor_assets', 'businessfocus_block_editor_styles', 11 );

/**
 * Register Google fonts Poppin for BusinessFociu
 *
 * @since BusinessFocus 1.0.0
 *
 * @return string Google fonts URL for the theme.
 */
function photofocus_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Poppins, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$poppins = _x( 'on', 'Poppins: on or off', 'businessfocus' );

	if ( 'off' !== $poppins ) {
		$font_families = array();

		$font_families[] = 'Poppins:200,300,400,500,600,700,400italic,700italic';
		
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function businessfocus_body_classes( $classes ) {
	// Added color scheme to body class.
	$classes['color-scheme'] = 'color-scheme-corporate';

	return $classes;
}
add_filter( 'body_class', 'businessfocus_body_classes', 100 );

/**
 * Change default header text color
 */
function businessfocus_dark_header_default_color( $args ) {
	$args['default-image'] =  get_theme_file_uri( 'assets/images/header-image.jpg' );

	return $args;
}
add_filter( 'photofocus_custom_header_args', 'businessfocus_dark_header_default_color' );

/**
 * Override parent theme to add promotion headline section.
 */
function photofocus_sections( $selector = 'header' ) {
	get_template_part( 'template-parts/header/header', 'media' );
	get_template_part( 'template-parts/slider/display', 'slider' );
	get_template_part( 'template-parts/services/display', 'services' );
	get_template_part( 'template-parts/hero-content/content','hero' );
	get_template_part( 'template-parts/featured-content/display', 'featured' );
	get_template_part( 'template-parts/promotion-headline/post-type-promotion' );
	get_template_part( 'template-parts/portfolio/display', 'portfolio' );
	get_template_part( 'template-parts/testimonial/display', 'testimonial' );
	
}

/**
 * Load Customizer Options
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/customizer/promotion-headline.php';
