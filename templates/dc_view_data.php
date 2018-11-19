<?php 
/*
 * view data
 *
 *
*/


?>
<style>
	#data-grid {
		border: 1px solid #ddd;
		width: 100%;
		height: 300px;
		overflow-y: scroll;
		overflow-x: hidden;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-md-12" id="data-grid"><?php 
			$api_services = new DoranCafe_API_Services();
			$api_services->dc_get_units(); ?>					
		</div>
	</div>
</div>