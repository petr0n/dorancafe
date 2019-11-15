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
 * GitHub Plugin URI: https://github.com/petr0n/dorancafe

 db user: doranCafeUzr
 db pass: Progress-Likely-Fame-Madden-0

 admin user: mon3yAdm1nUzr
 admin pass: rFA2g2EZ4lt(NO!r0*

 */
 

 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// var_dump($_SERVER['REQUEST_URI']);
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
// require DORANCAFE_PATH . 'includes/dc_utils.php';


/** scheduled task to get data from RentCafe API */
add_action( 'DoranCafe_getUnitData', 'dc_get_rentcafe_unit_data' );
function dc_get_rentcafe_unit_data() {
	$dc_admin = new DoranCafe_API_Services( 'DORANCAFE_PLUGIN', '1.0.0-alpha' );
	$dc_admin->dc_get_unit_data();
	wp_mail( 'petron@gmail.com', '[doranaria] Cron Job Run', 'dc_get_unit_data ran successfully');
}




/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dorancafe() {

	$plugin = new Dorancafe();
	$plugin->run();

}
run_dorancafe();
