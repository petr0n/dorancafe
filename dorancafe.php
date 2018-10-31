<?php
/**
 * Plugin Name:       DoranCafe
 * Description:       Connects Doran websites with RentCafe data
 * Version:           1.0.0
 * Author:            Peter Abeln
 * Author URI:        https://peterskitchen.co
 * Text Domain:       petron
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/2Fwebd/feedier-wordpress

 db user: doranCafeUzr
 db pass: Progress-Likely-Fame-Madden-0

 admin user: mon3yAdm1nUzr
 admin pass: rFA2g2EZ4lt(NO!r0*
 */
 
/*
 * Plugin constants
 */
if(!defined('DORANCAFE_URL'))
	define('DORANCAFE_URL', plugin_dir_url( __FILE__ ));
if(!defined('DORANCAFE_PATH'))
	define('DORANCAFE_PATH', plugin_dir_path( __FILE__ ));




/*
 * Main class
 */

/**
 * Class DoranCafe
 *
 * This class creates the option page and add the web app script
 */
class DoranCafe
{
 
	/**
	 * DoranCafe constructor.
	 *
	 * The main plugin actions registered for WordPress
	 */
	public function __construct()
	{
		// create admin menu item
		add_action( 'admin_menu', array( $this, 'dc_settings_page' ) );
		// include ACF stuff
		include_once( DORANCAFE_PATH . 'vendor/advanced-custom-fields/acf.php' );
		add_filter( 'acf/settings/path', array( $this, 'update_acf_settings_path' ) );
		add_filter( 'acf/settings/dir', array( $this, 'update_acf_settings_dir' ) );

		
		// Includes
		$includes = array_merge(
			glob( DORANCAFE_PATH . 'includes/*.php') // includes
		);

		// Ignore files starting with an underscore
		if( $includes ) {
			foreach( $includes as $include ) {
				$exploded_path = explode('/', $include );
				$filename = end( $exploded_path );
				if ( strpos( $filename, '_') !== 0 ) {
					include_once( $include );
				}
			}
		}


	}
	public function dc_settings_page() {
		// Add the menu item and page
		$page_title = 'DoranCafe Settings Page';
		$menu_title = 'DoranCafe';
		$capability = 'manage_options';
		$slug = DORANCAFE_PATH . 'templates/dc_admin_home.php';
		// $callback = array( $this, 'plugin_settings_page_content' );
		$icon = 'dashicons-admin-plugins';
		$position = 100;

		add_menu_page( $page_title, $menu_title, $capability, $slug, '', $icon, $position );
	}

	public function update_acf_settings_path( $path ) {
		$path = DORANCAFE_PATH . 'vendor/advanced-custom-fields/';
		return $path;
	}

	public function update_acf_settings_dir( $dir ) {
		$dir = DORANCAFE_URL . 'vendor/advanced-custom-fields/';
		return $dir;
	}
}
/*
 * Starts our plugin class, easy!
 */
new DoranCafe();



/**
 * Return global wpdb aready setup with custom tables 
 */
function dc_get_db( wpdb $wpdb = NULL ) {
	static $db;
	if ( is_null($db) || ! is_null( $wpdb ) ) {
		$db = is_null($wpdb) ? $GLOBALS['wpdb'] : $wpdb;
	}
	return $db;
}

/**
 * Setup database saving $wpdb custom table names inside wpdb object
 */
function dc_set_db() {
	global $wpdb;
	/* define custom table names */
	$my_tables = array(
		'dc_floorplans', 'dc_aptavail', 'dc_units'
	);
	foreach ( $my_tables as $table ) {
		$wpdb->$table = $wpdb->prefix . $table;
	}
	dc_get_db( $wpdb );
}
/*
 * to use the global db
 * $db = dc_getDb();
 * $query = $db->query( "SELECT * FROM $db->dc_floorplans" );
 */

 add_action( 'plugins_loaded', 'dc_set_db' );



$dc_properties = array(
	'Property_ID' 			=> '846708',
	'Property_Code' 		=> 'p0851165',
	'Property_Type' 		=> '3',
	'Property_Name' 		=> 'Aria',
	'Property_URL'			=> 'http://www.rentcafe.com/apartments/mn/edina/aria0/index.aspx',
	'Resident_Services_URL' => 'http://www.rentcafe.com/residentservices/aria-0/userlogin.aspx',
	'Apply_Now_URL'	 		=> 'http://www.rentcafe.com/onlineleasing/aria-0/register.aspx',
	'Floorplan_URL'			=> 'http://www.rentcafe.com/onlineleasing/aria-0/floorplans.aspx',
	'Applicant_Portal_URL'  => 'http://www.rentcafe.com/onlineleasing/aria-0/guestlogin.aspx'
);


