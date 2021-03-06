<?php


namespace DoranCafePlugin;

/**
 * Fired during plugin activation
 *
 * @link       http://peterskitchen.co
 * @since      1.0.0
 *
 * @package    Dorancafe
 * @subpackage Dorancafe/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.1.0
 * @package    Dorancafe
 * @subpackage Dorancafe/includes
 * @author     Peter Abeln <petron@gmail.com>
 */
class DoranCafe_Activator {

	/**
	 * Creates tables.
	 *
	 * Checks to see if plugin tables exists and creates them if not.
	 *
	 * @since    0.1.0
	 */
	public static function activate() {

		// dc_log_me( 'DoranCafe_Activator started' );
		// create tables if not exist
		// self::dc_create_floorplan_table(); don't think this is needed
		self::dc_create_aptavail_table();
		self::dc_create_scheduled_jobs_table();
		self::dc_create_unit_files_table();
		self::dc_create_settings_table();


		// $dc_api_services = new DoranCafe_API_Services();
		// pull down data, save as text and insert into new tables
		// $dc_api_services->dc_get_unit_data();

	}


	private static function dc_create_floorplan_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$tbl_name = $wpdb->prefix . 'dc_floorplans';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		//* Create the table
		$sql = "CREATE TABLE IF NOT EXISTS `${tbl_name}` (
			FloorplanTblId INTEGER NOT NULL AUTO_INCREMENT,
			PropertyId INTEGER NOT NULL,
			FloorplanId TEXT NOT NULL,
			FloorplanName TEXT NOT NULL,
			Beds INTEGER NOT NULL,
			Baths FLOAT(10,1) NOT NULL,
			MinimumSQFT INTEGER NOT NULL,
			MaximumSQFT INTEGER NOT NULL,
			MinimumRent INTEGER NOT NULL,
			MaximumRent INTEGER NOT NULL,
			MinimumDeposit NUMERIC NOT NULL,
			MaximumDeposit NUMERIC NOT NULL,
			AvailableUnitsCount INTEGER NOT NULL,
			AvailabilityURL TEXT NOT NULL,
			FloorplanImageURL TEXT NOT NULL,
			FloorplanImageName TEXT NOT NULL,
			PropertyShowsSpecials TEXT NOT NULL,
			FloorplanHasSpecials TEXT NOT NULL,
			UnitTypeMapping TEXT NOT NULL,
			PRIMARY KEY (FloorplanTblId)
		) $charset_collate;";
		dbDelta( $sql );
		// dc_log_me( 'dc_floorplans table created' );
	}

	private static function dc_create_settings_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$tbl_name = $wpdb->prefix . 'dc_settings';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		//* Create the table
		$sql = "CREATE TABLE IF NOT EXISTS `${tbl_name}` (
			SettingId INTEGER NOT NULL AUTO_INCREMENT,
			EndpointUrl TEXT NOT NULL,
			FetchDataTime TEXT NOT NULL,
			PRIMARY KEY (SettingId)
		) $charset_collate;";
		dbDelta( $sql );
		// dc_log_me( 'dc_settings table created' );
	}



	private static function dc_create_aptavail_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$tbl_name = $wpdb->prefix . 'dc_aptavail';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		//* Create the table
		$sql = "CREATE TABLE IF NOT EXISTS `${tbl_name}` (
			AptAvailTblId INTEGER NOT NULL AUTO_INCREMENT,
			PropertyId INTEGER NOT NULL,
			VoyagerPropertyId INTEGER NOT NULL,
			VoyagerPropertyCode INTEGER NOT NULL,
			FloorplanId INTEGER NOT NULL,
			FloorplanName TEXT NOT NULL,
			ApartmentId INTEGER NOT NULL,
			ApartmentName INTEGER NOT NULL,
			Beds NUMERIC NOT NULL,
			Baths NUMERIC NOT NULL,
			SQFT NUMERIC NOT NULL,
			MinimumRent NUMERIC NOT NULL,
			MaximumRent NUMERIC NOT NULL,
			Deposit NUMERIC,
			ApplyOnlineURL TEXT NOT NULL,
			UnitImageURLs TEXT NOT NULL,
			Specials TEXT,
			Amenities TEXT NOT NULL,
			AvailableDate TEXT NOT NULL,
			UnitPDF TEXT NULL,
			PRIMARY KEY (AptAvailTblId)
		) $charset_collate;";
		dbDelta( $sql );
		// dc_log_me( 'dc_aptavail table created' );
	}


	private static function dc_create_unit_files_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$tbl_name = $wpdb->prefix . 'dc_unit_files';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		//* Create the table
		$sql = "CREATE TABLE IF NOT EXISTS `${tbl_name}` (
			UnitFilesId INTEGER NOT NULL AUTO_INCREMENT,
			FileName TEXT NOT NULL,
			ApartmentName INTEGER NOT NULL,
			PRIMARY KEY (UnitFilesId)
		) $charset_collate;";
		dbDelta( $sql );
		// dc_log_me( 'dc_unit_files table created' );
	}


	private static function dc_create_scheduled_jobs_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$tbl_name = $wpdb->prefix . 'dc_scheduled_jobs';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		//* Create the table
		$sql = "CREATE TABLE IF NOT EXISTS `${tbl_name}` (
			ScheduledJobTblId INTEGER NOT NULL AUTO_INCREMENT,
			JobName TEXT NOT NULL,
			JobStartDate TIMESTAMP NOT NULL,
			JobEndDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			JobMessages TEXT NOT NULL,
			PRIMARY KEY (ScheduledJobTblId)
		) $charset_collate;";
		dbDelta( $sql );
		// dc_log_me( 'dc_scheduled_jobs table created' );
	}

}
