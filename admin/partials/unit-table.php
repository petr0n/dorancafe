<?php 


?>

<div class="units-table">
	<div id="data-grid"><?php 
		$dc_class = new DoranCafe_Admin( 'DORANCAFE_PLUGIN', '1.0.0-alpha' );
		$units = $dc_class->dc_get_units();
		if ( $units ) : 
			echo '<p>Total Units: ' . count($units) . '</p>'; ?>
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
					// var_dump($unit);
					$unit_pdf_link = '<a href="#" class="dc_modal_trigger" data-apt_num="' . $unit->unitnum . '">Add PDF</a>';
					if ( $unit->FileName ) {
						$unit_pdf_link = '<a href="#" class="dc_modal_trigger" data-apt_num="' . $unit->unitnum . '">Change PDF</a>';
						$unit_pdf_link .= ' | <a href="' . $unit->FileName . '" target="_blank">View</a>';
					}
					echo '<tr>';
					echo '<td>' . $unit->unitnum . '</td>';
					echo '<td>' . $unit->Beds . '</td>';
					echo '<td>' . $unit->Baths . '</td>';
					echo '<td>' . $unit->SQFT . '</td>';
					echo '<td>' . $unit->MaximumRent . '</td>';
					echo '<td>' . str_replace('^', ', ', $unit->Amenities) . '</td>';
					echo '<td>' . $unit->AvailableDate . '</td>';
					echo '<td nowrap>' . $unit_pdf_link . '</td>';
					echo '</tr>';
				endforeach; ?>
				</tbody>
			</table><?php 
		endif; ?>
	</div>
</div>

<!-- modal -->
<div id="dc_upload_modal" class="dc_modal">
	<div class="dc_modal-content">
		<span class="dc_modal_close">&times;</span>
		<div class="dc_modal-form-wrapper">
			<form method="post" class="dc_pdf_form">
				<input type="hidden" name="dc_file_name" id="dc_file_name" value="">
				<input type="hidden" name="dc_apt_num" id="dc_apt_num" value="">
				<div class="form-control">
					<label for="dc_upload_file">Unit PDF</label>
					<input type="button" id="dc_upload_file" name="dc_upload_file" class="wp-core-ui button-primary" value="Select File">
					<div class="dc_file_preview"></div>
				</div>
				<div class="form-control save">
					<input type="submit" name="dc_pdf_save_btn" id="dc_pdf_save_btn" class="dc_save" value="Save PDF" class="wp-core-ui button-primary">
				</div>
			</form>
		</div>
	</div>
</div>