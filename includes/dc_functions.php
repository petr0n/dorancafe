<?php



/**
 * Load CSS
 */
function dc_load_css() {
	wp_register_style('dc_main', DORANCAFE_URL . '/assets/dist/dc_app.css');
	if ( WP_DEBUG ) {
		wp_enqueue_style('dc_main', DORANCAFE_URL . '/assets/dist/dc_app.css', array(), false, 'screen');
	} else {
		wp_enqueue_style('dc_main', DORANCAFE_URL . '/assets/dist/app.min.css', array(), false, 'screen');
	}
}
add_action('admin_init', 'dc_load_css');

/**
 * Load JS
 */
function dc_load_scripts() {
	
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
add_action('admin_init', 'dc_load_scripts');


