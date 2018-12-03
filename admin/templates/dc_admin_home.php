<?php 
/*
 * home page of DoranCafe Plugin
 *
 *
*/


?>
<div class="wrap">
  <h1>Welcome to DoranCafe Setup</h1>
  <p>Enter all the data for this properties</p>
</div>
<div class="container">
	<form action="" id="api_get_units" style="width: 100%;">
		<div class="row">
			<div class="col-md-12">
				<input type="text" id="api_url_floorplan" value="https://api.rentcafe.com/rentcafeapi.aspx?requestType=floorplan&companyCode=c00000075513&propertyid=846708" style="width: 100%;">
				<input type="text" id="api_url_aptavail" style="width: 100%;" value="https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentAvailability&companyCode=c00000075513&propertyid=846708&sortOrder=apartmentName">
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<button>Get Data</button>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<p>floorplans<br>
				https://api.rentcafe.com/rentcafeapi.aspx?requestType=floorplan&companyCode=c00000075513&propertyid=846708</p>
				<p>apart avail:<br>
				https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentAvailability&companyCode=c00000075513&propertyid=846708&sortOrder=apartmentName</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" id="notifications" style="background-color: red;color:white;">					
			</div>
		</div>
	</form>
</div>
<hr>
