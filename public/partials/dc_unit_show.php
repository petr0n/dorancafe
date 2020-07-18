<?php 
	$dc_public = new DoranCafe_Public('DORANCAFE_PLUGIN', '1.0.0-alpha');
	$dc_url = $_SERVER['REQUEST_URI'];
	$dc_unit_num = array_slice(explode('/', rtrim($dc_url, '/')), -1)[0];
	if ($dc_unit_num && is_numeric($dc_unit_num)) :
		$dc_unit = $dc_public->dc_public_get_unit_by_id($dc_unit_num);
		if ($dc_unit) :
			$amenities = $dc_unit[0]['Amenities'];
			$amenities_arr = explode('^', $amenities); ?>
			<div class="dc_unit-container">
				<p class="back-to-results"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"> &laquo; Back to results</a></p>
				<div class="dc_unit-wrapper">
					<div class="dc_left-col">
						<h2 class="dc_page_title"><?php echo $dc_unit[0]['FloorplanName']; ?> #<?php echo $dc_unit[0]['ApartmentName']; ?></h2>
						<!-- <div class="dc_page_sub-title"><?php echo $dc_unit[0]['FloorplanName']; ?></div> -->
						<div class="dc_unit--meta">
							<div class="dc_beds">Beds: <?php echo $dc_unit[0]['Beds']; ?></div>&nbsp;&nbsp;|&nbsp;&nbsp;
							<div class="dc_baths">Baths: <?php echo $dc_unit[0]['Baths']; ?></div>&nbsp;&nbsp;|&nbsp;&nbsp;
							<div class="dc_sqft">SQFT: <?php echo $dc_unit[0]['SQFT']; ?></div>
						</div><?php 
						 /* 
						if($dc_unit[0]['AvailableDate'] == ''): ?>
							<div class="dc_not-available">
								THIS UNIT IS NO LONGER AVAILABLE
							</div><?php 
						else : ?>
							<?php

							<div class="dc_rent">
								Monthly Rent: $<?php echo $dc_unit[0]['MaximumRent']; ?>		
							</div>
								?>
							<?php  
						endif;*/  ?>
						<hr>
						<div class="dc_unit-amenities">
							<ul><?php 
								foreach($amenities_arr as $amenity) : ?>
								<li><?php echo $amenity; ?></li><?php 
								endforeach; ?>
							</ul><?php 
							if ($dc_public->dc_get_unit_image($dc_unit[0]['UnitImageURLs'], true)) : ?>
								<div class="dc_unit--img">
									<img src="<?php echo $dc_public->dc_get_unit_image($dc_unit[0]['UnitImageURLs'], true); ?>" alt="<?php echo $dc_unit[0]['ApartmentName']; ?> Floorplate">
								</div><?php 
							endif; ?>
						</div>
						<div class="btn-pdf-wrapper">
							
						</div>
					</div>
					<div class="dc_right-col">
						<div class="dc_link-bar">
							<!-- <a href="<?php echo $dc_unit[0]['ApplyOnlineURL']; ?>" target="blank"><i class="fas fa-edit"></i> Apply Now</a> -->
							<a href="/contact/?avia_11_1=I%20am%20interested%20i%20learning%20more%20about%20Unit%20<?php echo $dc_unit[0]['ApartmentName']; ?>"><i class="fas fa-question-circle"></i> Contact Us for Availability</a>
							<a target="blank" href="<?php echo $dc_unit[0]['FileName'] ?>" class="dc_btn btn-pdf"><i class="fas fa-print"></i> Print Floor Plan</a>
						</div>
						<div class="dc_unit--img">
							<img src="<?php echo $dc_public->dc_get_unit_image($dc_unit[0]['UnitImageURLs']); ?>" alt="<?php echo $dc_unit[0]['ApartmentName']; ?>">
						</div>
					</div>
					<div class="dc_bottom-bar"></div>
				</div>
			</div><?php 
		else : ?>
			<div class="dc_unit-container">
				<h2 class="dc_page_title alert">Unit Not Currently Available</h2>
			</div><?php 
		endif;
	else : ?>
	<div class="dc_unit-container">
		<h2 class="dc_page_title">UNIT MISSING</h2>
	</div><?php 
	endif;
?>