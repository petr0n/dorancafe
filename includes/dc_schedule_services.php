<?php 
/* used to make api calls 
 *
 * dc schedule services
 *	
*/


// the CRON hook for firing function
add_action('dc_scheduled_job', 'dc_plugin_cron_function');

// the actual function
function dc_plugin_cron_function() {
	// see if fires via email notification
	wp_mail('petron@gmail.com','Cron Worked', date('r'));
	$dc_class->dc_log_me( 'dc_plugin_cron_function run' );
}

function dc_get_scheduled_job() {
	// $dc_class = new DoranCafe();
	// $dc_class->dc_log_me( 'dc_get_scheduled_jobs run' );
	// $current_job = get_field('job_name', 'options');
	// $schedule = wp_get_schedule( $current_job );
	// echo $schedule;
	// var_dump( $current_job );
	// $schedule = wp_get_schedule( 'dc_scheduled_jobs' );
	// $dc_my_job = array_search( $schedule, $wp_cron_jobs );
	// // echo $schedule;
	// var_dump( $wp_cron_jobs[$schedule] );

	$wp_cron_jobs = get_option( 'cron' );
	var_dump( $wp_cron_jobs );
	$next_time = wp_next_scheduled( 'dc_scheduled_job' );
	echo 'dc_get_scheduled_job run<br>';
	echo $next_time . '<br>';
	if ( $next_time ) {
		echo 'job exists<br>';
		echo date('m/d/Y H:i:s', $next_time);
	} else {
		echo 'job does not exist<br>';
	}
}

function dc_delete_schedule_job() {
	$timestamp = wp_next_scheduled( 'dc_scheduled_jobs' );
	wp_unschedule_event( $timestamp, 'dc_scheduled_jobs' );
	echo 'dc_scheduled_job deleted';
}

// function dc_add_cron_job(){
// 	// delete old job and add new job 
// 	$dc_class = new DoranCafe();
// 	$dc_class->dc_log_me( 'dc_add_cron_job run - current_time( "timestamp" ): ' . (current_time( 'timestamp' )) . ' - dc_get_units_scheduled_job');
// 	wp_schedule_single_event( current_time( 'timestamp' ), 'dc_get_units_scheduled_job' );
// }

// function dc_run_schedule_job() { // run the job: get unit data 
// 	$dc_class = new DoranCafe();
// 	$dc_class->dc_log_me( 'dc_run_schedule_job run');
// 	dc_get_unit_data();
// }
// add_action( 'dc_get_units_scheduled_job','dc_run_schedule_job' );

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
		JobMessages TEXT NOT NULL,
		PRIMARY KEY (ScheduledJobTblId)
	) $charset_collate;";
	dbDelta( $sql );
	//echo '<br>' . $db->dc_scheduled_jobs . ' table created';
}


