<?php 
/*
 * plugin settings
 *
*/
?>
<h2>DoranCafe Settings</h2><?php 
$btn_txt = 'Update Settings';
$SettingId = 2;
if ( !$dc_settings ) : ?>
	<p>Please set up the property to get started</p><?php 
	$btn_txt = 'Save Settings';
	$form_action = 'insert_settings';
	$EndpointUrl = '';
	$FetchDataTime = '';
else :
	$form_action = 'update_settings';
	foreach($dc_settings as $dc_setting) {
		$EndpointUrl = $dc_setting->EndpointUrl;
		$FetchDataTime = $dc_setting->FetchDataTime;
	} 
endif; 
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<form action="admin.php?page=dorancafe" class="dc_settings_form" method="post">
				<input type="hidden" name="SettingId" id="SettingId" value="<?php echo $SettingId; ?>">
				<input type="hidden" name="action" value="<?php echo $form_action; ?>">
				<div class="form-control">
					<label for="EndpointUrl">RentCafe Property API Endpoint:</label>
					<input type="text" value="<?php echo $EndpointUrl; ?>" name="EndpointUrl" id="EndpointUrl">
				</div>
				<div class="form-control">
					<label for="FetchDataTime">Time to get data from RentCafe:</label>
					<input type="text" value="<?php echo $FetchDataTime; ?>" name="FetchDataTime" id="FetchDataTime">
				</div>
				<div class="form-control">
					<input type="submit" value="<?php echo $btn_txt; ?>" class="wp-core-ui button-primary">
				</div>
			</form>
		</div>
	</div>
</div> 

<?php /*

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
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>DoranCafe Settings Page</h2><?php 
			$btn_txt = 'Update Settings';
			if ( !get_field( 'property_id', 'option' ) || !get_field( 'property_name', 'option' ) ) : ?>
				<p>Please set up the property to get started</p><?php 
				$btn_txt = 'Save Settings';
			endif;
			$first_options = array(
				'id' => 'dc_base_options_form',
				'post_id' => 'options',
				'new_post' => false,
				'field_groups' => array( '37' ),
				'return' => admin_url('admin.php?page=dorancafe&setup=complete'),
				'submit_value' => $btn_txt,
			);
			acf_form( $first_options );
			echo '<hr>';					
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
		</div>
	</div>
</div> 

*/ ?>