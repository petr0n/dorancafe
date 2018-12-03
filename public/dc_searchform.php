<?php 

	if(count($_GET)) {

		$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		$parts = parse_url($url);
		parse_str($parts['query'], $qry_params);
		// var_dump( $query );
	}
	$dc_public = new DoranCafe_Public( 'DORANCAFE_PLUGIN', '1.0.0-alpha' );

 ?>

 <div class="form-container">
	<div class="form-wrapper">
		<form action="" class="dc-search-form" id="dc_search_form">
			<label for="">Availability
				<select name="availability" id="availability">
					<option value="all" selected="selected">All</option>
					<option value="available">Available only</option>
					<option value="unavailable">Unavailable only</option>
				</select>
			</label>
			<label for="">Bedrooms
				<select name="beds" id="beds">
					<option value="" selected="selected">-select-</option>
					<option value="1">1 BR</option>
					<option value="2">2 BR</option>
					<option value="3">3 BR</option>
				</select>
			</label>
			<label for="">Bathrooms
				<select name="baths" id="baths">
					<option value="" selected="selected">-select-</option>
					<option value="1">1</option>
					<option value="1.5">1.5</option>
					<option value="2">2</option>
					<option value="2.5">2.5</option>
					<option value="3">3</option>
				</select>
			</label>
			<label for="">View 
				<select name="unit_view" id="unit_view">
					<option value="" selected="selected">-select-</option>
					<option value="North">North</option>
					<option value="East">East</option>
					<option value="South">South</option>
					<option value="West">West</option>
				</select>
			</label>
			<label for="">Floorplan Name
				<select name="floorplanname" id="floorplanname">
					<option value="" selected="selected">-select-</option><?php 
					$floorplans = $dc_public->dc_public_get_floorplans(); 
					
					foreach($floorplans as $floorplan) : ?>
						<option value="<?php echo $floorplan->FloorplanName; ?>"><?php echo $floorplan->FloorplanName ?></option><?php
					endforeach; ?>
				</select>
			</label>
			<label for="">Floor 
				<select name="floor" id="floor">
					<option value="" selected="selected">-select-</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</label>
			<label for="">Price 
				<select name="price" id="price">
					<option value="" selected="selected">-select-</option>
					<option value="1000_1500">1,000 - 1,500</option>
					<option value="1500_2000">1,500 - 2,000</option>
					<option value="2000_2500">2,000 - 2,500</option>
					<option value="2500_3000">2,500 - 3,000</option>
					<option value="3000plus">3000+</option>
				</select>
			</label>

			<h3>Additional Features</h3>
			<label for=""> Balcony
				<input type="checkbox" name="feature1" value="balcony">
			</label>
			<label for="">Fireplace
				<input type="checkbox" name="feature2" value="fireplace">
			</label>
			<label for="">Bathtub
				<input type="checkbox" name="feature3" value="Bathtub">
			</label>
			<label for="">Terrace
				<input type="checkbox" name="feature4" value="balcony">
			</label>
			<label for="">Upgraded Appliance Package
				<input type="checkbox" name="features5" value="Appliance">
			</label>
			
			<select name="display_count" id="display_count">
				<option value="12" selected="selected">12</option>
				<option value="24">24</option>
				<option value="36">38</option>
			</select>

			<select name="sort_by" id="sort_by">
				<option value="" selected="selected">-select-</option>
				<option value="price_high">Price (highest)</option>
				<option value="price_low">Price (lowest)</option>
				<option value="size_high">Size (highest)</option>
				<option value="size_low">Size (lowest)</option>
			</select>
		
		</form>
		<a href="" class="clear_filter" id="clear_filter">Clear Filters</a>
	</div>
 </div><?php 
	$dc_public->dc_public_get_units( $qry_params ); ?>
