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
	<div class="row">
			<form action="" id="api_floorplan_get" style="width: 100%;">
				<div class="col-md-10">
					<input type="text" id="api_url_floorplan" value="https://api.rentcafe.com/rentcafeapi.aspx?requestType=floorplan&companyCode=c00000075513&propertyid=846708" style="width: 100%;">
					<input type="text" id="api_url_aptavail" style="width: 100%;" value="https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentAvailability&companyCode=c00000075513&propertyid=846708">
				</div>

				<div class="col-md-2">
					<button>Get Data</button>
				</div>
			</form>
		</div>
		<div class="row"></div>
			<div class="col-md-12">
				<p>floorplans<br>
				https://api.rentcafe.com/rentcafeapi.aspx?requestType=floorplan&companyCode=c00000075513&propertyid=846708</p>
				<p>apart avail:<br>
				https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentAvailability&companyCode=c00000075513&propertyid=846708</p>
			</div>

			<div class="col-md-12" id="notifications" style="background-color: red;color:white;">
				
			</div>
		</div>
	</div>
</div>
<hr>
<form action="">
<div class="container">
	<div class="row">
		<div class="col-md-2">Property ID:</div>
		<div class="col-md-6"><input type="text"></div>
	</div>
	<div class="row">
		<div class="col-md-2">Property Code:</div>
		<div class="col-md-6"><input type="text"></div>
	</div>
	<div class="row">
		<div class="col-md-2">Property Name:</div>
		<div class="col-md-6"><input type="text"></div>
	</div>
	<div class="row">
		<div class="col-md-2">Property URL:</div>
		<div class="col-md-6"><input type="text"></div>
	</div>
	<div class="row">
		<div class="col-md-2">Resident Services URL:</div>
		<div class="col-md-6"><input type="text"></div>
	</div>
	<div class="row">
		<div class="col-md-2">Applicant Portal URL:</div>
		<div class="col-md-6"><input type="text"></div>
	</div>
	<div class="row">
		<div class="col-md-2">Apply Now URL:</div>
		<div class="col-md-6"><input type="text"></div>
	</div>
		<div class="row">
		<div class="col-md-2">Floorplan URL:</div>
		<div class="col-md-6"><input type="text"></div>
	</div>
	<div class="row">
		<div class="col-md-2">&nbsp;</div>
		<div class="col-md-6"><input type="submit" value="Save"></div>
	</div>
</div>
</form>

