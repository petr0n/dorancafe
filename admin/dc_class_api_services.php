<?php 
/* 
 * used to make api calls 	
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
	}

	public function dc_get_settings() {
		global $wpdb;
		$settings_qry = " 
			SELECT *
			FROM wp_dc_settings
			LIMIT 1";
		$settings = $wpdb->get_results( $settings_qry, OBJECT );
		// var_dump( $units );
		return $settings;
	}

	public function dc_get_unit_data() {

		$settings = $this->dc_get_settings();
		foreach($settings as $s) {
			$EndpointUrls = json_decode($s->EndpointUrl, true);
			// error_log("logging: " . print_r($EndpointUrls, TRUE) );

		}
		$urls = $EndpointUrls['urls'];
		
		if ( $urls ) {
			
			$ctr = 1;
			foreach($urls as $url) {
				
				// $get_api_aptavail_url = $url;
				// $api_url_aptavail = $get_api_aptavail_url;
				$request_aptavail = wp_remote_get( $url );
				
				if( is_wp_error( $request_aptavail )) {
					return false; // Bail early
				}
				
				// get remote data
				$body_aptavail = wp_remote_retrieve_body( $request_aptavail );
				// var_dump('body_aptavail: ', $body_aptavail);

				// save data to local file
				$this->dc_save_file( 'aptavail', $body_aptavail );
				
				// add new data to db
				// var_dump('count: ', count($urls));
				// var_dump('ctr: ', $ctr);
				$this->dc_insert_aptavail_data($ctr !== count($urls));
				
				// dc_get_units();
				++$ctr;
			}
			die();
		} else {
			
		}
	}


	public function dc_save_file( $filename, $data_to_save ) {
		//Save the JSON string to a text file.
		$today = date('YmdHis');
		$filepath_to_save = DORANCAFE_PATH . 'rentcafe_data/' . $filename . '/' . $filename . '_' . $today . '.txt';
		file_put_contents( $filepath_to_save, $data_to_save);
		// dc_log_me( 'dc_' . $filename . '_' . $today . '.txt' );
	}


	public function dc_insert_aptavail_data($isNewDataSet) {
		$path_to_file = DORANCAFE_PATH . 'rentcafe_data/aptavail/';
		$files = scandir( $path_to_file, SCANDIR_SORT_DESCENDING );
		$newest_file = $files[0];
		$json_aptavail = file_get_contents( $path_to_file . $newest_file );
		$aptavails = json_decode( $json_aptavail );
		if ( $aptavails ) { // file not blank
			global $wpdb;
			$tbl_name = $wpdb->prefix . 'dc_aptavail';
			// var_dump('aptavails: ', $aptavails);

			$wpdb->query('TRUNCATE TABLE ' . $tbl_name); //delete data first
			// if ($isNewDataSet){ // need to fix logic later
			// }
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
					"Baths"					=> floatval($aptavail->Baths),
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
				// var_dump("Baths " . floatval($aptavail->Baths));
			}
		}
		// dc_log_me( 'aptavail data inserted' );
	}

}

