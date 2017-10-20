<?php
/**
 * The main Kirki object
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Toolkit' ) ) {
	return;
}

final class Kirki_Toolkit {

	/** @var Kirki The only instance of this class */
	public static $instance = null;

	public static $version = '2.0.3';

	public $font_registry = null;
	public $scripts       = null;
	public $api           = null;
	public $styles        = array();

	/**
	 * Access the single instance of this class
	 * @return Kirki
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new Kirki_Toolkit();
		}
		return self::$instance;
	}

	/**
	 * Shortcut method to get the translation strings
	 */
	public static function i18n() {

		$i18n = array(
			'background-color'      => esc_attr__( 'Background Color', 'epico' ),
			'background-image'      => esc_attr__( 'Background Image', 'epico' ),
			'no-repeat'             => esc_attr__( 'No Repeat', 'epico' ),
			'repeat-all'            => esc_attr__( 'Repeat All', 'epico' ),
			'repeat-x'              => esc_attr__( 'Repeat Horizontally', 'epico' ),
			'repeat-y'              => esc_attr__( 'Repeat Vertically', 'epico' ),
			'inherit'               => esc_attr__( 'Inherit', 'epico' ),
			'background-repeat'     => esc_attr__( 'Background Repeat', 'epico' ),
			'cover'                 => esc_attr__( 'Cover', 'epico' ),
			'contain'               => esc_attr__( 'Contain', 'epico' ),
			'background-size'       => esc_attr__( 'Background Size', 'epico' ),
			'fixed'                 => esc_attr__( 'Fixed', 'epico' ),
			'scroll'                => esc_attr__( 'Scroll', 'epico' ),
			'background-attachment' => esc_attr__( 'Background Attachment', 'epico' ),
			'left-top'              => esc_attr__( 'Left Top', 'epico' ),
			'left-center'           => esc_attr__( 'Left Center', 'epico' ),
			'left-bottom'           => esc_attr__( 'Left Bottom', 'epico' ),
			'right-top'             => esc_attr__( 'Right Top', 'epico' ),
			'right-center'          => esc_attr__( 'Right Center', 'epico' ),
			'right-bottom'          => esc_attr__( 'Right Bottom', 'epico' ),
			'center-top'            => esc_attr__( 'Center Top', 'epico' ),
			'center-center'         => esc_attr__( 'Center Center', 'epico' ),
			'center-bottom'         => esc_attr__( 'Center Bottom', 'epico' ),
			'background-position'   => esc_attr__( 'Background Position', 'epico' ),
			'background-opacity'    => esc_attr__( 'Background Opacity', 'epico' ),
			'on'                    => esc_attr__( 'ON', 'epico' ),
			'off'                   => esc_attr__( 'OFF', 'epico' ),
			'all'                   => esc_attr__( 'All', 'epico' ),
			'cyrillic'              => esc_attr__( 'Cyrillic', 'epico' ),
			'cyrillic-ext'          => esc_attr__( 'Cyrillic Extended', 'epico' ),
			'devanagari'            => esc_attr__( 'Devanagari', 'epico' ),
			'greek'                 => esc_attr__( 'Greek', 'epico' ),
			'greek-ext'             => esc_attr__( 'Greek Extended', 'epico' ),
			'khmer'                 => esc_attr__( 'Khmer', 'epico' ),
			'latin'                 => esc_attr__( 'Latin', 'epico' ),
			'latin-ext'             => esc_attr__( 'Latin Extended', 'epico' ),
			'vietnamese'            => esc_attr__( 'Vietnamese', 'epico' ),
			'hebrew'                => esc_attr__( 'Hebrew', 'epico' ),
			'arabic'                => esc_attr__( 'Arabic', 'epico' ),
			'bengali'               => esc_attr__( 'Bengali', 'epico' ),
			'gujarati'              => esc_attr__( 'Gujarati', 'epico' ),
			'tamil'                 => esc_attr__( 'Tamil', 'epico' ),
			'telugu'                => esc_attr__( 'Telugu', 'epico' ),
			'thai'                  => esc_attr__( 'Thai', 'epico' ),
			'serif'                 => _x( 'Serif', 'font style', 'epico' ),
			'sans-serif'            => _x( 'Sans Serif', 'font style', 'epico' ),
			'monospace'             => _x( 'Monospace', 'font style', 'epico' ),
			'font-family'           => esc_attr__( 'Font Family', 'epico' ),
			'font-size'             => esc_attr__( 'Font Size', 'epico' ),
			'font-weight'           => esc_attr__( 'Font Weight', 'epico' ),
			'line-height'           => esc_attr__( 'Line Height', 'epico' ),
			'letter-spacing'        => esc_attr__( 'Letter Spacing', 'epico' ),
			'top'                   => esc_attr__( 'Top', 'epico' ),
			'bottom'                => esc_attr__( 'Bottom', 'epico' ),
			'left'                  => esc_attr__( 'Left', 'epico' ),
			'right'                 => esc_attr__( 'Right', 'epico' ),
		);

		$config = apply_filters( 'kirki/config', array() );

		if ( isset( $config['i18n'] ) ) {
			$i18n = wp_parse_args( $config['i18n'], $i18n );
		}

		return $i18n;

	}

	/**
	 * Shortcut method to get the font registry.
	 */
	public static function fonts() {
		return self::get_instance()->font_registry;
	}

	/**
	 * Constructor is private, should only be called by get_instance()
	 */
	private function __construct() {
	}

	/**
	 * Return true if we are debugging Kirki.
	 */
	public static function kirki_debug() {
		return (bool) ( defined( 'KIRKI_DEBUG' ) && KIRKI_DEBUG );
	}

    /**
     * Take a path and return it clean
     *
     * @param string $path
	 * @return string
     */
    public static function clean_file_path( $path ) {
        $path = str_replace( '', '', str_replace( array( "\\", "\\\\" ), '/', $path ) );
        if ( '/' === $path[ strlen( $path ) - 1 ] ) {
            $path = rtrim( $path, '/' );
        }
        return $path;
    }

	/**
	 * Determine if we're on a parent theme
	 *
	 * @param $file string
	 * @return bool
	 */
	public static function is_parent_theme( $file ) {
		$file = self::clean_file_path( $file );
		$dir  = self::clean_file_path( get_template_directory() );
		$file = str_replace( '//', '/', $file );
		$dir  = str_replace( '//', '/', $dir );
		if ( false !== strpos( $file, $dir ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Determine if we're on a child theme.
	 *
	 * @param $file string
	 * @return bool
	 */
	public static function is_child_theme( $file ) {
		$file = self::clean_file_path( $file );
		$dir  = self::clean_file_path( get_stylesheet_directory() );
		$file = str_replace( '//', '/', $file );
		$dir  = str_replace( '//', '/', $dir );
		if ( false !== strpos( $file, $dir ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Determine if we're running as a plugin
	 */
	private static function is_plugin() {
		if ( false !== strpos( self::clean_file_path( __FILE__ ), self::clean_file_path( get_stylesheet_directory() ) ) ) {
			return false;
		}
		if ( false !== strpos( self::clean_file_path( __FILE__ ), self::clean_file_path( get_template_directory_uri() ) ) ) {
			return false;
		}
		if ( false !== strpos( self::clean_file_path( __FILE__ ), self::clean_file_path( WP_CONTENT_DIR . '/themes/' ) ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Determine if we're on a theme
	 *
	 * @param $file string
	 * @return bool
	 */
	public static function is_theme( $file ) {
		if ( true == self::is_child_theme( $file ) || true == self::is_parent_theme( $file ) ) {
			return true;
		}
		return false;
	}
}
