<?php 
	$dc_public = new DoranCafe_Public('DORANCAFE_PLUGIN', '1.0.0-alpha');
	$dc_unit = $dc_public->dc_public_get_unit_by_id($_GET['unit']);
	
 ?>
<div class="container">
	<div class="row">

	<h3 class="dc_unit--num">Unit # <?php echo $dc_unit[0]['ApartmentName']; ?></h3>
		<div class="dc_unit--meta">
			<div class="dc_beds">Beds: <?php echo $dc_unit[0]['Beds']; ?></div>
			<div class="dc_baths">Baths: <?php echo $dc_unit[0]['Baths']; ?></div>
			<div class="dc_sqft">SQFT: <?php echo $dc_unit[0]['SQFT']; ?></div>
		</div>
		<div class="pdf-btn">
			<a href="<?php echo $dc_unit[0]['FileName'] ?>">Download PDF</a>
		</div>
		<div class="dc_unit--img">
			<img src="<?php echo $dc_unit[0]['UnitImageURLs']; ?>" alt="<?php echo $dc_unit[0]['ApartmentName']; ?>">
		</div>
		<div class="dc_bottom-bar"></div>
	</div>
</div>