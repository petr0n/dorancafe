<?php 
/*
 * get data form
 *
 *
*/


?>
<div class="container">
	<form action="" id="api_get_units" style="width: 100%;">
		<div class="row">
			<div class="col-md-12">
				<input type="hidden" id="api_url_floorplan" value="https://api.rentcafe.com/rentcafeapi.aspx?requestType=floorplan&companyCode=c00000075513&propertyid=846708" style="width: 100%;">
				<input type="hidden" id="api_url_aptavail" style="width: 100%;" value="https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentAvailability&companyCode=c00000075513&propertyid=846708&sortOrder=apartmentName">
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<button>Get NEW Data from RentCafe</button>
			</div>
		</div>
		<!-- <div class="row">
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