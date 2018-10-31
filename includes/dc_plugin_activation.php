<?php 
function on_activation()
{
	
}

function on_deactivation()
{
	//Some stuff
}


// function dc_createFloorplanTable() {
	
// 	$charset_collate = $wpdb->get_charset_collate();
// 	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

// 	//* Create the table
// 	$db = dc_getDb();
// 	$sql = "CREATE TABLE IF NOT EXISTS `$db->dc_floorplans` (
// 		PropertyId INTEGER NOT NULL AUTO_INCREMENT,
// 		FloorplanId TEXT NOT NULL,
// 		FloorplanName TEXT NOT NULL,
// 		Beds INTEGER NOT NULL,
// 		Baths TEXT NOT NULL,
// 		MinimumSQFT INTEGER NOT NULL,
// 		MaximumSQFT INTEGER NOT NULL,
// 		MinimumRent INTEGER NOT NULL,
// 		MaximumRent INTEGER NOT NULL,
// 		MinimumDeposit NUMERIC NOT NULL,
// 		MaximumDeposit NUMERIC NOT NULL,
// 		AvailableUnitsCount INTEGER NOT NULL,
// 		FloorplanImageURL TEXT NOT NULL,
// 		FloorplanImageName TEXT NOT NULL,
// 		PropertyShowsSpecials TEXT NOT NULL,
// 		FloorplanHasSpecials TEXT NOT NULL,
// 		UnitTypeMapping TEXT NOT NULL,
// 		PRIMARY KEY (PropertyId)
// 	) $charset_collate;";
// 	dbDelta( $sql );
// }


register_activation_hook(__FILE__, 'on_activation');
register_deactivation_hook(__FILE__, 'on_deactivation');
