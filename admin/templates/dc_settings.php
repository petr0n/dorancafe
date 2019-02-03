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
