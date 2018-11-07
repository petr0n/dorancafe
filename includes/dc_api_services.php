<?php 
/* used to make api calls 


	1. get data from rentcafe
	2. save data to file
	3. read file and loop through nodes to insert data into db
	
*/


add_action( 'wp_ajax_dc_get_unit_data', 'dc_get_unit_data' );

function dc_get_unit_data() {

	if ( $_POST['api_url_floorplan'] ) {
		$api_url_floorplan = $_POST['api_url_floorplan'];
		$request_floorplan = wp_remote_get( $api_url_floorplan );
	} else {
		echo 'floorplan missing!';
		return false;
	}
	if ( $_POST['api_url_aptavail'] ) {
		$api_url_aptavail = $_POST['api_url_aptavail'];
		$request_aptavail = wp_remote_get( $api_url_aptavail );
	} else {
		echo 'aptavail missing!';
		return false;
	}


	if( is_wp_error( $request_floorplan ) || is_wp_error( $request_aptavail )) {
		echo 'Uh Oh! wp_remote_get error';
		return false; // Bail early
	}
	
	$body_floorplan = wp_remote_retrieve_body( $request_floorplan );
	$body_aptavail = wp_remote_retrieve_body( $request_aptavail );
	// $data_floorplan = json_decode( $body );

	dc_save_file( 'floorplan', $body_floorplan );
	dc_save_file( 'aptavail', $body_aptavail );
	dc_create_floorplan_table();
	dc_insert_floorplan_data();

	dc_create_aptavail_table();
	dc_insert_aptavail_data();
	// dc_get_units();
	die();

	// echo $body;
	// echo $body;
	//var_dump($data);
	// if( ! empty( $data ) ) {
	// 	echo '<ul>';
	// 	foreach( $data as $unit ) {
	// 		echo '<li>';
	// 			echo 'propid: ' . $unit->PropertyId; 
	// 			echo '<br>name: ' . $unit->FloorplanName . '<hr>';
	// 		echo '</li>';
	// 	}
	// 	echo '</ul>';
	// }
}


function dc_save_file( $filename, $data_to_save ) {
	//Save the JSON string to a text file.
	$today = date('YmdHis');
	$filepath_to_save = DORANCAFE_PATH . 'rentcafe_data/' . $filename . '/' . $filename . '_' . $today . '.txt';
	file_put_contents( $filepath_to_save, $data_to_save);
	echo 'file saved: dc_' . $filename . '_' . $today . '.txt<br>';
}



function dc_create_floorplan_table() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	//* Create the table
	$db = dc_get_db();
	$sql = "CREATE TABLE IF NOT EXISTS `$db->dc_floorplans` (
		FloorplanTblId INTEGER NOT NULL AUTO_INCREMENT,
		PropertyId INTEGER NOT NULL,
		FloorplanId TEXT NOT NULL,
		FloorplanName TEXT NOT NULL,
		Beds INTEGER NOT NULL,
		Baths TEXT NOT NULL,
		MinimumSQFT INTEGER NOT NULL,
		MaximumSQFT INTEGER NOT NULL,
		MinimumRent INTEGER NOT NULL,
		MaximumRent INTEGER NOT NULL,
		MinimumDeposit NUMERIC NOT NULL,
		MaximumDeposit NUMERIC NOT NULL,
		AvailableUnitsCount INTEGER NOT NULL,
		AvailabilityURL TEXT NOT NULL,
		FloorplanImageURL TEXT NOT NULL,
		FloorplanImageName TEXT NOT NULL,
		PropertyShowsSpecials TEXT NOT NULL,
		FloorplanHasSpecials TEXT NOT NULL,
		UnitTypeMapping TEXT NOT NULL,
		PRIMARY KEY (FloorplanTblId)
	) $charset_collate;";
	dbDelta( $sql );
	echo '<br>' . $db->dc_floorplans . ' table created';
}


function dc_insert_floorplan_data() {
	$path_to_file = DORANCAFE_PATH . 'rentcafe_data/floorplan/';
	$files = scandir( $path_to_file, SCANDIR_SORT_DESCENDING );
	$newest_file = $files[0];
	$floorplans_json = file_get_contents( $path_to_file . $newest_file );
	$floorplans = json_decode( $floorplans_json );
	if ( $floorplans ) { // file not blank
		global $wpdb;
		$db = dc_get_db();
		$delete = $wpdb->query("TRUNCATE TABLE $db->dc_floorplans"); //delete data first
		foreach( $floorplans as $floorplan ) {
			$wpdb->insert($db->dc_floorplans, array(
				"PropertyId" 			=> $floorplan->PropertyId,
				"FloorplanId"  			=> $floorplan->FloorplanId,
				"FloorplanName" 		=> $floorplan->FloorplanName,
				"Beds" 					=> $floorplan->Beds,
				"Baths"					=> $floorplan->Baths,
				"MinimumSQFT" 			=> $floorplan->MinimumSQFT,
				"MaximumSQFT"			=> $floorplan->MaximumSQFT,
				"MinimumRent" 			=> $floorplan->MinimumRent,
				"MaximumRent"			=> $floorplan->MaximumRent,
				"MinimumDeposit"		=> $floorplan->MinimumDeposit,
				"MaximumDeposit"		=> $floorplan->MaximumDeposit,
				"AvailableUnitsCount"	=> $floorplan->AvailableUnitsCount,
				"AvailabilityURL"		=> $floorplan->AvailabilityURL,
				"FloorplanImageURL"		=> $floorplan->FloorplanImageURL,
				"FloorplanImageName"	=> $floorplan->FloorplanImageName,
				"PropertyShowsSpecials"	=> $floorplan->PropertyShowsSpecials,
				"FloorplanHasSpecials"	=> $floorplan->FloorplanHasSpecials,
				"UnitTypeMapping" 		=> $floorplan->UnitTypeMapping
			));
			// echo '<li>';
			// 	echo 'tbl: ' . $db->dc_floorplans;
			// 	echo '<br>propid: ' . $floorplan->PropertyId; 
			// 	echo '<br>name: ' . $floorplan->FloorplanName . '<hr>';
			// echo '</li>';
		}
		//echo '</ul>';
	}
	echo '<br>floorplans data inserted<br>';
}


function dc_create_aptavail_table() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	//* Create the table
	$db = dc_get_db();
	$sql = "CREATE TABLE IF NOT EXISTS `$db->dc_aptavail` (
		AptAvailTblId INTEGER NOT NULL AUTO_INCREMENT,
		PropertyId INTEGER NOT NULL,
		VoyagerPropertyId INTEGER NOT NULL,
		VoyagerPropertyCode INTEGER NOT NULL,
		FloorplanId INTEGER NOT NULL,
		FloorplanName TEXT NOT NULL,
		ApartmentId INTEGER NOT NULL,
		ApartmentName INTEGER NOT NULL,
		Beds NUMERIC NOT NULL,
		Baths NUMERIC NOT NULL,
		SQFT NUMERIC NOT NULL,
		MinimumRent NUMERIC NOT NULL,
		MaximumRent NUMERIC NOT NULL,
		Deposit NUMERIC,
		ApplyOnlineURL TEXT NOT NULL,
		UnitImageURLs TEXT NOT NULL,
		Specials TEXT,
		Amenities TEXT NOT NULL,
		AvailableDate TEXT NOT NULL,
		PRIMARY KEY (AptAvailTblId)
	) $charset_collate;";
	dbDelta( $sql );
	echo '<br>' . $db->dc_aptavail . ' table created';
}


function dc_insert_aptavail_data() {
	$path_to_file = DORANCAFE_PATH . 'rentcafe_data/aptavail/';
	$files = scandir( $path_to_file, SCANDIR_SORT_DESCENDING );
	$newest_file = $files[0];
	$json_aptavail = file_get_contents( $path_to_file . $newest_file );
	$aptavails = json_decode( $json_aptavail );
	if ( $aptavails ) { // file not blank
		global $wpdb;
		$db = dc_get_db();
		$delete = $wpdb->query("TRUNCATE TABLE $db->dc_aptavail"); //delete data first
		foreach( $aptavails as $aptavail ) {
			$wpdb->insert($db->dc_aptavail, array(
				"PropertyId" 			=> $aptavail->PropertyId,
				"VoyagerPropertyId" 	=> $aptavail->VoyagerPropertyId,
				"VoyagerPropertyCode" 	=> $aptavail->VoyagerPropertyCode,
				"FloorplanId"  			=> $aptavail->FloorplanId,
				"FloorplanName"  		=> $aptavail->FloorplanName,
				"ApartmentId"			=> $aptavail->ApartmentId,
				"ApartmentName" 		=> $aptavail->ApartmentName,
				"Beds" 					=> $aptavail->Beds,
				"Baths"					=> $aptavail->Baths,
				"SQFT"					=> $aptavail->SQFT,
				"MinimumRent" 			=> $aptavail->MinimumRent,
				"MaximumRent"			=> $aptavail->MaximumRent,
				"Deposit"				=> $aptavail->Deposit,
				"ApplyOnlineURL"		=> $aptavail->ApplyOnlineURL,
				"Specials"				=> $aptavail->Specials,
				"Amenities"				=> $aptavail->Amenities,
				"AvailableDate"			=> $aptavail->AvailableDate
			));
			// echo '<li>';
			// 	echo 'tbl: ' . $db->dc_floorplans;
			// 	echo '<br>propid: ' . $floorplan->PropertyId; 
			// 	echo '<br>name: ' . $floorplan->FloorplanName . '<hr>';
			// echo '</li>';
		}
		//echo '</ul>';
	}
	echo '<br>aptavail data inserted<br>';
}



// next step is to loop through each unique floor plan and insert each unique unit into dc_units


function dc_get_units() {
	// loop through grouped floorplans
	$db = dc_get_db();
	global $wpdb;
	$unit_qry = "
		SELECT * 
		FROM $db->dc_aptavail
		ORDER BY ApartmentName
	"; 

	$units = $wpdb->get_results( $unit_qry, OBJECT );
	// var_dump( $units );
	if ( $units ) { ?>
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
	}
}



// function dc_get_unique_floorplans() {
// 	// loop through grouped floorplans
// 	$db = dc_get_db();
// 	global $wpdb;
// 	$floorplan_qry = "
// 		SELECT * 
// 		FROM $db->dc_floorplans 
// 		GROUP BY FloorplanId
// 		ORDER BY FloorplanId
// 	"; 

// 	$grouped_floorplans = $wpdb->get_results( $qry, OBJECT );
// 	// var_dump( $grouped_floorplans );
// 	if ( $grouped_floorplans ) { // file not blank
// 		global $wpdb;
// 		// echo '<ul>';
// 		foreach( $grouped_floorplans as $floorplan ) {
// 			echo '<br>name: ' . $floorplan->FloorplanName . '<hr>';
// 			// get individual units from aptavail 
// 			$aptavail_qry = "
// 				SELECT *
// 				FROM $dc->dc_aptavail
// 				WHERE FloorplanName = '$floorplan->FloorplanName'
// 			";
// 		}
// 	}
// }

/*
	floorplan request
{
"PropertyId":"846708",
"FloorplanId":"2517452",
"FloorplanName":"Braemar",
"Beds":"0",
"Baths":"1.00",
"MinimumSQFT":"487",
"MaximumSQFT":"487",
"MinimumRent":"1295",
"MaximumRent":"1370",
"MinimumDeposit":"0",
"MaximumDeposit":"0",
"AvailableUnitsCount":"4",
"AvailabilityURL":"https://www.rentcafe.com/onlineleasing/aria-0/oleapplication.aspx?stepname=Apartments&myOlePropertyId=846708&floorPlans=2517452",
"FloorplanImageURL":"https://cdn.rentcafe.com/dmslivecafe/3/846708/Braemar.png",
"FloorplanImageName":"Braemar.png",
"PropertyShowsSpecials":"0",
"FloorplanHasSpecials":"0",
"UnitTypeMapping":"S1"
}

apartment availability

"PropertyId":"846708",
"VoyagerPropertyId":"63",
"VoyagerPropertyCode":"aria",
"FloorplanId":"2517452",
"FloorplanName":"Braemar",
"ApartmentId":"13987569",
"ApartmentName":"337",
"Beds":"0",
"Baths":"1.00",
"SQFT":"487",
"MinimumRent":"1295.00",
"MaximumRent":"1295.00",
"Deposit":"0",
"ApplyOnlineURL":"https://www.rentcafe.com/onlineleasing/aria-0/oleapplication.aspx?stepname=RentalOptions&myOlePropertyId=846708&FloorPlanID=2517452&UnitID=13987569&header=1",
"UnitImageURLs":[  
 "https://cdn.rentcafe.com/dmslivecafe/3/846708/Apt 337.png"
],
"Specials":"",
"Amenities":"3rd Floor^Amenities View",
"AvailableDate":"9/12/2018"

*/