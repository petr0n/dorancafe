<?php 
/* used to make api calls 


	1. get data from rentcafe
	2. save data to file
	3. read file and loop through nodes to insert data into db
	
*/



class DoranCafe_API_Services
{
	/**
	 * DoranCafe_API_Services constructor.
	 *
	 * The API actions registered for this plugin
	 */
	public function __construct()
	{
		
		// add_action('wp_ajax_nopriv_dc_get_unit_data', array( $this, 'dc_get_unit_data'));
		// add_action( 'wp_ajax_dc_get_unit_data', array( $this, 'dc_get_unit_data'));
	}

	public function dc_get_unit_data() {

		/* 
		hiding floorplans for now
		
		$get_api_floorplan_url = get_field('rentcafe_api_endpoint', 'options') . '?requestType=floorplan';
		$get_api_floorplan_url .= '&companyCode=' . get_field('company_code', 'options');
		$get_api_floorplan_url .= '&propertyid=' . get_field('property_id', 'options');

		$api_url_floorplan = $_POST['api_url_floorplan'] ? $_POST['api_url_floorplan'] : get_field('');
		$request_floorplan = wp_remote_get( $api_url_floorplan );

		if( is_wp_error( $request_floorplan )) {
			echo 'Uh Oh! wp_remote_get on "request_floorplan" error';
			return false; // Bail early
		}

		// get remote data
		$body_floorplan = wp_remote_retrieve_body( $request_floorplan );

		// save data to local file
		$this->dc_save_file( 'floorplan', $body_floorplan );

		// add new data to db
		$this->dc_insert_floorplan_data();
		*/


		if ( get_field('company_code', 'options') && get_field('rentcafe_api_endpoint', 'options') ) {

			$get_api_aptavail_url = get_field('rentcafe_api_endpoint', 'options') . '?requestType=apartmentAvailability&sortOrder=apartmentName';
			$get_api_aptavail_url .= '&companyCode=' . get_field('company_code', 'options');
			$get_api_aptavail_url .= '&propertyid=' . get_field('property_id', 'options');
			
			// $api_url_aptavail = $_POST['api_url_aptavail'] ? $_POST['api_url_aptavail'] : $get_api_aptavail_url;
			$api_url_aptavail = $get_api_aptavail_url;
			$request_aptavail = wp_remote_get( $api_url_aptavail );

			if( is_wp_error( $request_aptavail )) {
				dc_log_me( 'Uh Oh! wp_remote_get on "request_aptavail" error' );
				return false; // Bail early
			}
			
			// get remote data
			$body_aptavail = wp_remote_retrieve_body( $request_aptavail );

			// save data to local file
			$this->dc_save_file( 'aptavail', $body_aptavail );
			
			// add new data to db
			$this->dc_insert_aptavail_data();
			// dc_get_units();
			die();
		} else {
			
		}
	}


	public function dc_save_file( $filename, $data_to_save ) {
		//Save the JSON string to a text file.
		$today = date('YmdHis');
		$filepath_to_save = DORANCAFE_PATH . 'rentcafe_data/' . $filename . '/' . $filename . '_' . $today . '.txt';
		file_put_contents( $filepath_to_save, $data_to_save);
		dc_log_me( 'dc_' . $filename . '_' . $today . '.txt' );
	}




	public function dc_insert_floorplan_data() {
		$path_to_file = DORANCAFE_PATH . 'rentcafe_data/floorplan/';
		$files = scandir( $path_to_file, SCANDIR_SORT_DESCENDING );
		$newest_file = $files[0];
		$floorplans_json = file_get_contents( $path_to_file . $newest_file );
		$floorplans = json_decode( $floorplans_json );
		if ( $floorplans ) { // file not blank
			global $wpdb;
			$tbl_name = $wpdb->prefix . 'dc_floorplans';
			$delete = $wpdb->query('TRUNCATE TABLE ' . $tbl_name); //delete data first
			foreach( $floorplans as $floorplan ) {
				$wpdb->insert($tbl_name, array(
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
			}
		}
		dc_log_me( 'floorplans data inserted' );
	}



	public function dc_insert_aptavail_data() {
		$path_to_file = DORANCAFE_PATH . 'rentcafe_data/aptavail/';
		$files = scandir( $path_to_file, SCANDIR_SORT_DESCENDING );
		$newest_file = $files[0];
		$json_aptavail = file_get_contents( $path_to_file . $newest_file );
		$aptavails = json_decode( $json_aptavail );
		if ( $aptavails ) { // file not blank
			global $wpdb;
			$tbl_name = $wpdb->prefix . 'dc_aptavail';
			$delete = $wpdb->query('TRUNCATE TABLE ' . $tbl_name); //delete data first
			foreach( $aptavails as $aptavail ) {
				$unit_img = $aptavail->UnitImageURLs[0] ? $aptavail->UnitImageURLs[0] : '';
				$wpdb->insert($tbl_name, array(
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
					"UnitImageURLs"			=> $unit_img,
					"ApplyOnlineURL"		=> $aptavail->ApplyOnlineURL,
					"Specials"				=> $aptavail->Specials,
					"Amenities"				=> $aptavail->Amenities,
					"AvailableDate"			=> $aptavail->AvailableDate
				));
			}
		}
		dc_log_me( 'aptavail data inserted' );
	}


}

