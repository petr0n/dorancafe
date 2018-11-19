<?php 
class DoranCafe
{

	/**
	 * DoranCafe constructor.
	 *
	 * The main plugin actions registered for WordPress
	 */
	public function __construct()
	{

		if ( defined( 'DORANCAFE_ALPHA' ) ) {
			$this->version = DORANCAFE_ALPHA;
		} else {
			$this->version = '1.0.0-alpha';
		}

		$this->load_dependencies();

		// create admin menu item
		add_action( 'admin_menu', array( $this, 'dc_settings_page' ) );
		// create admin page
		add_action( 'admin_init', array( $this, 'dc_setup_sections' ) );

		// get js and css
		add_action('admin_init', array( $this, 'dc_load_css' ) );
		add_action('admin_init', array( $this, 'dc_load_scripts' ) );


		// callback for schedule option "job_name" save
		$schedule_services = new DoranCafe_Schedule_Services();
		add_action( 'acf/save_post', array( $schedule_services, 'dc_schedule_options_after_save' ), 1 );
	}


	/*
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		// include ACF stuff
		include_once( DORANCAFE_PATH . 'vendor/advanced-custom-fields-pro/acf.php' );
		add_filter( 'acf/settings/path', array( $this, 'dc_update_acf_settings_path' ) );
		add_filter( 'acf/settings/dir', array( $this, 'dc_update_acf_settings_dir' ) );
		add_action( 'admin_init', 'acf_form_head' );

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once DORANCAFE_PATH . 'includes/dc_class_api_services.php';
		require_once DORANCAFE_PATH . 'includes/dc_class_schedule_services.php';

	}
	public function dc_update_acf_settings_path( $path ) {
		$path = DORANCAFE_PATH . 'vendor/advanced-custom-fields-pro/';
		return $path;
	}

	public function dc_update_acf_settings_dir( $dir ) {
		$dir = DORANCAFE_URL . 'vendor/advanced-custom-fields-pro/';
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
				include_once( DORANCAFE_PATH . 'templates/dc_get_data.php' );
				echo '<br><hr><br>';
				break;
			case 'view_data':
				include_once( DORANCAFE_PATH . 'templates/dc_view_data.php' );
				echo '<br><hr><br>';
				break;
			case 'schedule':
				include_once( DORANCAFE_PATH . 'templates/dc_schedule.php' );
				echo '<br><hr><br>';
				break;
			case 'settings':
				include_once( DORANCAFE_PATH . 'templates/dc_settings.php' );
				break;
				// $this->dc_plugin_setup();
		}
	}

	/**
	 * Load CSS
	 */
	public function dc_load_css() {
		
		if ( WP_DEBUG ) {
			wp_enqueue_style('dc_main', DORANCAFE_URL . '/assets/dist/dc_app.css', array(), false, 'screen');
		} else {
			wp_enqueue_style('dc_main', DORANCAFE_URL . '/assets/dist/app.min.css', array(), false, 'screen');
		}
	}
	
	/**
	 * Load JS
	 */
	public function dc_load_scripts() {
		
		if ( WP_DEBUG ) {
			wp_enqueue_script('dc_main', DORANCAFE_URL . '/assets/dist/dc_app.js', array(), false, true);
		} else {
			wp_enqueue_script('dc_main', DORANCAFE_URL . '/assets/dist/dc_app.min.js', array(), false, true);
		}

		// Dynamic URLs for use in scripts
		wp_localize_script( 'dc_main', 'urls', array(
			'ajax' => admin_url('admin-ajax.php')
		));

	}

	
}
/*
 * Starts our plugin class, easy!
 */
new DoranCafe();





