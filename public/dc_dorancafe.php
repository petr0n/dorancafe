<?php 	
echo '<div class="dc_wrapper">';
if(isset($_GET['unit']) && ctype_digit($_GET['unit'])) {
	include('partials/dc_unit_show.php');
} else {
	include('partials/dc_unit_search.php');
}
echo '</div>';
?>
