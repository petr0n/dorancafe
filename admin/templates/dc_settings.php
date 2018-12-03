<?php 
/*
 * plugin settings
 *
 *
*/


?>
<div class="container">
	<div class="row">
		<div class="col-md-12"><?php 
			$first_options = array(
				'id' => 'dc_base_options_form',
				'post_id' => 'options',
				'new_post' => false,
				'field_groups' => array( '12' ),
				'return' => admin_url('admin.php?page=dorancafe&form=base'),
				'submit_value' => 'Update',
			);
			acf_form( $first_options ); ?>	
		</div>
	</div>
</div>