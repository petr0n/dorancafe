<?php 
/*
 * plugin settings
 *https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentAvailability&APIToken=ODQzMDA%3d-PlwIqlU9e7M%3d&propertyid=640713&sortOrder=apartmentName&showallunit=-1
https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentAvailability&APIToken=ODQzMDA%3d-PlwIqlU9e7M%3d&propertyid=1099593&sortOrder=apartmentName&showallunit=-1
https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentAvailability&APIToken=ODQzMDA%3d-PlwIqlU9e7M%3d&propertyid=846708&sortOrder=apartmentName&showallunit=-1
*/
?>
<h2>DoranCafe Settings</h2><?php 
$btn_txt = 'Update Settings';
$SettingId = 2;
if ( !$dc_settings ) : ?>
	<p>Please set up the property to get started</p><?php 
	$btn_txt = 'Save Settings';
	$form_action = 'insert_settings';
	$urls = array("");
	$FetchDataTime = '';
else :
	$form_action = 'update_settings';
	foreach($dc_settings as $dc_setting) {
		$EndpointUrls = json_decode($dc_setting->EndpointUrl, true);
		$urls = $EndpointUrls['urls'];
		$FetchDataTime = $dc_setting->FetchDataTime;
	} 
endif; 
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<form action="admin-post.php?page=dorancafe" class="dc_settings_form" method="post">
				<input type="hidden" name="SettingId" id="SettingId" value="<?php echo $SettingId; ?>">
				<input type="hidden" name="action" value="<?php echo $form_action; ?>">
				<div class=" form-control">
					<label for="EndpointUrl">RentCafe Property API Endpoint:</label>
					<ol class="endPointField-wrapper">
						<?php 
						// var_dump($urls);
						$ctr = 1;
						foreach($urls as $url) : ?>
							<li class="EndPointEl">
								<textarea type="text" value="" name="EndpointUrls[]" id="EndpointUrl<?php echo $ctr; ?>" style="width:100%;" rows="2"><?php 
								echo $url;
								 ?></textarea>
							</li><?php
							++$ctr;
						endforeach; ?>
					</ol>
				</div>
				<div><button class="dc_addEndpoint">Add Endpoint +</button></div>
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
