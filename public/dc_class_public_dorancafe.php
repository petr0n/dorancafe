<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://peterskitchen.co
 * @since      1.0.0
 *
 * @package    Dorancafe
 * @subpackage Dorancafe/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dorancafe
 * @subpackage Dorancafe/public
 * @author     Peter Abeln <petron@gmail.com>
 */



class DoranCafe_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		// $this->dc_public_get_units();

		add_shortcode('dorancafe', array( $this, 'dc_public_shortcode' ));
	
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function dc_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, DORANCAFE_URL . 'public/dist/dc_public_app.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function dc_enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, DORANCAFE_URL . 'public/dist/dc_public_app.js', array( 'jquery' ), $this->version, false );
	}


	/**
	 * Register the short code
	 *
	 * @since    1.0.0
	 */
	public function dc_public_shortcode($atts) {
		extract(shortcode_atts(array(
			'dc_page' => 'search'
		), $atts));
		ob_start();
		// include('dc_dorancafe.php');
		echo '<div class="dc_wrapper">';
		if( $dc_page == 'unit') {
			include('partials/dc_unit_show.php');
		} else if( $dc_page == 'restricted') {
			include('partials/dc_unit_custom.php');
		} else {
			include('partials/dc_unit_search.php');
		}
		echo '</div>';
		return ob_get_clean();
	}

	public function dc_public_get_units( $search_args = array() ) {
		$display_count = isset($_GET['display_count']) ? $_GET['display_count'] : 12; 
		$dc_page = isset($_GET['dc_page']) ? $_GET['dc_page'] : 1;
		$offset = $dc_page == 1 ? 0 : ($dc_page - 1) * $display_count; 


		if( $search_args ) {
			$sort_by_arr = array (
				'price_high' => 'MaximumRent DESC',
				'price_low'  => 'MaximumRent ASC',
				'size_high'  => 'SQFT DESC',
				'size_low'  => 'SQFT ASC'
			);

			$sort_by_args = 'ORDER BY ApartmentName';
			$args = '';


			foreach ( $search_args as $key => $value ) {
				if ( $value ) {
					if ( $key == 'sort_by' ) {
						// $sort_by_args = 'ORDER BY ' . $sort_by_arr[$value] . ', ApartmentName ASC';
						$sort_by_args = 'ORDER BY ' . $sort_by_arr[$value];

					} else if ( $key == 'price' ) {
						$price_range = explode('_', $value);
						$args .= '(MaximumRent > ' . $price_range[0] . ' AND MaximumRent < ' . $price_range[1] . ') AND ';

					} else if ( $key == 'availability' ) {
						if ($value == 'available') {
							$args .= 'TRIM(AvailableDate) != "" AND ';
						} else if ($value == 'unavailable'){
							$args .= 'TRIM(AvailableDate) = "" AND ';
						} else {

						}

					} else if ( $key == 'floorplanname' ) {
						$args .= "FloorplanName = '" . $value . "' AND ";
					
					} else if ( $key == 'unit_view' ) {
						$args .= "Amenities LIKE '%" . $value . "%' AND ";
					
					} else if ( strpos($key, 'feature') !== false ) {
						$args .= "Amenities LIKE '%" . $value . "%' AND ";
					
					} else if ( $key == 'display_count' ) {
						$display_count_arg = filter_var($value, FILTER_SANITIZE_STRING);
					
					} else if ( $key == 'beds' ) {
						if (is_numeric($value)) {
							$args .= $key . ' = ' . $value . ' AND ';
						} else {
							if ($value == 'studio') {
								$args .= "Amenities LIKE '%studio%' AND ";
							} else if ($value == 'alcove') {
								$args .= "Amenities LIKE '%alcove%' AND ";	
							} else if ($value == 'Townhome') {
								$args .= "Amenities LIKE '%Townhome%' AND ";
							}
						}

					} else if ( $key == 'baths' ) {
						$args .= $key . ' = ' . filter_var($value, FILTER_SANITIZE_STRING) . ' AND ';

					} else if ( $key === 'floor' ) {
						$floor = '1st';
						$floorNum = intval($value);
						if ($floorNum === 2) {
							$floor = '2nd';
						} else if ($floorNum === 3) {
							$floor = '3rd';
						} else if ($floorNum === 4 || $floorNum === 5 || $floorNum === 6) {
							$floor = $floorNum . 'th';
						}
						$args .= 'Amenities LIKE "%' . $floor . ' Floor%" AND ';
					}
				}
			}


			// add search items
			if ( count($search_args) ) {	
				// $args = 'WHERE ' . $args . '1=1 ';
				$args = 'WHERE ' . $args . 'Amenities NOT LIKE "%Income Restricted%" ';
				$ct_args = $args;
			} 

			// add sorting
			$args .= $sort_by_args;

			// add record limit 
			// LIMIT 12 OFFSET 12 returns 13-24
			$offset_arg = $offset == 0 ? '' : ' OFFSET ' . $offset;
			$args .= ' LIMIT ' . $display_count . $offset_arg;



			global $wpdb;
			$tbl_name = $wpdb->prefix . 'dc_aptavail';
			$unit_qry = 'SELECT * FROM ' . $tbl_name . ' ' . $args;

			$units = $wpdb->get_results( $unit_qry, OBJECT );

			//get total counts
			$unit_ct_qry = 'SELECT COUNT(*) FROM ' . $tbl_name . ' ' . $ct_args;
			// var_dump($unit_qry);
			$units_ct = $wpdb->get_var( $unit_ct_qry );

		} else {

			global $wpdb;
			$tbl_name = $wpdb->prefix . 'dc_aptavail';

			$unit_qry = 'SELECT * FROM ' . $tbl_name . ' WHERE Amenities NOT LIKE "%Income Restricted%" LIMIT 12';
			// $sql = $wpdb->prepare( $unit_qry, $tbl_name );

			$units = $wpdb->get_results( $unit_qry, OBJECT );
			// $offset_arg = 1;

			//get total counts
			$unit_ct_qry = 'SELECT COUNT(*) FROM ' . $tbl_name . ' WHERE Amenities NOT LIKE "%Income Restricted%"';

			// var_dump($unit_qry);
			$units_ct = $wpdb->get_var( $unit_ct_qry );
		}
		
		// var_dump($unit_qry);
		
		if ( $units_ct != 0 ) {
			echo '<div class="dc_viewing">';
			
			$start_num = $offset == 0 ? 1 : $offset + 1;
			$last_num = ($display_count + ($start_num - 1 ));

			// if the unit_ct is less than last_num be last num
			$last_num = $units_ct < $last_num ? $units_ct : $last_num;

			echo 'You are viewing units ' . $start_num . ' - ' . $last_num . ' of ' . $units_ct . ' results';
			echo '</div>';
		}
		echo '<div class="dc_results">';
		if ( $units ) { 
			global $post;
			$post_slug=$post->post_name;
			foreach( $units as $unit ) : ?>
			
			<a class="dc_unit" href="/unit/<?php echo $unit->ApartmentName; ?>/">
				<div class="dc_unit-inner">
					<h3 class="dc_unit--name">
						<?php echo $unit->FloorplanName; ?><br>
					</h3>
					<h2 class="dc_unit--num">
						<?php echo $unit->ApartmentName; ?>
					</h2>
					<div class="dc_unit--meta">
						<div class="dc_beds">Beds: <?php echo $unit->Beds; ?></div>&nbsp;&nbsp;|&nbsp;&nbsp;
						<div class="dc_baths">Baths: <?php echo floatval($unit->Baths); ?></div>&nbsp;&nbsp;|&nbsp;&nbsp;
						<div class="dc_sqft">SQFT: <?php echo $unit->SQFT; ?></div>
					</div>
					<div class="dc_unit--img">
						<img src="<?php echo $this->dc_get_unit_image($unit->UnitImageURLs); ?>" alt="<?php echo $unit->ApartmentName; ?>"> 
					</div>
				</div>
				<div class="dc_bottom-bar"></div>
			</a>
		<?php
			endforeach; 
			echo '</div>'; 

			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	
			// defaults 
			$dc_base_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			
			// echo 'dc_base_url: ' . $dc_base_url;

			$path = parse_url($dc_base_url, PHP_URL_PATH);
			$base_url = $protocol . $_SERVER['HTTP_HOST'] . $path . '?';

			$next_params = '';
			$prev_params = '';

			// dc_page 
			$next_params = $this->dc_remove_url_param($dc_base_url, 'dc_page');
			$next_params .= isset($_GET['dc_page']) ? '&dc_page=' . ($_GET['dc_page'] + 1) : '&dc_page=2';
			

			// echo '<hr>';
			// echo 'base_url + next_params: ' . $base_url . $next_params; 
			
			// display_count 
			$next_params = $this->dc_remove_url_param($base_url . $next_params, 'display_count');
			$next_params .= isset($_GET['display_count']) ? 
				'&display_count=' . $_GET['display_count'] : 
				'&display_count=' . $display_count;

			// echo '<hr>';
			// echo 'next_params: ' . $next_params; 

			// previous 
			if ($dc_page > 1) {
				$prev_page = (int)$dc_page - 1;
				if ($_SERVER['QUERY_STRING']) {
					$prev_params = $next_params;
					$prev_params = $this->dc_remove_url_param($dc_base_url, 'dc_page');
					$prev_params = $prev_params . '&dc_page=' . $prev_page;

				} else {
					$prev_params = 'dc_page=' . $prev_page;
				}
			}


			if (substr($next_params, 0, strlen('&')) == '&') {
				$next_params = substr($next_params, strlen('&'));
			} 
			if (substr($prev_params, 0, strlen('&')) == '&') {
				$prev_params = substr($prev_params, strlen('&'));
			} 
			$next_url = $base_url . $next_params . '#dc_search_form';
			$prev_url = $base_url . $prev_params . '#dc_search_form';


			if ( $units_ct != 0 && $units_ct != $display_count ) { ?>
				<div class="dc_pagination inactive">
					<div class="dc_pagination-inner"><?php 
						if ($dc_page > 1) : ?>
							<a href="<?php echo $prev_url; ?>" class="dc_btn prev">&laquo; Previous </a>&nbsp;&nbsp;&nbsp;<?php 
						endif; 
						if ($units_ct != $last_num) : ?>
							<a href="<?php echo $next_url; ?>" class="dc_btn next">Next &raquo;</a><?php 
						endif; ?>
					</div>
				</div><?php 
			}
		} else {
			echo '<h3>No matches found.</h3>';
		}
		
	}


	public function dc_get_unit_image($imgUrls, $returnFloorplate = false) {
		$urls = explode(',', $imgUrls);
		foreach( $urls as $url ) {
			
			
			// var_dump($thisUrl);
			if (strpos(strtolower($url), 'floorplate') !== false && $returnFloorplate) {
				return $url;
			} else if (!$returnFloorplate) {
				return $url;
			}
		}
		// return $ret;
	}


	public function dc_public_get_custom_units( ) {

		global $wpdb;
		$tbl_name = $wpdb->prefix . 'dc_aptavail';
		$unit_qry = 'SELECT * FROM ' . $tbl_name;
		$unit_qry .= ' WHERE Amenities LIKE "%Income Restricted%" AND TRIM(AvailableDate) != "" ';

		//var_dump($unit_qry);
		$units = $wpdb->get_results( $unit_qry, OBJECT );

		//get total counts
		$units_ct = count($units);

		if ( $units_ct != 0 ) {
			echo '<div class="dc_viewing">';
			echo 'You are viewing units ' . $units_ct;
			echo '</div>';
		}
		echo '<div class="dc_results">';
		if ( $units ) { 
			global $post;
			$post_slug=$post->post_name;
			foreach( $units as $unit ) : 
		
				?>
			
			<a class="dc_unit" href="/unit/<?php echo $unit->ApartmentName; ?>/">
				<div class="dc_unit-inner">
					<h3 class="dc_unit--num">Unit # <?php echo $unit->ApartmentName; ?></h3>
					<div class="dc_unit--meta">
						<div class="dc_beds">Beds: <?php echo $unit->Beds; ?></div>&nbsp;&nbsp;|&nbsp;&nbsp;
						<div class="dc_baths">Baths: <?php echo $unit->Baths; ?></div>&nbsp;&nbsp;|&nbsp;&nbsp;
						<div class="dc_sqft">SQFT: <?php echo $unit->SQFT; ?></div>
					</div>
					<div class="dc_unit--img">
							<img src="<?php echo $unit->UnitImageURLs; ?>" alt="<?php echo $unit->ApartmentName; ?>"> 
					</div>
				</div>
				<div class="dc_bottom-bar"></div>
			</a><?php
			
			endforeach; 
			echo '</div>'; 
		} else {
			echo '<h3>There are no income restricted units currently available.</h3>';
		}
	}

	function dc_remove_url_param($url, $param){
		$my_url = parse_url($url);
		if (array_key_exists('query', $my_url)) {
			parse_str($my_url['query'], $get);
			unset($get[$param]);
			$my_url['query'] = http_build_query($get);
			return $my_url['query'];
		} else {
			return '';
		}
	}
	function querystring($strQS, $arRemove, $arAdd = NULL) {
		parse_str($strQS, $arQS);
		$arQS = array_diff_key($arQS, array_flip($arRemove));
		$arQS = $arQS + $arAdd;
		return http_build_query($arQS);
	}

	public function dc_public_get_unit_by_id( $unit ) {
		global $wpdb;
		$tbl_name = $wpdb->prefix . 'dc_aptavail';
		$unit_qry = 'SELECT 
			AptAvailTblId, 
			PropertyId, 
			VoyagerPropertyId, 
			VoyagerPropertyCode, 
			FloorplanId, 
			FloorplanName, 
			ApartmentId, 
			a.ApartmentName as ApartmentName, 
			Beds, 
			Baths, 
			SQFT, 
			MinimumRent, 
			MaximumRent, 
			Deposit, 
			ApplyOnlineURL, 
			UnitImageURLs, 
			Specials, 
			Amenities, 
			AvailableDate, 
			UnitPDF,
			f.FileName
			FROM wp_dc_aptavail as a
				LEFT JOIN wp_dc_unit_files as f 
					ON a.ApartmentName = f.ApartmentName
			WHERE a.ApartmentName = ' . $unit; 
		$unit = $wpdb->get_results( $unit_qry, ARRAY_A );
		return $unit;
	}

	public function dc_public_get_floorplans(){
		global $wpdb;
		$tbl_name = $wpdb->prefix . 'dc_aptavail';
		$fp_qry = 'SELECT FloorplanName FROM ' . $tbl_name . ' WHERE Amenities NOT LIKE "%Income Restricted%" GROUP BY FloorplanName ORDER BY FloorplanName'; 
		$floorplans = $wpdb->get_results( $fp_qry, OBJECT );
		return $floorplans;
	}

}

