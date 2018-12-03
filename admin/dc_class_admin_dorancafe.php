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
 *
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

		// get js and css
		add_action('admin_init', array( $this, 'dc_admin_load_assets' ) );

		// create admin menu item
		add_action( 'admin_menu', array( $this, 'dc_settings_page' ) );
		// create admin page
		add_action( 'admin_init', array( $this, 'dc_setup_sections' ) );


		// callback for schedule option "job_name" save
		$schedule_services = new DoranCafe_Schedule_Services();
		add_action( 'acf/save_post', array( $schedule_services, 'dc_schedule_options_after_save' ), 1 );
		
		add_action( 'wp_ajax_dc_get_unit_data', 'dc_get_unit_data' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function dc_admin_load_assets() {
		wp_enqueue_style( $this->plugin_name, DORANCAFE_URL . 'admin/dist/dc_app.css', array(), $this->version, 'all' );
		wp_enqueue_script( $this->plugin_name, DORANCAFE_URL . 'admin/dist/dc_app.js', array(), $this->version, false );

		// Dynamic URLs for use in scripts
		wp_localize_script( $this->plugin_name, 'urls', array(
			'ajax' => admin_url('admin-ajax.php')
		));
	}

	public function dc_admin_load_dependencies() {
		// include ACF stuff
		include_once( DORANCAFE_PATH . 'admin/vendor/advanced-custom-fields-pro/acf.php' );
		add_filter( 'acf/settings/path', array( $this, 'dc_update_acf_settings_path' ) );
		add_filter( 'acf/settings/dir', array( $this, 'dc_update_acf_settings_dir' ) );
		add_action( 'admin_init', 'acf_form_head' );

		require_once DORANCAFE_PATH . 'admin/dc_class_api_services.php';
		require_once DORANCAFE_PATH . 'admin/dc_class_schedule_services.php';

	}

	public function dc_update_acf_settings_path( $path ) {
		$path = DORANCAFE_PATH . 'admin/vendor/advanced-custom-fields-pro/';
		return $path;
	}

	public function dc_update_acf_settings_dir( $dir ) {
		$dir = DORANCAFE_URL . 'admin/vendor/advanced-custom-fields-pro/';
		return $dir;
	}

	public function dc_plugin_init() {
		// check for propid and name
		if ( get_field( 'property_id', 'option' ) && get_field( 'property_name', 'option' ) ) {
			$this->dc_plugin_settings();
		} else {
			$this->dc_plugin_setup();
		}
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


	public function dc_plugin_setup() {	?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2>DoranCafe Settings Page</h2><?php 
					if ( !get_field( 'property_id', 'option' ) || !get_field( 'property_name', 'option' ) ) : ?>
						<p>Please set up the property to get started</p><?php 
					endif;
					$first_options = array(
						'id' => 'dc_base_options_form',
						'post_id' => 'options',
						'new_post' => false,
						'field_groups' => array( '12' ),
						'return' => admin_url('admin.php?page=dorancafe&form=base'),
						'submit_value' => 'Update',
					);
					acf_form( $first_options );
					echo '<hr>';					
					$schedule_options = array(
						'id' => 'dc_schedule_form',
						'post_id' => 'options',
						'new_post' => false,
						'field_groups' => array( '23' ),
						'return' => admin_url('admin.php?page=dorancafe&form=schedule'),
						'submit_value' => 'Update',
						'instruction_placement' => 'field',
					);
					acf_form( $schedule_options );  ?>
				</div>
			</div>
		</div> <?php 
	}

	public function dc_plugin_settings() { ?>
		<div class="container">
			<div class="row">
				<div class="col-md-12"><?php
					settings_fields( 'dorancafe' );
					do_settings_sections( 'dorancafe' ); ?>
				</div>
			</div>
		</div> <?php 
	}


	public function dc_setup_sections() {
		add_settings_section( 'check_data', 'Check Data', array( $this, 'dc_section_callback' ), 'dorancafe' );
		add_settings_section( 'view_data', 'View Data', array( $this, 'dc_section_callback' ), 'dorancafe' );
		add_settings_section( 'schedule', 'Schedule', array( $this, 'dc_section_callback' ), 'dorancafe' );
		add_settings_section( 'settings', 'Settings', array( $this, 'dc_section_callback' ), 'dorancafe' );
	}

	public function dc_section_callback( $arguments ) {
		do_action('acf/input/admin_head'); // Add ACF admin head hooks
		do_action('acf/input/admin_enqueue_scripts'); // Add ACF scripts
		switch( $arguments['id'] ){
			case 'check_data':
				include_once( DORANCAFE_PATH . 'admin/templates/dc_get_data.php' );
				echo '<br><hr><br>';
				break;
			case 'view_data':
				include_once( DORANCAFE_PATH . 'admin/templates/dc_view_data.php' );
				echo '<br><hr><br>';
				break;
			case 'schedule':
				include_once( DORANCAFE_PATH . 'admin/templates/dc_schedule.php' );
				echo '<br><hr><br>';
				break;
			case 'settings':
				include_once( DORANCAFE_PATH . 'admin/templates/dc_settings.php' );
				break;
				// $this->dc_plugin_setup();
		}
	}

	// next step is to loop through each unique floor plan and insert each unique unit into dc_units

	public function dc_get_units() {
		// loop through grouped floorplans
		global $wpdb;
		$tbl_name = $wpdb->prefix . 'dc_aptavail';
		$unit_qry = "
			SELECT * 
			FROM ${tbl_name}
			ORDER BY ApartmentName
		"; 
		$units = $wpdb->get_results( $unit_qry, OBJECT );
		// var_dump( $units );
		return $units;
	}

}
$Dorancafe_admin = new Dorancafe_Admin( 'DORANCAFE_PLUGIN', '1.0.0-alpha' );

