<?php 
/*
 * view units
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


<div class="container">

	<div class="row">
		<div class="col-md-9">
			<h2>View Units</h2>
		</div>
		<div class="col-md-3">
			<form action="" id="api_get_units" style="width: 100%;">
				<input type="hidden" id="api_url_floorplan" value="<?php echo $dc_api_floorplan_url; ?>" style="width: 100%;">
				<input type="hidden" id="api_url_aptavail" style="width: 100%;" value="<?php echo $dc_api_aptavail_url; ?>">
				<button class="get-data">Refresh unit data from RentCafe</button>
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
			</form>
		</div>
	</div>
	


	<div class="row">
		<div class="col-md-12" id="data-grid"><?php 
			$dc_class = new DoranCafe_Admin( 'DORANCAFE_PLUGIN', '1.0.0-alpha' );
			$units = $dc_class->dc_get_units();
			if ( $units ) : ?>
			<table width="100%" class="unit-grid">
				<thead>
					<tr>
					<th><span>Unit#</span></th>
					<th><span>Beds</span></th>
					<th><span>Baths</span></th>
					<th><span>SQFT</span></th>
					<th><span>MaximumRent</span></th>
					<th><span>Amenities</span></th>
					<th><span>AvailableDate</span></th>
					<th><span>PDF</span></th>
					</tr>
				</thead>
				<tbody><?php 
				foreach( $units as $unit ) :
					$unit_pdf_link = '<a href="#" class="modal-trigger" data-unit-id="' . $unit->AptAvailTblId . '" data-unit-num="' . $unit->ApartmentName . '">Add PDF</a>';
					if ( $unit->UnitPDF ) {
						$unit_pdf_link = '<a href="#" class="modal-trigger" data-unit-id="' . $unit->AptAvailTblId . '" data-unit-num="' . $unit->ApartmentName . '">Change PDF</a>';
						$unit_pdf_link .= ' | <a href="' . $unit->UnitPDF . '" target="_blank">View</a>';
					}
					echo '<tr>';
					echo '<td>' . $unit->ApartmentName . '</td>';
					echo '<td>' . $unit->Beds . '</td>';
					echo '<td>' . $unit->Baths . '</td>';
					echo '<td>' . $unit->SQFT . '</td>';
					echo '<td>' . $unit->MaximumRent . '</td>';
					echo '<td>' . str_replace('^', ', ', $unit->Amenities) . '</td>';
					echo '<td>' . $unit->AvailableDate . '</td>';
					echo '<td>' . $unit_pdf_link . '</td>';
					echo '</tr>';
				endforeach;
				echo '</tbody></table>';
			endif; ?>
		</div>
	</div>
</div>

<div id="upload_modal" class="modal"><!-- modal -->
	<div class="modal-content">
		<span class="close">&times;</span>
		<div class="modal-form-wrapper">Form Goes Here</div>
	</div>
</div>