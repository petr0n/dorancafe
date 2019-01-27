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
		add_action( 'parse_query', array( $this, 'dc_disable_page_redirect' ));

	}

	function dc_disable_page_redirect( $query ) {
		if( 'search' == $query->query_vars['pagename'] )
			remove_filter( 'template_redirect', 'redirect_canonical' );
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
			'page' => 'search'
		), $atts));
		ob_start();
		// include('dc_dorancafe.php');
		echo '<div class="dc_wrapper">';
		if( $page == 'unit') {
			include('partials/dc_unit_show.php');
		} else {
			include('partials/dc_unit_search.php');
		}
		echo '</div>';
		return ob_get_clean();
	}

	public function dc_public_get_units( $search_args = array() ) {
		$display_count = isset($_GET['display_count']) ? $_GET['display_count'] : 12; 
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$offset = $page == 1 ? 0 : ($page - 1) * $display_count; 

		if( $search_args ) {
			$sort_by_arr = array (
				'price_high' => 'MaximumRent ASC',
				'price_low'  => 'MaximumRent DESC',
				'size_high'  => 'SQFT ASC',
				'size_low'  => 'SQFT DESC'
			);

			$sort_by_args = 'ORDER BY ApartmentName';
			$args = '';

			foreach ( $search_args as $key => $value ) {
				if ( $value ) {
					if ( $key == 'sort_by' ) {
						$sort_by_args = 'ORDER BY ' . $sort_by_arr[$value] . ', ApartmentName ASC';
					} else if ( $key == 'price' ) {
						$price_range = explode('_', $value);
						$args .= '(MaximumRent > ' . $price_range[0] . ' AND MaximumRent < ' . $price_range[1] . ') AND ';
					} else if ( $key == 'availability' ) {
						$args .= 'AvailableDate < DATE(NOW()) AND ';
					} else if ( $key == 'floor' ) {
						$args .= "ApartmentName LIKE '" . intval($value) . "%' AND ";
					} else if ( $key == 'floorplanname' ) {
						$args .= "FloorplanName = '" . $value . "' AND ";
					} else if ( $key == 'unit_view' ) {
						$args .= "Amenities LIKE '%" . $value . "%' AND ";
					} else if ( strpos($key, 'feature') !== false ) {
						$args .= "Amenities LIKE '%" . $value . "%' AND ";
					} else if ( $key == 'display_count' ) {
						$display_count_arg = filter_var($value, FILTER_SANITIZE_STRING);
					} else if ( $key == 'beds' ) {
						//var_dump($value);
						if (is_numeric($value)) {
							$args .= $key . ' = ' . $value . ' AND ';
						} else {
							if ($value == 'alcove') {
								$args .= $key . ' = 0 AND ';
							} else if ($value == 'Townhome') {
								$args .= "Amenities LIKE '%" . $value . "%' AND ";
							}
						}
					} 
					// else if ( !in_array($key, array('page', 'beds')) ) {
					// 	if (is_numeric((int)$value)) {
					// 		$args .= $key . ' = ' . $value . ' AND ';
					// 	} else {
					// 		$args .= $key . ' = "' . filter_var($value, FILTER_SANITIZE_STRING) . '" AND ';
					// 	}
					// }
				}
			}

			// add search items
			if ( count($search_args) ) {	
				$args = 'WHERE ' . $args . '1=1 ';
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
			// $sql = $wpdb->prepare( $unit_qry, $tbl_name );

			//var_dump($unit_qry);

			$units = $wpdb->get_results( $unit_qry, OBJECT );

			//get total counts
			$unit_ct_qry = 'SELECT COUNT(*) FROM ' . $tbl_name . ' ' . $ct_args;
			$units_ct = $wpdb->get_var( $unit_ct_qry );

			// $display_count_arg = $display_count_arg > $units_ct ? $units_ct : $display_count_arg;

		} else {

			global $wpdb;
			$tbl_name = $wpdb->prefix . 'dc_aptavail';
			$unit_qry = 'SELECT * FROM ' . $tbl_name . ' LIMIT 12';
			// $sql = $wpdb->prepare( $unit_qry, $tbl_name );

			$units = $wpdb->get_results( $unit_qry, OBJECT );
			// $offset_arg = 1;

			//get total counts
			$unit_ct_qry = 'SELECT COUNT(*) FROM ' . $tbl_name;
			$units_ct = $wpdb->get_var( $unit_ct_qry );
		}
		
		if ( $units_ct != 0 ) {
			echo '<div class="dc_viewing">';
			// $offset_arg = rtrim($offset_arg, ',');
			// $start_num = $curr_page > 1 ? $display_count_arg + $offset_arg : 1;
			// $display_count_arg = $start_num > 1 ? $display_count_arg + $offset_arg : $display_count_arg;
			
			$start_num = $offset == 0 ? 1 : $offset + 1;
			$last_num = ($display_count + ($start_num - 1 ));

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
					<h3 class="dc_unit--num">Unit # <?php echo $unit->ApartmentName; ?></h3>
					<div class="dc_unit--meta">
						<div class="dc_beds">Beds: <?php echo $unit->Beds; ?></div>&nbsp;&nbsp;|&nbsp;&nbsp;
						<div class="dc_baths">Baths: <?php echo $unit->Baths; ?></div>&nbsp;&nbsp;|&nbsp;&nbsp;
						<div class="dc_sqft">SQFT: <?php echo $unit->SQFT; ?></div>
					</div>
					<div class="dc_unit--img">
						<!-- 
						-->
							<img src="<?php echo $unit->UnitImageURLs; ?>" alt="<?php echo $unit->ApartmentName; ?>"> 
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

			// page 
			$next_params = $this->dc_remove_url_param($dc_base_url, 'page');
			$next_params .= isset($_GET['page']) ? '&page=' . ($_GET['page'] + 1) : '&page=2';
			

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
			if ($page > 1) {
				$prev_page = (int)$page - 1;
				if ($_SERVER['QUERY_STRING']) {
					$prev_params = $next_params;
					$prev_params = $this->dc_remove_url_param($dc_base_url, 'page');
					$prev_params = $prev_params . '&page=' . $prev_page;

				} else {
					$prev_params = 'page=' . $prev_page;
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
						if ($page > 1) : ?>
							<a href="<?php echo $prev_url; ?>" class="dc_btn prev">&laquo; Previous </a>&nbsp;&nbsp;&nbsp;<?php 
						endif; ?>
						<a href="<?php echo $next_url; ?>" class="dc_btn next">Next &raquo;</a>
					</div>
				</div><?php 
			}
		} else {
			echo '<h3>No matches found.</h3>';
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
		$fp_qry = 'SELECT FloorplanName FROM ' . $tbl_name . ' GROUP BY FloorplanName ORDER BY FloorplanName'; 
		$floorplans = $wpdb->get_results( $fp_qry, OBJECT );
		return $floorplans;
	}

}

