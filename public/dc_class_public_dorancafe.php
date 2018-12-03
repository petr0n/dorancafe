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

	private $dbs;
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

		// get js and css
		add_action('init', array( $this, 'dc_public_load_assets' ) );
		add_shortcode('dorancafe', array( $this, 'dc_public_shortcode' ));

		// $this->dc_public_get_units();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function dc_public_load_assets() {
		wp_enqueue_style( $this->plugin_name, DORANCAFE_URL . 'public/dist/dc_public_app.css', array(), $this->version, 'all' );
		wp_enqueue_script( $this->plugin_name, DORANCAFE_URL . 'public/dist/dc_public_app.js', array(), $this->version, false );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function dc_public_shortcode() {
		include_once( 'dc_searchform.php' );
	}

	public function dc_public_get_units( $search_args = array() ) {

		$sort_by_arr = array (
			'price_high' => 'MaximumRent ACS',
			'price_low'  => 'MaximumRent DESC',
			'size_high'  => 'SQFT ACS',
			'size_low'  => 'SQFT DESC'
		);

		$sort_by_args = 'ORDER BY ApartmentName';
		$args = '';

		foreach ( $search_args as $key => $value ) {
			if ( $value ) {
				if ( $key == 'sort_by' ) {
					$sort_by_args = 'ORDER BY ' . $sort_by_arr[$value] . ', ApartmentName';
				} else if ( $key == 'price' ) {
					$price_range = explode('_', $value);
					$args .= '(MaximumRent > ' . $price_range[0] . ' AND MaximumRent < ' . $price_range[1] . ') AND ';
				} else if ( $key == 'availability' ) {
					$args .= 'AvailableDate < DATE(NOW()) AND ';
				} else if ( $key == 'floor' ) {
					$args .= "ApartmentName LIKE '" . intval($value) . "%' AND ";
				} else if ( $key == 'unit_view' ) {
					$args .= "Amenities LIKE '%" . $value . "%' AND ";
				} else {
					$args .= $key . ' = "' . filter_var($value, FILTER_SANITIZE_STRING) . '" AND ';
				}
			}
		}

		// add search items
		if ( count($search_args) )
			$args = 'WHERE ' . $args . '1=1 ';
		
		// add sorting
		$args .= $sort_by_args;

		global $wpdb;
		$tbl_name = $wpdb->prefix . 'dc_aptavail';
		$unit_qry = 'SELECT * FROM ' . $tbl_name . ' ' . $args;

		$sql = $wpdb->prepare( $unit_qry, $tbl_name );

		$units = $wpdb->get_results( $sql, OBJECT );
		// loop through grouped floorplans
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
					echo '<td>$' . $unit->MaximumRent . '</td>';
					echo '<td>' . $unit->Amenities . '</td>';
					echo '<td>' . $unit->AvailableDate . '</td>';
					echo '</tr>';
				endforeach;
			echo '</tbody></table>';
		} else {
			echo '<h3>No matches found.</h3>';
		}
		/*  */
	}

	public function dc_public_get_floorplans(){
		global $wpdb;
		$tbl_name = $wpdb->prefix . 'dc_aptavail';
		$fp_qry = 'SELECT FloorplanName FROM ' . $tbl_name . ' GROUP BY FloorplanName ORDER BY FloorplanName'; 
		$floorplans = $wpdb->get_results( $fp_qry, OBJECT );
		return $floorplans;
	}

}
$dorancafe_public = new DoranCafe_Public( 'DORANCAFE_PLUGIN', '1.0.0-alpha' );
