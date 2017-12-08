<?php 
/*
 * @link   http://www.multidots.com/
 * @since  1.1
 * @package page-visit-counter
 * Plugin Name: Page Visit Counter
 * Plugin URI: http://www.multidots.com/
 * Description: This plugin will count the total visits of your sites pages.
 * Author: Multidots
 * Version: 4.0.4
 * Author URI: http://www.multidots.com/
*/
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-page-visit-counter-activator.php
 */
function activate_page_visit_counter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-page-visit-counter-activator.php';
	class_Page_Visit_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-page-visit-counter-deactivator.php
 */
function deactivate_page_visit_counter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-page-visit-counter-deactivator.php';
	class_Page_visit_Deactivator::deactivate();
}
/**
 * register hook for plugins activate and deactivate.
 */
register_activation_hook( __FILE__, 'activate_page_visit_counter' );
register_deactivation_hook( __FILE__, 'deactivate_page_visit_counter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-page-visit-counter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_page_visit_counter() {

	$plugin = new page_visit_counter();
	$plugin->run();

}

function display_page_total_count($atts) {
	global $wpdb, $wp, $post;
	

	$pageID = (int) $atts['id'];
	
	$html = '';
	
    if ($pageID != '' && is_int($pageID)) {
    
//		$pageID = get_the_ID();
//		
//		if ($pageID == 0) {
//			$pageID = (int) get_option('page_on_front',true);
//			if (empty($pageID) && !isset($pageID)) {
//				$pageID = (int) get_option('page_for_posts',true);
//			}
//		}
//		
//		if ($pageID == 0) {
//			$page = get_option('show_on_front',true);
//			if ($page == 'posts') {
//				$args = array(
//				    'numberposts' => 1,
//				    'orderby' => 'post_date',
//				    'order' => 'DESC',
//				    'post_type' => 'post',
//				    'post_status' => 'publish',
//				    'suppress_filters' => true );
//				    
//				    $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
//				    foreach( $recent_posts as $recent ){
//						$pageID = (int) $recent["ID"];
//					}
//			}
//			
//		}

		$post = get_post($pageID);
	
		if (isset($post) && !empty($post) && $post != null) {
			$fetchSelecetedPostTypes = get_option('wfap_post_type');
			
			$table_name = $wpdb->prefix."page_visit";
		
			$pageCount = $wpdb->get_results("SELECT SUM(page_visit) as total FROM $table_name WHERE `page_id` = $pageID");
			
			$total = (int) $pageCount[0]->total;
			
			$text_color_page_visit = get_option('text_color_page_visit');
			
			if (isset($text_color_page_visit) && $text_color_page_visit != null) {
				$text_color_page_visit = 'style="color: '.$text_color_page_visit.';"';
			} else {
				$text_color_page_visit = 'style="color: #000000;"';
			}
	
			if ($fetchSelecetedPostTypes == '' || $fetchSelecetedPostTypes == null) {
				$html .= '<p id="page-visit-counter-shortcode-block" class="page-visit-counter-block" '.$text_color_page_visit.'><img src="'.site_url().'/wp-content/plugins/page-visit-counter/images/1456175371_vector_65_14.png" /><span id="shortcode_'.$pageID.'" style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor_shortcode">'.$total.'</span>'.__('total visits.','page-visit-counter').'</p>';
			} else {
				$postTypeSelectedEncodeArr = json_decode($fetchSelecetedPostTypes);
				if (in_array($post->post_type,$postTypeSelectedEncodeArr)) {
					$innerSettings = get_post_meta($pageID,'enable_page_count',true);
					if ($innerSettings == '' || $innerSettings == 'yes') {
						$html .= '<p id="page-visit-counter-shortcode-block" class="page-visit-counter-block" '.$text_color_page_visit.'><img src="'.site_url().'/wp-content/plugins/page-visit-counter/images/1456175371_vector_65_14.png" /><span id="shortcode_'.$pageID.'" style="margin-left: 5px;margin-right: 5px;" class="page_amount_visitor_shortcode">'.$total.'</span>'.__('total visits.','page-visit-counter').'</p>';
					}
				}
			}
		} else {
			$html .= __('Please enter the valid post or page id.','page-visit-counter');
		}
    } else {
    	$html .= __('Please enter the valid post or page id.','page-visit-counter');
    }
		
	echo $html;
	//echo $pageID;
	
	
}
add_shortcode('page_visit_counter_md','display_page_total_count');

function page_visit_counter_md_total_sites_visit($atts) {
	global $wpdb;
	
	$backgroundcolor = trim($atts['backgroundcolor']);
	
	if (isset($backgroundcolor) && !empty($backgroundcolor)) {
		$backgroundcolor = $backgroundcolor;
	} else {
		$backgroundcolor = '#ff0000';
	}
	
	$countboxcolor = trim($atts['countboxcolor']);
	if (isset($countboxcolor) && !empty($countboxcolor)) {
		$countboxcolor = $countboxcolor;
	} else {
		$countboxcolor = '#000';
	}
	
	
	$fontcolor = trim($atts['fontcolor']);
	if (isset($fontcolor) && !empty($fontcolor)) {
		$fontcolor = $fontcolor;
	} else {
		$fontcolor = '#FFF';
	}
	
	$bordercolor = trim($atts['bordercolor']);
	if (isset($bordercolor) && !empty($bordercolor)) {
		$bordercolor = $bordercolor;
	} else {
		$fontcolor = '#ff0000';
	}
	
	$table_name = $wpdb->prefix."page_visit_history";
	
	$query = "SELECT COUNT(id) as total FROM $table_name";
	$totalCountResult = $wpdb->get_results($query);
	
	$totalCount = (int) $totalCountResult[0]->total;
	
	$array = str_split($totalCount);

	$text_color_page_visit = get_option('text_color_page_visit');
			
	if (isset($text_color_page_visit) && $text_color_page_visit != null) {
		$text_color_page_visit = 'style="color: '.$text_color_page_visit.';"';
	} else {
		$text_color_page_visit = 'style="color: #000000;"';
	}
	
	$totalVisitsHtml = '';
	
	$totalVisitsHtml .= '<div class="md-pvc-total-reports">';
	$totalVisitsHtml .= '<div class="md-pvc-total-reports-sub" style="background:'.$backgroundcolor.';">';
	foreach ($array as $number) {
		$totalVisitsHtml .= '<span style="border: 1px solid '.$bordercolor.';color:'.$fontcolor.';background:'.$countboxcolor.';">'.$number.'</span>';
	}
	$totalVisitsHtml .= '<span class="text" style="border: 1px solid '.$bordercolor.';color:'.$fontcolor.';background:'.$countboxcolor.';">total sites visits.</span>';
	$totalVisitsHtml .= '</div>';
	$totalVisitsHtml .= '</div>';
	
	echo $totalVisitsHtml;
}
add_shortcode('page_visit_counter_md_total_sites_visit','page_visit_counter_md_total_sites_visit');


run_page_visit_counter();