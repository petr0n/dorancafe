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
		// $this->deactivate();
		dc_plugin_message_delete();

	}

	public static function deactivate() {
		self::deleteFloorPlansData();
		self::deleteAptAvailData();
		$dc_options = array(
			'rentcafe_api_endpoint',
			'property_id',
			'property_name',
			'company_code',
			'api_aptavailable_url_api_token',
			'api_floorplan_url_api_token'
		);
		foreach ($dc_options as $dc_option) {
			if (get_field($dc_option, 'options')) {
				delete_field($dc_option, 'options');
			}
		}
	}

	private function deleteFloorPlansData(){
		global $wpdb;
		$tbl_name = $wpdb->prefix . 'dc_floorplans';
		$delete = $wpdb->query('TRUNCATE TABLE ' . $tbl_name); //delete data first
	} 
	
	private function deleteAptAvailData(){
		global $wpdb;
		$tbl_name = $wpdb->prefix . 'dc_aptavail';
		$delete = $wpdb->query('TRUNCATE TABLE ' . $tbl_name); //delete data first
	} 


}
