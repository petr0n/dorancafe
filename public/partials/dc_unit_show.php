<?php 
	$dc_public = new DoranCafe_Public('DORANCAFE_PLUGIN', '1.0.0-alpha');
	$dc_unit = $dc_public->dc_public_get_unit_by_id($_GET['unit']);
	$amenities = $dc_unit[0]['Amenities'];
	$amenities_arr = explode('^', $amenities);
	//var_dump($amenities);
 ?>
<div class="dc-unit-container">
	<div class="dc-unit-wrapper">
		<div class="left-col">
			<h2 class="dc_unit--num">Unit # <?php echo $dc_unit[0]['ApartmentName']; ?></h2>
			<div class="dc_unit--meta">
				<div class="dc_beds">Beds: <?php echo $dc_unit[0]['Beds']; ?></div>
				<div class="dc_baths">Baths: <?php echo $dc_unit[0]['Baths']; ?></div>
				<div class="dc_sqft">SQFT: <?php echo $dc_unit[0]['SQFT']; ?></div>
				<div class="dc_rent">Monthly Rent: <?php echo $dc_unit[0]['MaximumRent']; ?></div>
			</div>
			<hr>
			<div class="dc_unit-amenities">
				<ul><?php 
					foreach($amenities_arr as $amenity) : ?>
					<li><?php echo $amenity; ?></li><?php 
					endforeach; ?>
				</ul>
			</div>
			<div class="pdf-btn">
				<a href="<?php echo $dc_unit[0]['FileName'] ?>">Download PDF</a>
			</div>
		</div>
		<div class="right-col">
			<div class="dc_unit--img">
				<img src="<?php echo $dc_unit[0]['UnitImageURLs']; ?>" alt="<?php echo $dc_unit[0]['ApartmentName']; ?>">
			</div>
		</div>
		<div class="dc_bottom-bar"></div>
	</div>
</div>