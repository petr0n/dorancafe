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


plugin process flow

1. When user hits dorancafe home -> Are dorancafe base settings entered e.g. propId, name etc.
	a. Yes, display main plugin page -> 
	b. No, show settings page and force set up -> enter propId, name etc. -> once complete take user to plugin home
2. Dorancafe home
	a. Do quick data get
	b. view/edit data get schedule
	c. view apt data
	d. edit settingss

 */
 


 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DORANCAFE_PLUGIN', '1.0.0-alpha' );

/*
 * Plugin constants
 */
if(!defined('DORANCAFE_URL'))
	define('DORANCAFE_URL', plugin_dir_url( __FILE__ ));
if(!defined('DORANCAFE_PATH'))
	define('DORANCAFE_PATH', plugin_dir_path( __FILE__ ));



/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dorancafe-activator.php
 */
function activate_dorancafe() {
	dc_log_me( 'activate_dorancafe started' );
	require_once DORANCAFE_PATH . 'includes/dc_class_activator.php';
	DoranCafe_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dorancafe-deactivator.php
 */
function deactivate_dorancafe() {
	require_once DORANCAFE_PATH . 'includes/dc_class_deactivator.php';
	DoranCafe_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dorancafe' );
register_deactivation_hook( __FILE__, 'deactivate_dorancafe' );




/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require DORANCAFE_PATH . 'includes/dc_class_dorancafe.php';


/*
 * utils functions
 */
require DORANCAFE_PATH . 'includes/dc_utils.php';






/**
 * Class DoranCafe
 *
 * This class creates the option page and add the web app script

class DoranCafe
{
 
	/**
	 * DoranCafe constructor.
	 *
	 * The main plugin actions registered for WordPress
	
	public function __construct()
	{
		// create admin menu item
		add_action( 'admin_menu', array( $this, 'dc_settings_page' ) );
		add_action( 'admin_init', array( $this, 'dc_add_acf_variables' ) );
		
		// include ACF stuff
		add_filter( 'acf/settings/path', array( $this, 'dc_update_acf_settings_path' ) );
		add_filter( 'acf/settings/dir', array( $this, 'dc_update_acf_settings_dir' ) );
		include_once( DORANCAFE_PATH . 'vendor/advanced-custom-fields-pro/acf.php' );

		// create admin page
		add_action( 'admin_init', array( $this, 'dc_setup_sections' ) );
		
		// setup cron job
		add_action( 'admin_init', array( $this, 'dc_plugin_schedule_cron' ) );
		add_filter( 'cron_schedules', array( $this, 'dc_plugin_cron_add_intervals') );

		// callback for schedule option "job_name" save
		add_action( 'acf/save_post', array( $this, 'dc_schedule_options_after_save' ), 1 );
		
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

	public function dc_update_acf_settings_path( $path ) {
		$path = DORANCAFE_PATH . 'vendor/advanced-custom-fields-pro/';
		return $path;
	}

	public function dc_update_acf_settings_dir( $dir ) {
		$dir = DORANCAFE_URL . 'vendor/advanced-custom-fields-pro/';
		return $dir;
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
		// check for propid and name
		if ( get_field( 'property_id', 'option' ) && get_field( 'property_name', 'option' ) ) {
			$this->dc_plugin_settings();
		} else {
			$this->dc_plugin_setup();
		}
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

	public function dc_add_acf_variables() {
		acf_form_head();
	}

	public function dc_plugin_schedule_cron() {
		// dc_create_scheduled_jobs_table();
		// $this->dc_log_me( 'dc_plugin_schedule_cron run' );
		// if ( !wp_next_scheduled( 'dc_scheduled_jobs' ) )
		// 	wp_schedule_event(time(), 'dc_customTime', 'dc_scheduled_jobs');
	}
	
	public function dc_plugin_cron_add_intervals( $schedules ) {
		$schedules['dc_customTime'] = array(
			'interval' => 60,
			'display' => __('Every 60sec')
		);
		return $schedules;
	}

	public function dc_log_me( $contents ){
		$file = DORANCAFE_PATH . 'logs/log.txt';
		$right_now = (new DateTime())->format('Ymd H:i:s');
		$new_contents =  $right_now . ' - ' . $contents . PHP_EOL;
		file_put_contents($file, $new_contents, FILE_APPEND);
	}


	public function dc_schedule_options_after_save( $post_id ) {
		$jobname = get_field('job_name', $post_id);
		$old_jobname = $_POST['acf']['field_5be1fcd41f1ec'];
		$jobtime = get_field('start_time', $post_id);
		$old_jobtime = $_POST['acf']['field_5be1fd661f1ed'];
		$jobemails = get_field('email_notifications_to');
		$old_jobemails = $_POST['acf']['field_5be1fdac1f1ee'];

		if ( $jobname != $old_jobname || 
			 $jobtime != $old_jobtime || 
			 $jobemails != $old_jobemails ) {
			$this->dc_log_me( 'name: ' . $jobname . ' old: ' . $old_jobname);
			// dc_add_cron_job( $jobname, $jobtime, $jobemails );
			dc_delete_schedule_job();
		}
	}
	
}
/*
 * Starts our plugin class, easy!
 
new DoranCafe();



 */


// not in use for now
// $dc_properties = array(
// 	'Property_ID' 			=> '846708',
// 	'Property_Code' 		=> 'p0851165',
// 	'Property_Type' 		=> '3',
// 	'Property_Name' 		=> 'Aria',
// 	'Property_URL'			=> 'http://www.rentcafe.com/apartments/mn/edina/aria0/index.aspx',
// 	'Resident_Services_URL' => 'http://www.rentcafe.com/residentservices/aria-0/userlogin.aspx',
// 	'Apply_Now_URL'	 		=> 'http://www.rentcafe.com/onlineleasing/aria-0/register.aspx',
// 	'Floorplan_URL'			=> 'http://www.rentcafe.com/onlineleasing/aria-0/floorplans.aspx',
// 	'Applicant_Portal_URL'  => 'http://www.rentcafe.com/onlineleasing/aria-0/guestlogin.aspx'
// );


