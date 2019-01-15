<?php 
/*
 * view units
 *
 */

$dc_admin_class = new DoranCafe_Admin( 'DORANCAFE_PLUGIN', '1.0.0-alpha' );
$dc_settings = $dc_admin_class->dc_get_settings();
$dc_api_aptavail_url = $dc_settings[0]->EndpointUrl;
$dc_api_floorplan_url = '';

?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<h2>View Units  
				<span class="last-updated">last updated: <?php echo $dc_admin_class->get_updated_date(); ?></span>
			</h2>
		</div>
		<div class="col-md-4">
			<form action="" id="api_get_units" style="float: right;">
				<!-- <input type="hidden" id="api_url_floorplan" value="<?php echo $dc_api_floorplan_url; ?>" style="width: 100%;"> -->
				<input type="hidden" id="api_url_aptavail" style="width: 100%;" value="<?php echo $dc_api_aptavail_url; ?>">
				<button class="get-data">Refresh unit data from RentCafe <i class="fas fa-file-import"></i></button>
				<!-- 
				https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentAvailability&companyCode=c00000075513&propertyid=846708&sortOrder=apartmentName
				-->
			</form>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="unit-table-container">
				<div class="lds-ring-wrapper" style="display: none;">
					<div class="lds-ring"><div></div><div></div><div></div><div></div></div>
				</div>
				<div class="unit-table-wrapper">
					<?php include DORANCAFE_PATH . 'admin/partials/unit-table.php'; ?>
				</div>
			</div>
		</div>
	</div>
</div>

