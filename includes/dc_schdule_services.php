<?php 
/* used to make api calls 
 *
 * dc schedule services
 *	
*/

function dc_get_scheduled_jobs() {
	return 'hello';
}

function dc_create_scheduled_jobs_table() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	//* Create the table
	$db = dc_get_db();
	$sql = "CREATE TABLE IF NOT EXISTS `$db->dc_scheduled_jobs` (
		ScheduledJobTblId INTEGER NOT NULL AUTO_INCREMENT,
		JobName TEXT NOT NULL,
		JobStartDate TIMESTAMP NOT NULL,
		JobEndDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		JobMessages TEXT NOT NULL
		PRIMARY KEY (ScheduledJobTblId)
	) $charset_collate;";
	dbDelta( $sql );
	echo '<br>' . $db->dc_scheduled_jobs . ' table created';
}
