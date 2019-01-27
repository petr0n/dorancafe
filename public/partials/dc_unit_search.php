<?php 
	$qry_params = '';
	if(count($_GET)) {
		$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		$parts = parse_url($url);
		parse_str($parts['query'], $qry_params);
		// var_dump( $query );
	}
	$dc_public = new DoranCafe_Public( 'DORANCAFE_PLUGIN', '1.0.0-alpha' );


	/*
		- check floorplans page for image map centering issues
		- bedroom should be unit types? 
	*/

?>


 <div class="dc_form-container">
	<h2 class="dc_page_title">SEARCH</h2>
	<div class="dc_image-search-wrapper">

		<!--
		<svg width="960" height="540" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
  <title>Layer 1</title>
  <image xlink:href="/wp-content/plugins/DoranCafe/public/dist/images/aria-front.jpg" id="svg_4" height="540" width="960" y="0" x="0"/>
 
  <a href=""><path id="svg_5" d="m114.96296,201.92593l43.85185,-19.40741l113.77778,-45.03704l604.44444,4.74074l-9.48148,33.18519l-590.22222,-4.74074l-163.55556,61.62963l1.18519,-30.37037z" stroke-width="5" stroke="#000000" fill="#FF0000"/>
 </a>
 <a href="">
  <path stroke-opacity="0" id="svg_6" d="m112.59259,228l212.14815,-19.40741l301.03704,2.37037l286.81481,2.37037l4.74074,40.2963l-296.2963,-7.11111l-267.85185,-2.37037l-158.81481,0l-82.96296,2.37037l1.18519,-18.51852z" stroke-width="5" stroke="#000000" fill="#ff7f00"/>
 </a>
</svg>
		<div class="dc_image-search">
			<img src="/wp-content/plugins/DoranCafe/public/dist/images/aria-front.jpg" alt="aria-front" class="dc_floorplan-image-map" usemap="#dc_image-map">
			<map name="dc_image-map" id="dc_img-map">
				 <area target="" alt="floor6" title="floor6" href="#" coords="108,228,106,213,176,178,199,177,266,144,297,146,390,127,416,134,547,123,706,131,760,131,893,148,891,191,792,189,649,180,495,177,356,183,285,194,255,191,177,206" shape="poly">
				<area target="" alt="floor5" title="floor5" href="#" coords="106,245,176,231,201,234,257,224,290,224,356,223,496,221,650,225,757,225,893,228,893,191,651,182,494,180,352,182,289,194,257,191,197,202,175,206,104,230" shape="poly">
				<area target="" alt="floor4" title="floor4" href="#" coords="104,262,175,260,199,260,253,263,293,263,396,262,492,264,701,263,893,265,891,231,701,227,493,223,354,226,254,228,198,237,175,232,106,246" shape="poly">
				<area target="" alt="floor3" title="floor3" href="#" coords="103,277,172,295,198,293,272,303,294,302,392,310,410,304,646,311,756,305,892,300,892,262,649,267,491,267,354,265,291,265,240,264,218,264,104,261" shape="poly">
				<area target="" alt="floor2" title="floor2" href="#" coords="105,291,174,319,198,318,236,333,271,345,294,342,393,354,411,350,547,355,757,348,893,344,891,301,758,307,650,313,410,304,391,310,293,303,271,304,199,294,174,294,104,279" shape="poly">
			</map>
		</div> -->
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
							<option value="alcove">Alcove 1 BR</option>
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
				
				<div class="dc_form-row">
					<label for="price">Price</label>
					<div class="dc_form-element">
						<select name="price" id="price">
							<option value="" selected="selected">-select-</option>
							<option value="1550_1750">$1,550-$1,750</option>
							<option value="1751_2000">$1,751-$2,000</option>
							<option value="2001_2500">$2,001-$2,500</option>
							<option value="2501_3000">$2,501-$3,000</option>
							<option value="3000plus">3000+</option>
						</select>
					</div> 
				</div>
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
						<input type="checkbox" name="feature1" id="feature1" value="balcony">
					</div>
					<label for="feature1">Balcony</label>
				</div>
				<div class="dc_form-row dc_form-check">
					<div class="dc_form-element">
						<input type="checkbox" name="feature4" id="feature4" value="terrace">
					</div>
					<label for="feature4">Terrace</label>
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
						<option value="price_high">Price (highest)</option>
						<option value="price_low">Price (lowest)</option>
						<option value="size_high">Size (highest)</option>
						<option value="size_low">Size (lowest)</option>
					</select>
				</div>
			</div>
		</div>
		<div class="dc_search-results"><?php 
			$dc_public->dc_public_get_units( $qry_params ); ?>
		</div>
	</form>
</div>
