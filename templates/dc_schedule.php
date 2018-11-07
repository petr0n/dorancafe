<?php 
/*
 * schedule
 *
 *
*/


?>

<div class="container">
	<div class="row">
		<div class="col-md-12"><?php 
			$schedule_options = array(
				'id' => 'dc_schedule_form',
				'post_id' => 'options',
				'new_post' => false,
				'field_groups' => array( '23' ),
				'return' => admin_url('admin.php?page=dorancafe'),
				'submit_value' => 'Update',
			);
			acf_form( $schedule_options );  ?>
		</div>
	</div>
</div>