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

		// include ACF stuff
		include_once( DORANCAFE_PATH . 'admin/vendor/advanced-custom-fields-pro/acf.php' );
		add_filter( 'acf/settings/path', array( $this, 'dc_update_acf_settings_path' ) );
		add_filter( 'acf/settings/dir', array( $this, 'dc_update_acf_settings_dir' ) );
		add_action( 'admin_init', 'acf_form_head' );

		// get js and css
		add_action('admin_init', array( $this, 'dc_admin_load_assets' ) );

		// create admin menu item
		add_action( 'admin_menu', array( $this, 'dc_settings_page' ) );
		// create admin page
		add_action( 'admin_init', array( $this, 'dc_setup_sections' ) );


		// callback for schedule option "job_name" save
		// $schedule_services = new DoranCafe_Schedule_Services();
		// add_action( 'acf/save_post', array( $schedule_services, 'dc_schedule_options_after_save' ), 1 );
		
		$api_services = new DoranCafe_API_services();
		add_action('wp_ajax_nopriv_dc_get_unit_data', array( $api_services, 'dc_get_unit_data'));
		add_action('wp_ajax_dc_get_unit_data', array( $api_services,'dc_get_unit_data'));

		add_action('wp_ajax_nopriv_dc_create_upload_form', array( $this, 'dc_create_upload_form'));
		add_action('wp_ajax_dc_create_upload_form', array( $this,'dc_create_upload_form'));

		// add_filter('acf/update_value', array( $this, 'dc_update_unit_pdf' ), 10, 3);
	}

	/**
	 * Register the stylesheets for the admin-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function dc_admin_load_assets() {
		wp_enqueue_media();
		wp_enqueue_style( 'dorancafe_admin_style', DORANCAFE_URL . 'admin/dist/dc_app.css', array(), $this->version, 'all' );
		wp_enqueue_script( 'dorancafe_admin_script', DORANCAFE_URL . 'admin/dist/dc_app.js', array(), $this->version, true );

		// Dynamic URLs for use in scripts
		wp_localize_script( $this->plugin_name, 'urls', array(
			'ajax' => admin_url('admin-ajax.php')
		));
	}

	public function dc_admin_load_dependencies() {

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
						'return' => admin_url('admin.php?page=dorancafe&setup=complete'),
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
				<div class="col-md-12">
					<h1>DoranCafe Plugin</h1>
				</div>
			</div>
		</div>
		<div class="container dc-tabs">
			<div class="row">
				<div class="col-md-12">
					<div class="tabs">
						<a href="view-units" class="active">View Units</a>
						<!-- <a href="get-units">Get Units</a> -->
						<a href="schedule">Schedule</a>
						<a href="settings">Plugin Settings</a>
					</div>
					<div class="tab-panels"><?php
						settings_fields( 'dorancafe' );
						do_settings_sections( 'dorancafe' ); ?>
					</div>
				</div>
			</div>
		</div> <?php 
	}


	public function dc_setup_sections() {
		add_settings_section( 'view_data', '', array( $this, 'dc_section_callback' ), 'dorancafe' );
		// add_settings_section( 'check_data', '', array( $this, 'dc_section_callback' ), 'dorancafe' );
		add_settings_section( 'schedule', '', array( $this, 'dc_section_callback' ), 'dorancafe' );
		add_settings_section( 'settings', '', array( $this, 'dc_section_callback' ), 'dorancafe' );
	}

	public function dc_section_callback( $arguments ) {
		do_action('acf/input/admin_head'); // Add ACF admin head hooks
		do_action('acf/input/admin_enqueue_scripts'); // Add ACF scripts
		switch( $arguments['id'] ){
			// case 'check_data':
			// 	echo '<div class="get-units panel">';
			// 	include_once( DORANCAFE_PATH . 'admin/templates/dc_get_units.php' );
			// 	echo '</div>';
			// 	break;
			case 'view_data':
				echo '<div class="view-units panel">';
				include_once( DORANCAFE_PATH . 'admin/templates/dc_view_units.php' );
				echo '</div>';
				break;
			case 'schedule':
				echo '<div class="schedule panel">';
				include_once( DORANCAFE_PATH . 'admin/templates/dc_schedule.php' );
				echo '</div>';
				break;
			case 'settings':
				echo '<div class="settings panel">';
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

	public function dc_create_upload_form(  ){
		$form_id = $_POST['form_id'];
		if ( $form_id ) {
			$form_options = array(
				'id' => 'dc_schedule_form_' . $form_id,
				'post_id' => 'options',
				'new_post' => false,
				'uploader' => 'wp',
				'field_groups' => array( '28' ),
				'return' => admin_url('admin.php?page=dorancafe&form=uploader'),
				'submit_value' => 'Update'
			);
			// echo $form_id;
			acf_form( $form_options );
		}
		die();
	}

	public function dc_update_unit_pdf($value, $post_id, $field){
		if (isset($_POST['acf']['field_5c069f3b37b93'])) {
			$unit_pdf = $_POST['acf']['field_5c069f3b37b93']; // unit_pdf post id
			$unit_pdf_url = wp_get_attachment_url( $unit_pdf );
			if ( $unit_pdf_url ) {
				$apt_id = $_POST['acf']['field_5c085ee2c814f']; // apt_id
				global $wpdb;
				$tbl_name  = $wpdb->prefix . 'dc_aptavail';
				$wpdb->query( 
					$wpdb->prepare("UPDATE `${tbl_name}`
					SET UnitPDF = %s 
					WHERE AptAvailTblId = %s" , $unit_pdf_url, $apt_id)
				);
			}
		}
	}

}
$Dorancafe_admin = new Dorancafe_Admin( 'DORANCAFE_PLUGIN', '1.0.0-alpha' );

