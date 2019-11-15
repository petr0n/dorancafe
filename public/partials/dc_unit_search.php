<?php 
	$qry_params = '';
	if(count($_GET)) {
		$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		$parts = parse_url($url);
		parse_str($parts['query'], $qry_params);
		// var_dump( $query );
	}
	$dc_public = new DoranCafe_Public( 'DORANCAFE_PLUGIN', '1.0.0-alpha' );
?>


 <div class="dc_form-container">
	<h2 class="dc_page_title">SEARCH</h2>
	<div class="dc_image-search-wrapper" id="dc_image-search-box">
		<div class="dc_page_subtitle">
			<h4>Click on a floor to view floor map</h4>
			<p>or search apartments below</p>		
		</div>
		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 960 540" id="aria-floor-hovers">
			<title>Aria Hover Map</title>
			<g id="aria-front" data-name="aria-front">
				<image xlink:href="/wp-content/plugins/DoranCafe/public/dist/images/aria-front.jpg" width="960" height="540" />
				<!-- <g id="aria-front-img" data-name="aria-front-img">
				</g> -->
				<g id="floor1" class="floor even" data-display-name="Floor 1" data-modal="floorplate1">
					<polygon points="85.83 292 96.74 298 102.57 298 143.15 320.25 192.85 318.25 192.85 322.25 229.12 336.75 238 335.75 270.46 345.75 295.06 343 392.95 356.25 408.67 352.25 495.15 355.25 547.14 355.75 547.14 352.25 648.07 353.25 648.07 349.5 757.63 346.25 924.5 339.5 924.5 403.75 891.02 408.25 788.06 413.25 776.68 405.36 757.12 406 756.36 426.75 690.42 432.25 500.22 416 492.11 428.25 370.88 410.75 354.91 418 271.73 398.75 253.21 403.75 230.64 388 220.5 388.25 194.88 373 143.66 383 85.83 330.25 85.83 292" />

				</g>
				<g id="floor2" class="floor odd" data-display-name="Floor 2" data-modal="floorplate2">
					<polygon points="85.83 292 105.11 292 105.11 280.25 109.67 281.5 118.8 281.75 123.37 284.5 146.19 284.75 146.19 290 154.07 292 168.47 290.8 174.34 292 193.62 292 229.12 299 238.25 299 252.71 301.5 269.95 304 294.8 302.25 392.69 308.75 408.92 306 491.85 309 547.39 309 547.26 307.38 649.34 307.75 701.58 307.5 701.58 305 757.38 304.25 924.5 301 924.5 324 930.33 325.25 930.33 339.25 648.07 349.5 648.07 353.25 547.14 352.25 547.14 355.75 493 354.6 408.67 351.25 392.95 356.25 294 343.33 271.31 346.07 240.67 336.33 229.83 337.17 193.31 322.42 193.36 319 143.15 320.25 103.2 298 96.23 298.25 85.83 292" />
				</g>
				<g id="floor3" class="floor even" data-display-name="Floor 3" data-modal="floorplate3">
					<polygon points="103.88 280.25 108.45 281.5 117.59 281.75 122.17 284.5 145 284.5 145.03 290 153.92 292 167.35 290.8 173.22 292 192.53 292 228.09 299 237.24 299 273.75 304.08 298.78 301.81 391.94 308.75 408.2 306 492.92 309 546.75 309.33 546.77 307.38 701.35 307.5 701.35 305 931.33 300.25 931.33 286.13 923.64 286.13 923.64 265.25 846.91 265.25 648.51 266.13 491.78 266.25 407.82 266 392.2 266.63 353.58 265.88 294.4 265.25 270.01 265.88 253.24 265.25 228.73 265.25 105.67 263.3 105.67 273.5 103.88 273.33 103.88 280.25" />
				</g>
				<g id="floor4" class="floor odd" data-display-name="Floor 4" data-modal="floorplate4">
					<polygon points="105.02 248.5 108.38 248.5 108.38 246.25 119.38 246.25 119.38 243.25 133.92 243.25 133.92 241.75 146.24 238.75 153.22 237.88 174.02 237.25 200.27 237.25 221 233.17 238.71 231.75 253.67 229.88 312.91 228.13 354.76 226 492.13 223.75 499.24 225.5 546.17 224.88 648.67 223.17 691.88 224.76 691.88 226.89 800.1 228.5 924.53 229.88 924.53 251.38 931 251.38 931 264.88 608.95 266.16 408.55 266 392.94 266.63 295.28 265.25 274.59 266.01 254.18 265.25 103.88 263.25 103.88 257 105.02 257.13 105.02 248.5" />
				</g>
				<g id="floor5" class="floor even" data-display-name="Floor 5" data-modal="floorplate5">
					<polygon points="104.88 248.5 108.38 248.5 108.38 246.25 119.38 246.25 119.38 243.25 133.5 243.25 133.5 241.75 146.63 238.75 153.5 237.88 174 237.25 199.88 237.25 221.29 233.12 239.34 231.55 252.5 229.88 355.13 226 493.02 223.58 499.33 225.43 648.67 223.17 691.88 224.75 691.88 227 932 229.63 932 213.88 925.75 213.88 926.01 194.64 648.41 183.56 648.38 181.13 497.5 184 491.13 180.75 355.43 184.01 273.88 193.7 252.5 194 238.38 198.5 220 201.13 198.63 210.49 198.5 206.5 175.25 206.5 157.5 214.13 129.63 225.25 122.75 224.88 119.75 226.13 119.75 228.88 113 229.25 108.63 231 104.88 231 104.88 233.38 107.13 233.25 107.13 241.88 104.88 241.88 104.88 248.5" />
				</g>
				<g id="floor6" class="floor odd" data-display-name="Floor 6" data-modal="floorplate6">
					<polygon points="104.88 230.75 108.67 230.75 113.11 228.95 119.94 228.56 119.94 225.73 122.98 224.44 131 224.42 147.14 218.45 175.14 206.52 198.5 206.5 198.63 210.49 221.48 200.98 233.67 199.33 254.4 193.64 273.88 193.7 355.43 184.01 371.5 184.59 492.05 180.02 498.5 183.37 648.28 181.44 648.41 184.56 924.03 194.28 930.49 194.41 930.49 179.61 892.26 178.71 892.38 155.27 941 149.35 941 142.01 788.18 134.68 773.5 139.82 773.37 145.36 756.15 145.1 756.28 142.27 761.72 140.21 761.72 131.1 711.33 129.91 718.53 126.82 718.53 117.84 547.63 121.19 547.63 110.5 407.72 124.53 391.01 115.65 293.77 137.28 266.18 131.74 235.66 149.61 235.41 156.18 220.6 153.63 200.59 164.83 200.59 175.78 175.14 173.07 157.8 183.37 157.67 179.25 152.1 179.12 134.12 192.35 134.38 199.31 132.35 200.37 121.97 200.11 104.88 211.95 104.88 215.3 107.03 215.56 107.05 224.88 104.88 225.99 104.88 230.75" />
				</g>
			</g>
		</svg>
	</div>


	<!-- modal -->
	<div id="dc_upload_modal" class="dc_modal" style="display: none;">
		<div class="dc_modal-content">
			<div class="dc_modal-title">
				<span class="dc_modal_close">&times;</span>
				<h3></h3>
				<span>Click on a unit to view details</span></div>
			<div class="dc_modal-form-wrapper">
			</div>
		</div>
	</div>

	<form action="" class="dc_search-form" id="dc_search_form">
		<div class="dc_form-wrapper-header">
			<div class="dc_left-col">
				<div class="dc_form-row">
					<label for="availability">Availability</label>
					<div class="dc_form-element">
						<select name="availability" id="availability">
							<option value="all" selected="selected">All</option>
							<option value="available">Available only</option>
							<option value="unavailable">Unavailable only</option>
						</select>
					</div>
				</div>
				<div class="dc_form-row">
					<label for="beds">Bedrooms</label>
					<div class="dc_form-element">
						<select name="beds" id="beds">
							<option value="" selected="selected">-select-</option>
							<option value="alcove">Alcove</option>
							<option value="1">1 BR</option>
							<option value="2">2 BR</option>
							<option value="3">3 BR</option>
							<option value="Townhome">2 BR Townhome</option>
						</select>
					</div>
				</div>
				
				<div class="dc_form-row">
					<label for="floorplanname">Floorplan Name</label>
					<div class="dc_form-element">
						<select name="floorplanname" id="floorplanname">
							<option value="" selected="selected">-select-</option><?php 
							$floorplans = $dc_public->dc_public_get_floorplans(); 
							foreach($floorplans as $floorplan) : ?>
								<option value="<?php echo $floorplan->FloorplanName; ?>"><?php echo $floorplan->FloorplanName ?></option><?php
							endforeach; ?>
						</select>
					</div>
				</div>
				
				<?php /* 
				<div class="dc_form-row">
					<label for="price">Price</label>
					<div class="dc_form-element">
						<select name="price" id="price">
							<option value="" selected="selected">-select-</option>
							<option value="1400_1750">$1,400-$1,650</option>
							<option value="1651_2150">$1,651-$2,150</option>
							<option value="2001_2500">$2,151-$2,500</option>
							<option value="2501_3000">$2,501-$3,000</option>
							<option value="3000_10000">3000+</option>
						</select>
					</div> 
				</div>
				*/?>
			</div>

			<div class="dc_middle-col">
				<div class="dc_form-row">
					<label for="baths">Bathrooms</label>
					<div class="dc_form-element">
						<select name="baths" id="baths">
							<option value="" selected="selected">-select-</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="2.5">2.5</option>
						</select>
					</div>
				</div>
				<div class="dc_form-row">
					<label for="unit_view">View</label>
					<div class="dc_form-element">
						<select name="unit_view" id="unit_view">
							<option value="" selected="selected">-select-</option>
							<option value="North">North</option>
							<option value="East">East</option>
							<option value="South">South</option>
							<option value="West">West</option>
						</select>
					</div>
				</div>
				<div class="dc_form-row">
					<label for="floor">Floor</label>
					<div class="dc_form-element">
						<select name="floor" id="floor">
							<option value="" selected="selected">-select-</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
						</select>
					</div>
				</div>
			</div>

			<div class="dc_right-col">
				<h4>Additional Features</h4>
				<div class="dc_form-row dc_form-check">
					<div class="dc_form-element">
						<input type="checkbox" name="feature4" id="feature4" value="terrace">
					</div>
					<label for="feature4">Terrace</label>
				</div>
				<div class="dc_form-row dc_form-check">
					<div class="dc_form-element">
						<input type="checkbox" name="feature1" id="feature1" value="balcony">
					</div>
					<label for="feature1">Balcony</label>
				</div>
				<div class="dc_form-row dc_form-check">
					<div class="dc_form-element">
						<input type="checkbox" name="feature2" id="feature2" value="fireplace">
					</div>
					<label for="feature2">Fireplace</label>
				</div>
				<div class="dc_form-row dc_form-check">
					<div class="dc_form-element">
						<input type="checkbox" name="feature5" id="feature5" value="appliance">
					</div>
					<label for="feature5">Premium Appliance Package</label>
				</div>
				<!-- 
				<div class="dc_form-row dc_form-check">
					<div class="dc_form-element">
						<input type="checkbox" name="feature3" value="Patio">
					</div>
					<label for="features3">Patio</label>
				</div> -->
			</div>
		</div>
		<div class="dc_clear-filter">
			<a href="" class="dc_btn" id="clear_filter">Clear Filters</a>
		</div>
		<div class="dc_restricted" style="">
		<?php /*
		<p>To be added to the waiting list for our 10 income-restricted units, please email <a href="mailto:leasing@ariaedina.com">leasing@ariaedina.com</a>.</p>
		*/ ?>
			<p>Inquiring about our 10 income-restricted units? <a href="/income-restricted/">Click here.</a></p>
		</div>
		<div class="dc_form-footer">
			<div class="dc_left-col">
				<div class="display-count-wrapper">
					<label for="display_count">Display</label>
					<select name="display_count" id="display_count">
						<option value="12" selected="selected">12</option>
						<option value="24">24</option>
						<option value="36">36</option>
					</select>
				</div>
			</div>
			
			<div class="dc_right-col">
				<div class="sort-wrapper">
					<label for="sort_by">Sort By</label>
					<select name="sort_by" id="sort_by">
						<option value="" selected="selected">-select-</option>
						<?php /* 
						<option value="price_high">Price (highest)</option>
						<option value="price_low">Price (lowest)</option>
						*/?>
						<option value="size_high">Size (largest)</option>
						<option value="size_low">Size (smallest)</option>
					</select>
				</div>
			</div>
		</div>
		<div class="dc_search-results"><?php 
			$dc_public->dc_public_get_units( $qry_params ); ?>
		</div>
	</form>
</div>
