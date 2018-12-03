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
		height: 100px;
		overflow-y: scroll;
		overflow-x: hidden;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-md-12" id="data-grid"><?php 
			$dc_class = new DoranCafe_Admin( 'DORANCAFE_PLUGIN', '1.0.0-alpha' );
			$units = $dc_class->dc_get_units();
			if ( $units ) : ?>
			<table>
				<thead>
					<tr>
					<th>Unit#</th>
					<th>Beds</th>
					<th>Baths</th>
					<th>SQFT</th>
					<th>MaximumRent</th>
					<th>Amenities</th>
					<th>AvailableDate</th>
					</tr>
				</thead>
				<tbody><?php 
				foreach( $units as $unit ) :
					echo '<tr>';
					echo '<td>' . $unit->ApartmentName . '</td>';
					echo '<td>' . $unit->Beds . '</td>';
					echo '<td>' . $unit->Baths . '</td>';
					echo '<td>' . $unit->SQFT . '</td>';
					echo '<td>' . $unit->MaximumRent . '</td>';
					echo '<td>' . $unit->Amenities . '</td>';
					echo '<td>' . $unit->AvailableDate . '</td>';
					echo '</tr>';
				endforeach;
				echo '</tbody></table>';
			endif; ?>
		</div>
	</div>
</div>