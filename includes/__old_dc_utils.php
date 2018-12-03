<?php 


/**
 * Return global wpdb aready setup with custom tables 
 */
function dc_get_db( wpdb $wpdb = NULL ) {
	static $db;
	if ( is_null($db) || ! is_null( $wpdb ) ) {
		$db = is_null($wpdb) ? $GLOBALS['wpdb'] : $wpdb;
	}
	return $db;
}

/*
 * Setup database saving $wpdb custom table names inside wpdb object
 * to use the global db
 * $db = dc_getDb();
 * $query = $db->query( "SELECT * FROM $db->dc_floorplans" );
 */
function dc_set_db() {
	global $wpdb;
	/* define custom table names */
	$my_tables = array(
		'dc_floorplans', 'dc_aptavail', 'dc_scheduled_jobs'
	);
	foreach ( $my_tables as $table ) {
		$wpdb->$table = $wpdb->prefix . $table;
	}
	dc_get_db( $wpdb );
}
add_action( 'init', 'dc_set_db' );


 ?>