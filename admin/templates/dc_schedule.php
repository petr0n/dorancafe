<?php 
/*
 * schedule
 *
 *
*/


?>
<h2>Schedule</h2>
<div class="container">
	<div class="row">
		<div class="col-md-12"><?php 
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
			<form action="" id="schedule_form"><button>Delete existing scheduled job</button></form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3>Existing jobs</h3>
			<?php 
			$schedule_services = new DoranCafe_Schedule_Services();
			$schedule_services->dc_get_scheduled_job();
			 ?>
		</div>
	</div>
</div>