<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://peterskitchen.co
 * @since      1.0.0
 *
 * @package    Dorancafe
 * @subpackage Dorancafe/admin
 */

/**
 * The admin-specific functionality of the plugin.
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dorancafe
 * @subpackage Dorancafe/admin
 * @author     Peter Abeln <petron@gmail.com>
 */


class DoranCafe_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->dc_admin_load_dependencies();
		// $dc_insert_settings = $this->dc_insert_settings();


		// create admin menu item
		add_action( 'admin_menu', array( $this, 'dc_settings_page' ) );

		
		$api_services = new DoranCafe_API_services();
		// get unit data from rentcafe
		add_action('wp_ajax_nopriv_dc_get_unit_data', array( $api_services, 'dc_get_unit_data'));
		add_action('wp_ajax_dc_get_unit_data', array( $api_services,'dc_get_unit_data'));

		// load unit data into admin page
		add_action('wp_ajax_nopriv_dc_get_units_ajax', array( $this, 'dc_get_units_ajax'));
		add_action('wp_ajax_dc_get_units_ajax', array( $this,'dc_get_units_ajax')); 

		add_action('wp_ajax_nopriv_dc_save_file', array( $this, 'dc_save_file'));
		add_action('wp_ajax_dc_save_file', array( $this,'dc_save_file'));

		// insert settings
		add_action( 'admin_post_nopriv_insert_settings', array( $this, 'dc_insert_settings' ));
		add_action( 'admin_post_insert_settings', array( $this, 'dc_insert_settings' ));

		// update settings
		add_action( 'admin_post_nopriv_update_settings', array( $this, 'dc_update_settings' ));
		add_action( 'admin_post_update_settings', array( $this, 'dc_update_settings' ));
	}



	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function dc_enqueue_styles() {
		wp_enqueue_media();
		wp_enqueue_style( $this->plugin_name, DORANCAFE_URL . 'admin/dist/dc_app.css', array(), $this->version, 'all' );	
	}
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function dc_enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, DORANCAFE_URL . 'admin/dist/dc_app.js', array(), $this->version, true );

		// Dynamic URLs for use in scripts
		wp_localize_script( $this->plugin_name, 'urls', array(
			'ajax' => admin_url('admin-ajax.php')
		));
	}


	public function dc_settings_page() {
		// Add the menu item and page
		$page_title = 'DoranCafe Settings Page';
		$menu_title = 'DoranCafe';
		$capability = 'manage_options';
		$slug = 'dorancafe';
		$callback = array( $this, 'dc_plugin_init' );
		$icon = 'dashicons-admin-plugins';
		$position = 100;

		add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
	}

	public function dc_plugin_init() {
		$dc_settings = $this->dc_get_settings();
		if ( $dc_settings[0]->EndpointUrl != '' ) {
			$this->dc_plugin_settings($dc_settings);
		} else {
			$this->dc_plugin_setup($dc_settingsd);
		}
	}

	public function dc_plugin_setup($dc_settings) {	
		include_once DORANCAFE_PATH . 'admin/templates/dc_settings.php';
	}

	public function dc_plugin_settings($dc_settings) { ?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>DoranCafe Plugin</h1>
				</div>
			</div>
		</div>
		<div class="container dc_tabs">
			<div class="row">
				<div class="col-md-12">
					<div class="dc_tabs">
						<a href="dc_view-units" class="active">View Units <i class="fas fa-table"></i></a>
						<a href="dc_settings">Plugin Settings <i class="fas fa-cogs"></i></a>
					</div>
					<div class="dc_tab-panels">
						<div class="dc_view-units panel"><?php 
							include( DORANCAFE_PATH . 'admin/templates/dc_view_units.php' ); ?>
						</div>
						<div class="dc_settings panel"><?php 
							include( DORANCAFE_PATH . 'admin/templates/dc_settings.php' );  ?>
						</div>
					</div>
				</div>
			</div>
		</div><?php 
	}
	


	public function dc_admin_load_dependencies() {
		require_once DORANCAFE_PATH . 'admin/dc_class_api_services.php';
		// require_once DORANCAFE_PATH . 'admin/dc_class_schedule_services.php';
	}

	public function dc_get_settings() {
		global $wpdb;
		$settings_qry = " 
			SELECT *
			FROM wp_dc_settings
			LIMIT 1";
		$settings = $wpdb->get_results( $settings_qry, OBJECT );
		// var_dump( $units );
		return $settings;
	}

	public function dc_update_settings() {
		if (isset($_POST['EndpointUrl']) &&
			isset($_POST['FetchDataTime']) &&
			isset($_POST['SettingId'])) {
			global $wpdb;
			$settings_qry = 'UPDATE wp_dc_settings SET ';  
			$settings_qry .= 'EndpointUrl = "' . $_POST['EndpointUrl'] . '"';
			$settings_qry .= ', FetchDataTime = "' . $_POST['FetchDataTime'] . '"';
			$settings_qry .= ' WHERE SettingId = ' . $_POST['SettingId'];
			$settings = $wpdb->query( $settings_qry, OBJECT );
		} else {

		}
	}
	public function dc_insert_settings() {
		if ( isset($_POST['EndpointUrl']) &&
			isset($_POST['FetchDataTime']) ) {
			global $wpdb;
			$settings_qry = 'INSERT INTO wp_dc_settings ';  
			$settings_qry .= '(EndpointUrl, FetchDataTime) ';
			$settings_qry .= 'VALUES ("' . $_POST['EndpointUrl'] . '","' . $_POST['FetchDataTime'] . '")';
			$settings = $wpdb->query( $settings_qry, OBJECT );
		}
	}
	

	public function dc_get_units() {
		global $wpdb;
		$tbl_apt = $wpdb->prefix . 'dc_aptavail';
		$tbl_file  = $wpdb->prefix . 'dc_unit_files';
		$unit_qry = "SELECT 
			AptAvailTblId, 
			PropertyId, 
			VoyagerPropertyId, 
			VoyagerPropertyCode, 
			FloorplanId, 
			FloorplanName, 
			ApartmentId, 
			a.ApartmentName as unitnum, 
			Beds, 
			Baths, 
			SQFT, 
			MinimumRent, 
			MaximumRent, 
			Deposit, 
			ApplyOnlineURL, 
			UnitImageURLs, 
			Specials, 
			Amenities, 
			AvailableDate, 
			UnitPDF,
			f.FileName
			FROM wp_dc_aptavail as a
				LEFT JOIN wp_dc_unit_files as f 
					ON a.ApartmentName = f.ApartmentName
			ORDER BY a.ApartmentName";
		$units = $wpdb->get_results( $unit_qry, OBJECT );
		// var_dump( $units );
		return $units;
	}

	public function dc_get_units_ajax(){
		include DORANCAFE_PATH . 'admin/partials/unit-table.php';
	}

	public function dc_save_file(){
		if (isset($_POST['apt_num']) && 
			isset($_POST['file_name']) ) {
			$ApartmentName = sanitize_text_field($_POST['apt_num']);
			$FileName = sanitize_text_field($_POST['file_name']);
			global $wpdb;
			$tbl_name  = $wpdb->prefix . 'dc_unit_files';

			// delete existing
			$delete = $wpdb->query('DELETE FROM ' . $tbl_name . ' WHERE ApartmentName =' . $ApartmentName ); 

			// insert new
			$wpdb->insert($tbl_name, array( 
				"ApartmentName" 	=> $ApartmentName,
				"FileName" 			=> $FileName
			));
			// echo 'success';
		} else {
			// echo 'missing!';
		}
		wp_die();
	}


	public function get_updated_date(){
		$path_to_file = DORANCAFE_PATH . 'rentcafe_data/aptavail/';
		$files = scandir( $path_to_file, SCANDIR_SORT_DESCENDING );
		$newest_file = $path_to_file . $files[0];
		if (file_exists($newest_file)) {
			echo date ("F d Y H:i:s", filemtime($newest_file));
		}
	}

}

