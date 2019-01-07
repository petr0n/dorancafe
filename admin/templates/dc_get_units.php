<?php 
/*
 * get units 
 *
 *
*/
$dc_api_aptavail_url = get_field('rentcafe_api_endpoint', 'options') . '?requestType=apartmentAvailability&sortOrder=apartmentName';
$dc_api_aptavail_url .= '&companyCode=' . get_field('company_code', 'options');
$dc_api_aptavail_url .= '&propertyid=' . get_field('property_id', 'options');

$dc_api_floorplan_url = get_field('rentcafe_api_endpoint', 'options') . '?requestType=floorplan';
$dc_api_floorplan_url .= '&companyCode=' . get_field('company_code', 'options');
$dc_api_floorplan_url .= '&propertyid=' . get_field('property_id', 'options');
?>
<h2>Get Unit Data</h2>
<div class="container">
	<form action="" id="api_get_units" style="width: 100%;">
		<div class="row">
			<div class="col-md-12">
				<input type="text" id="api_url_floorplan" value="<?php echo $dc_api_floorplan_url; ?>" style="width: 100%;">
				<input type="text" id="api_url_aptavail" style="width: 100%;" value="<?php echo $dc_api_aptavail_url; ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<button>Get NEW Data from RentCafe</button>
			</div>
		</div>
		<!-- 
https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentAvailability&companyCode=c00000075513&propertyid=846708&sortOrder=apartmentName
		<div class="row">
			<div class="col-md-12">
				<p>floorplans<br>
				https://api.rentcafe.com/rentcafeapi.aspx?requestType=floorplan&companyCode=c00000075513&propertyid=846708</p>
				<p>apart avail:<br>
				https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentAvailability&companyCode=c00000075513&propertyid=846708&sortOrder=apartmentName</p>
			</div>
		</div> 
	-->
		<div class="row">
			<div class="col-md-12" id="notifications">			
			</div>
		</div>
	</form>
</div>
