<?php 
/* 
 *
 * dc schedule services
 *	
*/


class DoranCafe_Schedule_Services
{
	/**
	 * DoranCafe_Schedule Services constructor.
	 *
	 * The schedule actions registered for this plugin
	 */
	public function __construct()
	{
		add_action( 'wp_ajax_dc_delete_schedule_job', 'dc_delete_schedule_job' );

		// the CRON hook for firing function
		add_action('dc_scheduled_job', 'dc_plugin_cron_function');

		// setup cron job
		//add_action( 'admin_init', array( $this, 'dc_plugin_schedule_cron' ) );
		//add_filter( 'cron_schedules', array( $this, 'dc_plugin_cron_add_intervals') );

		// // callback for schedule option "job_name" save
		// add_action( 'acf/save_post', array( $this, 'dc_schedule_options_after_save' ), 1 );

	}

	// the actual function
	// function dc_plugin_cron_function() {
	// 	// see if fires via email notification
	// 	wp_mail('petron@gmail.com','Cron Worked', date('r'));
	// 	$dc_main_class->dc_log_me( 'dc_plugin_cron_function run' );
	// }

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

		// $wp_cron_jobs = get_option( 'cron' );
		// print_r( $wp_cron_jobs );
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

	public function dc_plugin_schedule_cron() {
		// dc_create_scheduled_jobs_table();
		// $this->dc_log_me( 'dc_plugin_schedule_cron run' );
		// if ( !wp_next_scheduled( 'dc_scheduled_jobs' ) )
		// 	wp_schedule_event(time(), 'dc_customTime', 'dc_scheduled_jobs');
	}
	


	public function dc_schedule_options_after_save( $post_id ) {
		$jobname = get_field('job_name', $post_id);
		$old_jobname = $_POST['acf']['field_5be1fcd41f1ec'];
		$jobtime = get_field('start_time', $post_id);
		$old_jobtime = $_POST['acf']['field_5be1fd661f1ed'];
		$jobemails = get_field('email_notifications_to', $post_id);
		$old_jobemails = $_POST['acf']['field_5be1fdac1f1ee'];

		//dc_log_me( 'name: ' . $jobname . ' old: ' . $old_jobname);
		
		if ( $jobname != $old_jobname || 
			 $jobtime != $old_jobtime || 
			 $jobemails != $old_jobemails ) {
			$this->dc_add_cron_job( $jobname, $jobtime, $jobemails );
			// dc_delete_schedule_job();
		}
	}

	public function dc_delete_schedule_job() {
		$timestamp = wp_next_scheduled( 'dc_scheduled_job' );
		wp_unschedule_event( $timestamp, 'dc_scheduled_job' );
		echo 'dc_scheduled_job deleted';
		die();
	}
	
	public function dc_plugin_cron_add_intervals( $schedules ) {
		$schedules['dc_customTime'] = array(
			'interval' => 60,
			'display' => __('Every 60sec')
		);
		return $schedules;
	}

	public function dc_add_cron_job(){
	// 	// delete old job and add new job 
		$dc_class = new DoranCafe();
		dc_log_me( 'dc_get_units_scheduled_job event scheduled' );
		wp_schedule_event( current_time( 'timestamp' ), 'dc_customTime', 'dc_get_units_scheduled_job' );
	}


	public function dc_get_units_scheduled_job() {
		dc_log_me( 'dc_get_units_scheduled_job run');
	}
	
	// function dc_run_schedule_job() { // run the job: get unit data 
	// 	$dc_class = new DoranCafe();
	// 	$dc_class->dc_log_me( 'dc_run_schedule_job run');
	// 	dc_get_unit_data();
	// }


}

add_action( 'dc_get_units_scheduled_job','dc_run_schedule_job' );
