<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://peterskitchen.co
 * @since      1.0.0
 *
 * @package    Dorancafe
 * @subpackage Dorancafe/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Dorancafe
 * @subpackage Dorancafe/includes
 * @author     Peter Abeln <petron@gmail.com>
 */
class DoranCafe_Deactivator {

	/**
	 * DoranCafe constructor.
	 *
	 * The main plugin actions registered for WordPress
	 */
	public function __construct() {
		
	}

	public static function deactivate() {
		//self::dc_delete_floorplans_data();
		self::dc_delete_aptavail_data();
	}

	// private function dc_delete_floorplans_data(){
	// 	global $wpdb;
	// 	$tbl_name = $wpdb->prefix . 'dc_floorplans';
	// 	$delete = $wpdb->query('TRUNCATE TABLE ' . $tbl_name); //delete data first
	// } 
	
	private function dc_delete_aptavail_data(){
		global $wpdb;
		$tbl_name = $wpdb->prefix . 'dc_aptavail';
		$delete = $wpdb->query('TRUNCATE TABLE ' . $tbl_name); //delete data first
	} 


}
