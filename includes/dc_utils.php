<?php 



function dc_log_me( $contents ){
	$file = DORANCAFE_PATH . 'logs/log.txt';
	$right_now = (new DateTime())->format('Ymd H:i:s');
	$new_contents =  $right_now . ' - ' . $contents . PHP_EOL;
	file_put_contents($file, $new_contents, FILE_APPEND);
}

/*
 * creates & displays notices on plugin activation and other things 
*/

// if (is_admin()) {

// 	/* Debug Plugin Activation errors */
// 	add_action('activated_plugin','dc_plugin_activation_save_error');
// 	function dc_plugin_activation_save_error(){
// 		update_option('dc_plugin_error_message',  ob_get_contents());
// 	}

// 	function dc_plugin_save_message($message){
// 		update_option('dc_plugin_info_message', $message);
// 	}

// 	/* Display Admin Notices */
// 	add_action('admin_notices', 'dc_plugin_notice');
// 	function dc_plugin_notice() {

// 		if (get_option('dc_plugin_error_message')) {
// 			$error = get_option('dc_plugin_error_message');
// 			if ($error !== ''){
// 				echo '<div class="updated"><h2>DoranCafe Error:</h2>';
// 				echo '<pre>';
// 				echo $error;
// 				echo '</pre>';
// 				echo "<h2><a href='?dc_plugin_message_reset=1'>Clear Warnings and Try Plugin Install Again</a></h2>";
// 				echo '</div>';
// 			}
// 		} elseif (get_option('dc_plugin_info_message')) {
// 			$info = get_option('dc_plugin_info_message');
// 			if ($info !== '') {
// 				echo '<div class="updated"><h2>DoranCafe Info:</h2>';
// 				echo '<pre>';
// 				echo $info;
// 				echo '</pre>';
// 				echo '</div>';
// 			}
// 		}

// 	}

// 	/* Reset Error Message */
// 	add_action('admin_init', 'dc_plugin_message_reset');
// 	function dc_plugin_message_reset() {
// 		global $current_user;
// 			if ( isset($_GET['dc_plugin_message_reset']) && '1' == $_GET['dc_plugin_message_reset'] ) {
// 			 update_option('dc_plugin_error_message',  'Message Cleared.'); // clear errors
// 		}
// 	}

// 	/* Misc messages */
// 	function dc_plugin_message_setup( $message ) {
// 		$mess = $message ? $message : 'No errors';
// 		add_option('dc_plugin_error_message',  'Error Log Empty. Run your plugin activation');
// 	}

// 	/* Delete errors/messages on deactivation */
// 	function dc_plugin_message_delete() {
// 		delete_option('dc_plugin_error_message');
// 		delete_option('dc_plugin_info_message');
// 	}

// }

 ?>