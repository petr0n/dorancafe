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

		if ( defined( 'DORANCAFE_PLUGIN' ) ) {
			$this->version = DORANCAFE_PLUGIN;
		} else {
			$this->version = '1.0.0-alpha';
		}
		$this->plugin_name = 'dorancafe';

		$this->dc_load_dependencies();
	
	}

	/*
	 * @since    1.0.0
	 * @access   private
	 */
	private function dc_load_dependencies() {
		// admin class and functions
		require_once DORANCAFE_PATH . 'admin/dc_class_admin_dorancafe.php';
		// public class and functions
		require_once DORANCAFE_PATH . 'public/dc_class_public_dorancafe.php';
	}


		/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}


	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	
}
/*
 * Starts our plugin class, easy!
 */
new DoranCafe();





