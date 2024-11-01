<?php
/*
 * Plugin Name: SportsPress for Ice Hockey
 * Plugin URI: https://themeboy.com/sportspress-pro/
 * Description: A suite of ice hockey features for SportsPress.
 * Author: ThemeBoy
 * Author URI: https://themeboy.com/
 * Version: 0.9
 *
 * Text Domain: sportspress-for-ice-hockey
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SportsPress_Ice_Hockey' ) ) :

/**
 * Main SportsPress Ice Hockey Class
 *
 * @class SportsPress_Ice_Hockey
 * @version	0.9
 */
class SportsPress_Ice_Hockey {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Define constants
		$this->define_constants();

		// Enqueue scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 30 );

		// Require core
		add_action( 'tgmpa_register', array( $this, 'require_core' ) );

		// Modify text options
		add_filter( 'gettext', array( $this, 'gettext' ), 20, 3 );

		// Define default sport
		add_filter( 'sportspress_default_sport', array( $this, 'default_sport' ) );

		// Include required files
		$this->includes();
	}

	/**
	 * Define constants.
	*/
	private function define_constants() {
		if ( !defined( 'SP_ICE_HOCKEY_VERSION' ) )
			define( 'SP_ICE_HOCKEY_VERSION', '0.9' );

		if ( !defined( 'SP_ICE_HOCKEY_URL' ) )
			define( 'SP_ICE_HOCKEY_URL', plugin_dir_url( __FILE__ ) );

		if ( !defined( 'SP_ICE_HOCKEY_DIR' ) )
			define( 'SP_ICE_HOCKEY_DIR', plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Enqueue styles.
	 */
	public static function admin_enqueue_scripts() {
		wp_enqueue_style( 'sportspress-ice-hockey-admin', SP_ICE_HOCKEY_URL . 'css/admin.css', array( 'sportspress-admin-menu-styles' ), '0.9' );
	}

	/**
	 * Include required files.
	*/
	private function includes() {
		require_once dirname( __FILE__ ) . '/includes/class-tgm-plugin-activation.php';
	}

	/**
	 * Require SportsPress core.
	*/
	public static function require_core() {
		$plugins = array(
			array(
				'name'        => 'SportsPress',
				'slug'        => 'sportspress',
				'required'    => true,
				'version'     => '2.6.20',
				'is_callable' => array( 'SportsPress', 'instance' ),
			),
		);

		$config = array(
			'default_path' => '',
			'menu'         => 'tgmpa-install-plugins',
			'has_notices'  => true,
			'dismissable'  => true,
			'is_automatic' => true,
			'message'      => '',
			'strings'      => array(
				'nag_type' => 'updated'
			)
		);

		tgmpa( $plugins, $config );
	}

	/** 
	 * Text filter.
	 */
	public function gettext( $translated_text, $untranslated_text, $domain ) {
		if ( $domain == 'sportspress' ) {
			switch ( $untranslated_text ) {
				case 'Events':
					$translated_text = __( 'Games', 'sportspress-for-ice-hockey' );
					break;
				case 'Event':
					$translated_text = __( 'Game', 'sportspress-for-ice-hockey' );
					break;
				case 'Add New Event':
					$translated_text = __( 'Add New Game', 'sportspress-for-ice-hockey' );
					break;
				case 'Edit Event':
					$translated_text = __( 'Edit Game', 'sportspress-for-ice-hockey' );
					break;
				case 'View Event':
					$translated_text = __( 'View Game', 'sportspress-for-ice-hockey' );
					break;
				case 'View all events':
					$translated_text = __( 'View all games', 'sportspress-for-ice-hockey' );
					break;
				case 'Venues':
					$translated_text = __( 'Arenas', 'sportspress-for-ice-hockey' );
					break;
				case 'Venue':
					$translated_text = __( 'Arena', 'sportspress-for-ice-hockey' );
					break;
				case 'Edit Venue':
					$translated_text = __( 'Edit Arena', 'sportspress-for-ice-hockey' );
					break;
			}
		}
		
		return $translated_text;
	}

	/**
	 * Define default sport.
	*/
	public function default_sport() {
		return 'volleyball';
	}
}

endif;

new SportsPress_Ice_Hockey();
