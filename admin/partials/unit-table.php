<?php 


?>

<div class="row units-table">
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
					// var_dump($unit);
					$unit_pdf_link = '<a href="#" class="modal-trigger" data-unit-id="' . $unit->AptAvailTblId . '" data-unit-num="' . $unit->unitnum . '">Add PDF</a>';
					if ( $unit->FileName ) {
						$unit_pdf_link = '<a href="#" class="modal-trigger" data-unit-id="' . $unit->AptAvailTblId . '" data-unit-num="' . $unit->unitnum . '">Change PDF</a>';
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