<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    page-visit-counter
 * @subpackage page-visit-counter/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    page-visit-counter
 * @subpackage page-visit-counter/admin
 * @author     Multidots <wordpress@multidots.com>
 */
class page_visit_counter_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */

	public function enqueue_styles() {
		
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Extra_Flat_Rate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Extra_Flat_Rate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		//wp_enqueue_style("jquery-ui-tabs");
		
		wp_enqueue_style('custom-style', plugin_dir_url( __FILE__ ) . 'css/style.css');
		wp_enqueue_style('datatable-style', plugin_dir_url( __FILE__ ) . 'css/jquery.dataTables.css');
		wp_enqueue_style('jquery-style', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css');
		wp_enqueue_style('chosen-style', plugin_dir_url( __FILE__ ) . 'css/chosen.css');
		//wp_enqueue_style('fancy-box-style', plugin_dir_url( __FILE__ ) . 'css/jquery.fancybox-1.3.4.css');
		wp_enqueue_style('color-box-style', plugin_dir_url( __FILE__ ) . 'css/colorbox.css');
		//wp_enqueue_style('color-picker', plugin_dir_url( __FILE__ ) . 'css/color-picker.min.css');
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'wp-pointer' );
	}
	
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Extra_Flat_Rate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Extra_Flat_Rate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-datepicker');	
		//wp_deregister_style( 'wp-jquery-ui-dialog' );
		//wp_enqueue_script( 'wp-jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		
		//enqueue script for notice pointer
		wp_enqueue_script( 'wp-pointer' );
        
		if (!empty($_GET['page']) && $_GET['page'] != '' && $_GET['page'] == 'page_visit_counter') {
		wp_enqueue_script('one', plugin_dir_url( __FILE__ ) . 'js/custom.js', array( 'jquery' ), $this->version, false );
        }
        if (!empty($_GET['page']) && $_GET['page'] != '' && $_GET['page'] == 'page_visit_settings') {
		wp_enqueue_script('one', plugin_dir_url( __FILE__ ) . 'js/custom.js', array( 'jquery' ), $this->version, false );
        }
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );

		//wp_enqueue_script('google-chart', 'https://www.gstatic.com/charts/loader.js', array( 'jquery' ), $this->version);
				
		wp_enqueue_script('chosen-jquery', plugin_dir_url( __FILE__ ) . 'js/chosen.jquery.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('chosen-proto', plugin_dir_url( __FILE__ ) . 'js/chosen.proto.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('color-box', plugin_dir_url( __FILE__ ) . 'js/jquery.colorbox.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script('iris', admin_url('js/iris.min.js'),array('jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch'), false, 1);
    	wp_enqueue_script('wp-color-picker', admin_url('js/color-picker.min.js'), array('iris'), false,1);
    	
    	$colorpicker_l10n = array('clear' => __('Clear'), 'defaultString' => __('Default'), 'pick' => __('Select Color'));
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );
		
		wp_localize_script( 'one', 'pagevisit', array('ajaxurl' => admin_url( 'admin-ajax.php')));
		
		$fetchSelecetedPostTypes = get_option('wfap_post_type');
		$options =  !empty( $fetchSelecetedPostTypes ) ? $fetchSelecetedPostTypes : json_encode( array() );
		wp_localize_script( 'one', 'get_post_option', array('optionsarray' => $options));
		
		$fetchSelecetedIpAddress = get_option('ipaddress_visit');
		$optionsIpAddress =  !empty( $fetchSelecetedIpAddress ) ? $fetchSelecetedIpAddress : json_encode( array() );
		wp_localize_script( 'one', 'get_ip_option', array('ipaddressarray' => $optionsIpAddress));
		
		$fetchSelecetedUserId = get_option('userlist_visit');
		$optionsUserId =  !empty( $fetchSelecetedUserId ) ? $fetchSelecetedUserId : json_encode( array() );
		wp_localize_script( 'one', 'get_user_option', array('usersarray' => $optionsUserId));
		
	}
	
	
	public function welcome_page_visit_counter_screen_do_activation_redirect() {
		// if no activation redirect
		if (!get_transient('_welcome_screen_page_visitor_activation_redirect_data')) {
			return;
		}

		// Delete the redirect transient
		delete_transient('_welcome_screen_page_visitor_activation_redirect_data');

		// if activating from network, or bulk
		if (is_network_admin() || isset($_GET['activate-multi'])) {
			return;
		}
		// Redirect to extra cost welcome  page
		wp_safe_redirect(add_query_arg(array('page' => 'page-visit-counter-about&tab=about'), admin_url('index.php')));
	}
	
	public function welcome_pages_screen_page_visit_counter() {
		add_dashboard_page(
		'Page Visit counter Dashboard', 'Page Visit counter Dashboard', 'read', 'page-visit-counter-about', array(&$this, 'welcome_screen_content_page_visit_counter')
		);
	}
	
	public function admin_css() {
		wp_enqueue_style($this->plugin_name . 'welcome-page', plugin_dir_url(__FILE__) . 'css/style.css', array(), $this->version, 'all');
	}
	
	public function welcome_screen_content_page_visit_counter() {
        ?>
        <div class="wrap about-wrap">
            <h1 style="font-size: 2.1em;"><?php printf(__('Welcome to Page Visit Counter', 'page-visit-counter')); ?></h1>

            <div class="about-text woocommerce-about-text">
        <?php
        $message = '';
        printf(__('%s This plugin will count the total visits of your sites pages.', 'page-visit-counter'), $message, $this->version);
        ?>
                <img class="version_logo_img" src="<?php echo plugin_dir_url(__FILE__) . 'images/page_visit_counter.png'; ?>">
            </div>

        <?php
        $setting_tabs_wc = apply_filters('page_visit_counter_setting_tab', array("about" => "Overview", "other_plugins" => "Checkout our other plugins"));
        $current_tab_wc = (isset($_GET['tab'])) ? $_GET['tab'] : 'general';
        $aboutpage = isset($_GET['page'])
        ?>
            <h2 id="woo-extra-cost-tab-wrapper" class="nav-tab-wrapper">
            <?php
            foreach ($setting_tabs_wc as $name => $label)
            echo '<a  href="' . home_url('wp-admin/index.php?page=page-visit-counter-about&tab=' . $name) . '" class="nav-tab ' . ( $current_tab_wc == $name ? 'nav-tab-active' : '' ) . '">' . $label . '</a>';
            ?>
            </h2>

                <?php
                foreach ($setting_tabs_wc as $setting_tabkey_wc => $setting_tabvalue) {
                	switch ($setting_tabkey_wc) {
                		case $current_tab_wc:
                			do_action('page_visit_counter_' . $current_tab_wc);
                			break;
                	}
                }
                ?>
            <hr />
            <div class="return-to-dashboard">
                <a href="<?php echo home_url('/wp-admin/admin.php?page=page_visit_settings'); ?>"><?php _e('Go to Page Visit Counter Settings', 'page-visit-counter'); ?></a>
            </div>
        </div>
        <?php
	}
	
	/**
     * Extra flate rate overview welcome page content function
     *
     */
	public function page_visit_counter_about() {
		//do_action('my_own');
		$current_user = wp_get_current_user();

    	?>
        <div class="changelog">
        	
            </br>
           	<style type="text/css">
				p.page_visit_overview {max-width: 100% !important;margin-left: auto;margin-right: auto;font-size: 15px;line-height: 1.5;}.Page_Counter_Settings_Content_ul ul li {margin-left: 3%;list-style: initial;line-height: 23px;}
			</style>  
            <div class="changelog about-integrations">
                <div class="wc-feature feature-section col three-col">
                    <div>
                        <p class="page_visit_overview"><?php _e('This Plugin use for front side post and pages counter. After activation of plugin it will automatically add page counts on bottom of all pages. So, that all visitors can see page counts for entire site pages. Plugin provide search by page title and search by page published date facilities. Settings are required for page counter. Plugin provide to select specific post type to include in post /pages counter. Plugin also provide to exclude specific IP/s and specific register user to exude from post/pages counter.', 'page-visit-counter'); ?></p>
                        <p class="page_visit_overview"><strong>Page Counter Settings: </strong></p> 
                        <div class="Page_Counter_Settings_Content_ul">
                        	<ul>
								<li>In these options you can do different setting for page visit counter.</li>
								<li>Short Code:  There are two shortcuts that you can use to manually add page view count to any content on admin or post/page template created by your theme or plugin that's creating its own display content in a page / post.</li>
								<li>Post Type:  You can select the post type from the drop down menu for which post views will be counted. If you leave blank on post type, then all pages or all past type posts will be counted.</li>
								<li>Exclude IPs (Ip Address):  Enter the IP addresses which you want to be excluded from post views count.</li>
								<li>Exclude Users:  Select users from your project/system to be excluded from post view count.</li>
								<li>Show front view counter:  Check the box if you want to display counter view on front end.</li>
								<li>Choose color for the front end view:  select color from color picker to choose the color for display visit pages text on front side as well as in the shortcode.</li>
							</ul>
                        </div>
                        
                        <p class="page_visit_overview"><strong>Page Counter Settings: </strong></p>  
                        
                        <p class="page_visit_overview">In this option you can see all pages listing within Page ID, Page Title and Total Count. It will display all pages of your site. If you excluded particular post type from page visit counter then also it will display that post type, posts pages on table but it will not count those pages and "total count" will be "0" for excluded post type, post pages.</p>
                        
                        <div class="Page_Counter_Settings_Content_ul">
                        	<ul>
									<li>Search facility:  This provides you the extra facility to search pages by title and search page by its crated date.</li>
									<li>Sharing facility:  This provides you to share specific page on Facebook, Twitter and Google Plus.</li>
									<li>Reports:  This provides you the specific page vise reports like Top browsers, Top 10 IP address, Top referer, weekly report and Monthly report using chart.</li>
						</ul>
                        </div>
                        	
                        
                    </div>
                    
                </div>
            </div>
        </div>
        <?php 
        if (!get_option('pvcp_plugin_notice_shown')) {
   			 echo '<div id="pvcp_dialog" title="Basic dialog"> <p> Subscribe for latest plugin update and get notified when we update our plugin and launch new products for free! </p> <p><input type="text" id="txt_user_sub_pvcp" class="regular-text" name="txt_user_sub_pvcp" value="'.$current_user->user_email.'"></p></div>';
   			
		?>
        
          
        <script type="text/javascript">

        jQuery( document ).ready(function() {
        	jQuery( "#pvcp_dialog" ).dialog({
        		modal: true, title: 'Subscribe Now', zIndex: 10000, autoOpen: true,
        		width: '500', resizable: false,
        		position: {my: "center", at:"center", of: window },
        		dialogClass: 'dialogButtons',
        		buttons: {
        			Yes: function () {
        				// $(obj).removeAttr('onclick');
        				// $(obj).parents('.Parent').remove();
        				var email_id = jQuery('#txt_user_sub_pvcp').val();
        				var data = {
        				'action': 'add_plugin_user_pvcp',
        				'email_id': email_id
        				};

        				// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        				jQuery.post(ajaxurl, data, function(response) {
        					jQuery('#pvcp_dialog').html('<h2>You have been successfully subscribed');
        					jQuery(".ui-dialog-buttonpane").remove();
        				});

        				
        			},
        			No: function () {
        					var email_id = jQuery('#txt_user_sub_pvcp').val();

        				var data = {
        				'action': 'hide_subscribe_pvcpfn',
        				'email_id': email_id
        				};

        				// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        				jQuery.post(ajaxurl, data, function(response) {
        					        					
        				});
        				
        				jQuery(this).dialog("close");
        				
        			}
        		},
        		close: function (event, ui) {
        			jQuery(this).remove();
        		}
        	});
        	jQuery("div.dialogButtons .ui-dialog-buttonset button").addClass("button-primary woocommerce-save-button");
        	jQuery("div.dialogButtons .ui-dialog-buttonpane .ui-button").css("width","80px");
        });
        </script>
        <?php
        
        } 
	}

	/**
     * Extra flate rate other plugin  welcome page content function
     *
     */
	public function page_visit_counter_other_plugins() { 
		global $wpdb;
         $url = 'http://www.multidots.com/store/wp-content/themes/business-hub-child/API/checkout_other_plugin.php';
    	 $response = wp_remote_post( $url, array('method' => 'POST',
    	'timeout' => 45,
    	'redirection' => 5,
    	'httpversion' => '1.0',
    	'blocking' => true,
    	'headers' => array(),
    	'body' => array('plugin' => 'advance-flat-rate-shipping-method-for-woocommerce'),
    	'cookies' => array()));
    	
    	$response_new = array();
    	$response_new = json_decode($response['body']);
		$get_other_plugin = maybe_unserialize($response_new);
		
		$paid_arr = array();
		?>

        <div class="plug-containter">
        	<div class="paid_plugin">
        	<h3>Paid Plugins</h3>
	        	<?php foreach ($get_other_plugin as $key=>$val) { 
	        		if ($val['plugindesc'] =='paid') {?>
	        			
	        			
	        		   <div class="contain-section">
	                <div class="contain-img"><img src="<?php echo $val['pluginimage']; ?>"></div>
	                <div class="contain-title"><a target="_blank" href="<?php echo $val['pluginurl'];?>"><?php echo $key;?></a></div>
	            </div>	
	        			
	        			
	        		<?php }else {
	        			
	        			$paid_arry[$key]['plugindesc']= $val['plugindesc'];
	        			$paid_arry[$key]['pluginimage']= $val['pluginimage'];
	        			$paid_arry[$key]['pluginurl']= $val['pluginurl'];
	        			$paid_arry[$key]['pluginname']= $val['pluginname'];
	        		
	        	?>
	        	
	         
	            <?php } }?>
           </div>
           <?php if (isset($paid_arry) && !empty($paid_arry)) {?>
           <div class="free_plugin">
           	<h3>Free Plugins</h3>
                <?php foreach ($paid_arry as $key=>$val) { ?>  	
	            <div class="contain-section">
	                <div class="contain-img"><img src="<?php echo $val['pluginimage']; ?>"></div>
	                <div class="contain-title"><a target="_blank" href="<?php echo $val['pluginurl'];?>"><?php echo $key;?></a></div>
	            </div>
	            <?php } }?>
           </div>
          
        </div>

    <?php
	}

	/**
     * Remove the Extra flate rate menu in dashboard
     *
     */
	public function welcome_screen_remove_menus() {
		remove_submenu_page('index.php', 'page-visit-counter-about');
	}
	
	/**
	 * admin menu page fnction
	 * add menu in admin menubar.
	 *
	 */
	public function page_visit_counter_menu() {
		add_menu_page( __('Page-Visit-Counter','page-visit-counter'),__('PageVisitCounter','page-visit-counter'), 'manage_options','page_visit_counter', 'extra_page_visit_function_custom',plugins_url('page-visit-counter/admin/images/icon.png'));
		add_submenu_page('page_visit_counter',__('Counter-Settings','page-visit-counter'),__('Settings','page-visit-counter'),'manage_options','page_visit_settings','custom_page_visit_settings');
		/**
		 * extra_page_visit_function_custom use the menu callback function
		 * $name pass the arguments
		 */
		function extra_page_visit_function_custom($name) {
			global $wpdb;
			
			if ( ! class_exists( 'WP_List_Table' ) ) {
				require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
			}
			
			require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tt-pvc-list-table.php';
			
			// Create an instance of our package class.
			$test_list_table = new TT_Example_List_Table();
			// Fetch, prepare, sort, and filter our data.
			$test_list_table->prepare_items();
			
			$table_name = $wpdb->prefix."page_visit";
			?>
			
			
			<div class="main-page-visit set_pvc_containter">
				<div class="page-title">
					<h1><?php echo __('Page Visit Counter', 'page-visit-counter'); ?></h1>
				</div>
				
				<?php
					if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) { ?>
						<style type="text/css">
							.tabs div#chartContainer-main {float:left;width:50%;}
							.tabs div#chartContainer1-main {float:left;width:50%;}
							.tabs div#chartContainer2-main {float:left;width:50%;}
							.tabs div#chartContainer3-main {float:left;width:50%;}
							.tabs div#chartContainer5-main {float:left;width:50%;}
						</style>
						<div class="back"><h5><a class="button button-primary" href="<?php echo site_url()?>/wp-admin/admin.php?page=page_visit_counter">&#x2190; Back to list</a></h5></div>
						<div style="">
							<div id="page-vist-fancybox" class="page-counter-fancybox">
								<div id="tabs">
									<div id="chartContainer-main">
									    	<span>Top Browsers</span>
										<div id="chartContainer" style="width: 100%; height: 500px;"></div>
									</div>
									<div id="chartContainer1-main">
										<span>Top 10 IP address</span>
										<div id="chartContainer1" style="width: 100%; height: 500px;"></div>
									</div>
									<div id="chartContainer2-main">
										<span>Top referer</span>
										<div id="chartContainer2" style="width: 100%; height: 500px;"></div>
									</div>
									<div id="chartContainer3-main">
										<span>Weekly report </span>
										<div id="chartContainer3" style="width: 100%; height: 500px;"></div>
									</div>
									<div id="chartContainer5-main">
										 <span>Monthly report</span>
										<div id="chartContainer5" style="width: 100%; height: 500px;"></div>
									</div>
									<!--<div id="chartContainer6" style="width: 900px; height: 300px;"></div>-->
								</div>
							</div>
						</div>
						<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
						<script type="text/javascript">
							
							google.charts.load('current', {'packages':['corechart','bar']});

						    var chartBrowsers = '';
							var chartIP = '';
							var chartReferer = '';
							var chartWeekly = '';
							var chartMonthly = '';
							var chartYearly = '';
						    
							var dataBrowsers = '';
							var dataIp = '';
							var dataReferer = '';
							var dataWeekly = '';
							var dataMonthly = '';
							var dataYearly = '';
							var view = '';
							
							//jQuery.getScript('https://www.gstatic.com/charts/loader.js');
					    	var resultarr = '';
					    	var toparr = [];
					    	var dataPointsTopBrowsers = [];
					    	var dataPointsIp = [];
					    	var dataPointsReferer = [];
					    	var dataPointsMonthly = [];
					    	var dataPointsWeekly = [];
					    	var dataPointsYearly = [];
					    	
					    	var optionsBrowsers = '';
					    	var optionschartIP = '';
					    	var optionschartReferer = '';
					    	var optionschartWeekly = '';
					    	var optionschartMonthly = '';
					    	var optionschartYearly = '';
					    	
					    	
					    	
							jQuery(window).load(function() {	
								setTimeout(function() {
								
					
								optionsBrowsers = {
									title: '',
					//				pieHole: 0.4,
					//				is3D: true,
					//				chartArea:{left:20,top:20,width:'100%',height:'100%'},
								};
								
								optionschartIP = {
									title: '',
									chartArea:{width:"80%",height:"50%"},
									bar: {groupWidth: "50%"},
					        		legend: { position: "none" },
									hAxis: {
							          title: 'Total Visits',
							          minValue: 0,
							          textStyle: {
							            bold: true,
							            fontSize: 12,
							            color: '#4d4d4d'
							          }
									},
								};
								
								optionschartReferer = {
									title: '',
									chartArea:{left:100,width:"80%",height:"50%"},
									bar: {groupWidth: "20%"},
					        		legend: { position: "none" },
					        		hAxis: {
							          title: 'Referer Domain',
							          minValue: 0,
							          textStyle: {
							            bold: true,
							            fontSize: 12,
							            color: '#4d4d4d'
							          }
					        		},
							          vAxis: {
							          title: 'Total Visits',
							          textStyle: {
							            fontSize: 14,
							            bold: true,
							            color: '#848484'
							          }
							          }
								};
								
								optionschartWeekly = {
									title: '',
									chartArea:{left:100,width:"80%",height:"50%"},
									bar: {groupWidth: "20%"},
					        		legend: { position: "none" },
					        		hAxis: {
							          title: 'Year - Month',
							          minValue: 0,
							          textStyle: {
							            bold: true,
							            fontSize: 12,
							            color: '#4d4d4d'
							          }
					        		},
							          vAxis: {
							          title: 'Total Visits',
							          textStyle: {
							            fontSize: 14,
							            bold: true,
							            color: '#848484'
							          }
							          },
								};
								
								optionschartMonthly = {
									title: '',
									chartArea:{left:100,width:"80%",height:"50%"},
									bar: {groupWidth: "20%"},
					        		legend: { position: "none" },
					        		hAxis: {
							          title: 'Month - Week',
							          minValue: 0,
							          textStyle: {
							            bold: true,
							            fontSize: 12,
							            color: '#4d4d4d'
							          }
					        		},
							          vAxis: {
							          title: 'Total Visits',
							          textStyle: {
							            fontSize: 14,
							            bold: true,
							            color: '#848484'
							          }
							          }
								};
								
								optionschartYearly = {
									title: '',
									chartArea:{width:"80%",height:"50%"},
									bar: {groupWidth: "20%"},
					        		legend: { position: "none" },
									
								};
						    	
								var page_id = <?php echo $_REQUEST['id']; ?>;
								
								jQuery.ajax({
									type: "POST",
									url: pagevisit.ajaxurl,
									async:true,
									data: ({
										action: 'get_page_visit_record_report',
										page_id:page_id
									}),
									success: function(data) {
										var resultarr = JSON.parse(data);
										console.log(resultarr);
										if(resultarr != 'novisit') {
											topBrowsersArr = resultarr['topBrowserString'];				
											topIpArr = resultarr['topIpString'];
											topRefererArr = resultarr['topRefererString'];
											topWeeklyArr = resultarr['topWeeklyString'];
											topMonthlyArr = resultarr['topMonthlyString'];
											topYearlyArr = resultarr['topYearlyString'];
											
											jQuery( "#chartContainer" ).html('');
											jQuery( "#chartContainer1" ).html('');
											jQuery( "#chartContainer2" ).html('');
											jQuery( "#chartContainer3" ).html('');
											jQuery( "#chartContainer5" ).html('');
											jQuery( "#chartContainer6" ).html('');
						
											for(var i in topBrowsersArr) {
											    dataPointsTopBrowsers.push([i, topBrowsersArr [i]]);
											}
											
											dataBrowsers = google.visualization.arrayToDataTable(dataPointsTopBrowsers);
											
											for(var j in topIpArr) {
											    dataPointsIp.push([j, topIpArr [j]]);
											}
											
											dataIp = google.visualization.arrayToDataTable(dataPointsIp);
											
											for(var k in topRefererArr) {
											    dataPointsReferer.push([k, topRefererArr [k]]);
											}
											
											dataReferer = google.visualization.arrayToDataTable(dataPointsReferer);
											
											for(var l in topWeeklyArr) {
											    dataPointsWeekly.push([l, topWeeklyArr [l]]);
											}
											
											dataWeekly = google.visualization.arrayToDataTable(dataPointsWeekly);	
											
											for(var m in topMonthlyArr) {
											    dataPointsMonthly.push([m, topMonthlyArr [m]]);
											}
											
											dataMonthly = google.visualization.arrayToDataTable(dataPointsMonthly);
											
											for(var n in topYearlyArr) {
											    dataPointsYearly.push([n, topYearlyArr [n]]);
											}
											
											dataYearly = google.visualization.arrayToDataTable(dataPointsYearly);
											
											jQuery(".page-counter-show").colorbox({inline:true, width:"38%"});
											
											//$( "#tabs" ).tabs();
											
											//$('body #ui-id-2').trigger('click');
											
						            		chartBrowsers = new google.visualization.PieChart(document.getElementById('chartContainer'));
						            		chartBrowsers.draw(dataBrowsers, optionsBrowsers);
						            		
						            		view = new google.visualization.DataView(dataIp);
						            		view.setColumns([0, 1,
						                       { calc: "stringify",
						                         sourceColumn: 1,
						                         type: "string",
						                         role: "annotation" },
						                       ]);
						            		
						            		chartIP = new google.visualization.BarChart(document.getElementById('chartContainer1'));
						            		//var chartIP = google.charts.Bar(document.getElementById('chartContainer1'));
						            		chartIP.draw(view, optionschartIP);
						            		
						            		
						            		chartReferer = new google.visualization.ColumnChart(document.getElementById('chartContainer2'));
						            		chartReferer.draw(dataReferer, optionschartReferer);
						            		
						            		chartWeekly = new google.visualization.ColumnChart(document.getElementById('chartContainer3'));
						            		chartWeekly.draw(dataWeekly, optionschartWeekly);
						            		
						            		chartMonthly = new google.visualization.ColumnChart(document.getElementById('chartContainer5'));
						            		chartMonthly.draw(dataMonthly, optionschartMonthly);
						            		
						            		//chartYearly = new google.visualization.ColumnChart(document.getElementById('chartContainer6'));
						            		//chartYearly.draw(dataYearly, optionschartYearly);
											
											jQuery( window ).resize(function() {
												console.log('resize');
												chartBrowsers.draw(dataBrowsers, optionsBrowsers);
												chartIP.draw(view, optionschartIP);
												chartReferer.draw(dataReferer, optionschartReferer);
												chartWeekly.draw(dataWeekly, optionschartWeekly);
												chartMonthly.draw(dataMonthly, optionschartMonthly);
												//chartYearly.draw(dataYearly, optionschartYearly);
											});
											
											
										} else {
											jQuery(".page-counter-show").colorbox({inline:true, width:"38%"});
										
											//jQuery( "#tabs" ).tabs();
											
											
//											setTimeout(function(){
//												jQuery('body #ui-id-1').trigger('click');
//											},500);
											
											jQuery( "#chartContainer" ).html('No Visitor Found.');
											jQuery( "#chartContainer1" ).html('No Visitor Found.');
											jQuery( "#chartContainer2" ).html('No Visitor Found.');
											jQuery( "#chartContainer3" ).html('No Visitor Found.');
											jQuery( "#chartContainer5" ).html('No Visitor Found.');
											jQuery( "#chartContainer6" ).html('No Visitor Found.');
											
										}	
									}
									
								});
								}, 1000);
							});
							
							jQuery( window ).resize(function() {
								console.log('resize');
								chartBrowsers.draw(dataBrowsers, optionsBrowsers);
								chartIP.draw(view, optionschartIP);
								chartReferer.draw(dataReferer, optionschartReferer);
								chartWeekly.draw(dataWeekly, optionschartWeekly);
								chartMonthly.draw(dataMonthly, optionschartMonthly);
								//chartYearly.draw(dataYearly, optionschartYearly);
							});
							
								
						
						</script>
						<?php
					} else { ?>
						<form id="movies-filter" method="get">
							<?php 
								$test_list_table->search_box( __( 'Search' ), 'page-visit-counter' );
								foreach ($_GET as $key => $value) { // http://stackoverflow.com/a/8763624/1287812
							        if( 's' !== $key ) // don't include the search query
							            echo("<input type='hidden' name='$key' value='$value' />");
							    }
								$test_list_table->display();
							?>
						</form>
						
						<!-- Twitter -->
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			
						<!-- Facebook -->
						<script>(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) return;
						  js = d.createElement(s); js.id = id;
						  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>
						
						<!-- Google+ -->
						<script type="text/javascript">
						  (function() {
						    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
						    po.src = 'https://apis.google.com/js/platform.js';
						    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
						  })();
						</script>
						
						<?php
					} ?>
				
			</div>
			
			<?php
		}
		/**
		 * function use to page settings
		 * $args is pass the arguments
		 */
		function custom_page_visit_settings( $args ) {
			
			global $wpdb;
			$current_user = wp_get_current_user();
			// Get all the registered post type
			$post_types = get_post_types();
			
			// Get all the post type selected in settings page
			$post_list = array();
			$post = json_decode(get_option('wfap_post_type'));
			$post_list  = $post;
			
			$text_color_page_visit = get_option('text_color_page_visit');
			if (isset($text_color_page_visit) && $text_color_page_visit != null) {
				$text_color_page_visit = $text_color_page_visit;
			} else {
				$text_color_page_visit = '#000000';
			}
			
			if (!get_option('pvcp_plugin_notice_shown')) {
				 echo '<div id="pvcp_dialog" title="Basic dialog"> <p> Subscribe for latest plugin update and get notified when we update our plugin and launch new products for free! </p> <p><input type="text" id="txt_user_sub_pvcp" class="regular-text" name="txt_user_sub_pvcp" value="'.$current_user->user_email.'"></p></div>';
			}
			
			?>
			<div class="main-page-visit-settings">
				<div class="page-title-settings">
					<form id="pvc_plugin_form_id" method="post" action="<?php echo get_admin_url();?>admin-post.php" enctype="multipart/form-data" novalidate="novalidate">
						
						<input type="hidden" name="action" value= "submit_form_pvc" />
						<input id="action_which" type="hidden" name="action-which" value="add" />
						<div class="set_pvc_containter set_plugin_descriptions">
		                	<h3><?php echo __( 'Page Counter Settings','page-visit-counter' ); ?></h3>
			                <p><?php echo __('Page Visit Counter plugin use for front side post and pages counter. After activation of plugin it will automatically add page counts on bottom of all pages. So, that all visitors can see page counts for entire site pages.','page-visit-counter'); ?></p>
			                <ul style="list-style-type: disc;padding: 3px 2px 2px 34px;">
				                <li><p><?php echo __('Specific page vise reports like Top browsers, Top 10 IP address, Top referer, weekly report and Monthly report using chart.','page-visit-counter'); ?></p></li>
				                <li><p><?php echo __('Search facility: search pages by title and search page by its created date.','page-visit-counter'); ?></p></li>
				                <li><p><?php echo __('Sharing facility: share specific page on Facebook, Twitter and Google Plus.','page-visit-counter'); ?></p></li>
			                </ul>
		                </div>
						
						<div class="set_pvc_containter set_plugin_descriptions_shortcode">
		                	<fieldset>
								<legend><?php echo __( 'Short Code','page-visit-counter' ); ?></legend>
				                <p><?php echo __('There are two shortcodes that you can use to manually add page view count to any content on admin or post/page template created by your theme or plugin thats create it\'s own display content in page/post.','page-visit-counter'); ?></p>
				                <p><?php echo __('Use this shortcode to add admin side content on page/post:', 'page-visit-counter'); ?> <b><?php echo __(htmlspecialchars('[page_visit_counter_md id="<page_id/post_id>"]'),'page-visit-counter'); ?></b></p>
				                <p><?php echo __('Use this shortcode to display total sites visit to add admin side content on page/post:', 'page-visit-counter'); ?> <b><?php echo __(htmlspecialchars('[page_visit_counter_md_total_sites_visit backgroundcolor="#ff0000" countboxcolor="#000000" fontcolor="#FFFFFF" bordercolor="#ff0000"]'),'page-visit-counter'); ?></b></p>
				                <p><?php echo __('Use this shortcode to add page/post template (.php) file of your own template:','page-visit-counter'); ?> <b> <?php echo "&lt;?php echo do_shortcode('[page_visit_counter_md id='page_id/post_id']');?&gt;"?></b></p>
                                                <p><?php echo __('Use this shortcode to display total sites visit to add page/post template (.php) file of your own template:','page-visit-counter'); ?> <br><b> &lt;?php echo do_shortcode('[page_visit_counter_md_total_sites_visit backgroundcolor='#ff0000' countboxcolor='#000000' fontcolor='#FFFFFF' bordercolor='#ff0000']');?&gt; </b></p>
                                         </fieldset>
		                </div>
		                
						<div class="set_pvc_containter set_plugin_descriptions">
							<fieldset>
								<legend><?php echo __('Basic Configuration settings', 'page-visit-counter'); ?></legend>
								<?php
								$get_option_value = json_decode(get_option( 'page_count_settings' ));
								$input_values = isset( $get_option_value[1] ) ? $get_option_value[1] : array();
								$select_values = isset($get_option_value[0] ) ? $get_option_value[0] : array();
								?>
								<table border="0" cellpadding="10" cellspacing="0">
									<tbody>
										<tr>
											<th scope="row"><label for="blogname"><?php echo  __( 'Post Type', 'page-visit-counter' );?></label></th>
		            						<td>
		                            			<select id="post_type" data-placeholder=" <?php echo __('Add Page/Post Type', 'page-visit-counter');?>" name="post_ty[]" multiple="true" class="chosen-select-post category-select chosen-rtl validate_field1">
													<option value=""></option><?php
		                   							if (isset($post_types) && !empty($post_types)) {
		                   								foreach ($post_types as $cpost) {
		                   									if($cpost != "attachment" && $cpost != "revision" && $cpost != "nav_menu_item" && $cpost != "product_variation" && $cpost != "shop_order" && $cpost != "shop_order_refund" && $cpost != "shop_coupon" && $cpost != "shop_webhook" && $cpost != "scheduled-action" && $cpost != "shop_subscription"&& $cpost != "wpcf7_contact_form"&& $cpost != "mc4wp-form") { ?>
																	<option value="<?php echo $cpost; ?>"><?php echo $cpost; ?></option><?php
		                   									}
														}
		                   							} ?>
		                        				</select>
		                        				<p><?php echo __('(Select post types for which post views will be counted.)', 'page-visit-counter');?></p>
	                        					<!--<p>(<b><?php //echo __('Note: To start the count of the page/post please select the Cpt (custom post type), page or post from above select box. If you not select any one then it will not start to count.', 'page-visit-counter'); ?></b>)</p>-->
		            						</td>
		               					</tr>
				                   		
		               					<tr class="ipaddress">
		           							<th scope="row"><label for="blogname"><?php echo __( 'Exclude IPs (Ip Address)', 'page-visit-counter' );?></label></th>
		                        			<td>
		                        				<select id="ip_address" data-placeholder=" <?php echo __('Add IP Address in comma seprated', 'page-visit-counter'); ?>" name="ip-basic[]" multiple="true" class="chosen-select-ip category-select chosen-rtl validate_field1">
													<option value=""></option><?php
		                   							$get_option_value_ip = json_decode(get_option( 'ipaddress_visit' ));
		                   							if (isset($get_option_value_ip) && !empty($get_option_value_ip)) {
		               									foreach ($get_option_value_ip as $ip) { ?>
															<option value="<?php echo $ip; ?>"><?php echo $ip; ?></option><?php
														}
		                   							} ?>
		                                        </select>
		                                        <p><?php echo __('(Enter the IP addresses to be excluded from post views count.)','page-visit-counter'); ?></p>
		                        			</td>
				                   		</tr>
				                   		
				                   		<tr class="users">
				                   			<th scope="row"><label for="blogname"><?php echo __( 'Exclude Users', 'page-visit-counter' );?></label></th>
		                        			<td>
		                        				<select id="users_list" data-placeholder="<?php echo __('Select Registerd Users', 'page-visit-counter'); ?>" name="user-basic[]" multiple="true" class="chosen-select category-select chosen-rtl validate_field1">
													<option value=""></option><?php
		                   							$query = "SELECT * FROM $wpdb->users";
		                   							$resultSetsArr = $wpdb->get_results($query);
		                   							if (isset($resultSetsArr) && !empty($resultSetsArr)) {
														foreach ($resultSetsArr as $value) { ?>
															<option value="<?php echo $value->ID; ?>"><?php echo $value->user_email; ?></option><?php
														}
		                   							} ?>
		                                        </select>
		                                        <p><?php echo __('(Select the users to be excluded from post views count.)', 'page-visit-counter'); ?></p>
				                        	</td>
				                   		</tr>
				                   		
				                   		<tr class="hidefront">
				                   			<th scope="row"><label for="blogname"><?php echo __( 'Show front view counter', 'page-visit-counter' );?></label></th>
				                   			<?php 
			                   				$hide_show_option = get_option('counter_hide_show_front_vew');
				                   			if($hide_show_option == 'on'){ 
				                   				$cheked = 'checked';
				                   			} else {
				                   				$cheked = '';
				                   			} ?>
				                   			<td class="information">
				                   				<input type="checkbox" name="hidefrontview" id="hide_front_view" <?php echo $cheked; ?>><?php echo __('Check the box if you want to display counter view on front end.', 'page-visit-counter'); ?>
			                   				</td>
				                   		</tr>
				                   		
				                   		<tr class="hidefront" style="display:none;">
				                   			<th scope="row"><label for="blogname"><?php echo __( 'Last How many days count you want to display on front end.', 'page-visit-counter' );?></label></th>
				                   			<td class="information">
				                   				<?php
				                   					$get_no_of_days = get_option('no_of_days_to_display');
				                   					if ($get_no_of_days == '') {
				                   						$get_no_of_days = '';
				                   					}
				                   				?>
				                   				<input type="text" name="no_of_days_to_display" id="no_of_days_to_display" value="<?php echo $get_no_of_days; ?>">
			                   				</td>
				                   		</tr>
				                   		
				                   		<tr class="">
				                   			<th scope="row"><label for="blogname"><?php echo __( 'Choose color for the front end view', 'page-visit-counter' );?></label></th>
				                   			<td class="information">
				                   				<input id="text_color_page_visit" type="text" name="textcolor" value="<?php echo $text_color_page_visit; ?>" class="my-color-field" data-default-color="<?php echo $text_color_page_visit; ?>" />
			                   				</td>
				                   		</tr>
			                   		</tbody>
								</table>
							</fieldset>
						</div>
						<p class="submit">
							<input type="submit" name="submit" class="button button-primary" value="<?php echo __('Save Changes','page-visit-counter'); ?>">
							<input type="submit" id="pvc_reset_settings" value="<?php echo __('Reset all settings', 'page-visit-counter'); ?>" class="button button-primary">
							<input type="submit" id="pvc_reset_counter" value="<?php echo __('Reset all pages counts & report ', 'page-visit-counter'); ?>" class="button button-primary">
						</p>	
					</form>			
				</div>
			</div>
			<?php
		}		
	}
	
	
	public function wp_add_plugin_userfn() { 
		global $wpdb;
    	$email_id= $_POST['email_id'];
    	$log_url = $_SERVER['HTTP_HOST'];
    	$cur_date = date('Y-m-d');
    	$url = 'http://www.multidots.com/store/wp-content/themes/business-hub-child/API/wp-add-plugin-users.php';
    	$response = wp_remote_post( $url, array('method' => 'POST',
    	'timeout' => 45,
    	'redirection' => 5,
    	'httpversion' => '1.0',
    	'blocking' => true,
    	'headers' => array(),
    	'body' => array('user'=>array('user_email'=>$email_id,'plugin_site' => $log_url,'status' => 1,'plugin_id' => '6','activation_date'=>$cur_date)),
    	'cookies' => array()));
		update_option('pvcp_plugin_notice_shown', 'true');
    }
    
     public function hide_subscribe_pvcpfn() { 
     	global $wpdb;
    	$email_id= $_POST['email_id'];
    	update_option('pvcp_plugin_notice_shown', 'true');
    }
	
	/**
	 * function create dashboad widget.
	 * view most visited page in dashboard.
	 *
	 */
	function my_custom_dashboard_widgets() {
		global $wp_meta_boxes;
		wp_add_dashboard_widget('custom_help_widget', __('Most Visited Page', 'page-visit-counter'), 'custom_dashboard_help');
		function custom_dashboard_help() {
			global $wpdb;
			$table_name = $wpdb->prefix."page_visit";
			$html ='';
			$count_visit = $wpdb->get_results("SELECT page_id,id,SUM(page_visit) as c from $table_name group by page_id order by c DESC limit 5");												
			$html .='<div class="main_custom_dashboard_visit_page">';
			if (!empty($count_visit) && isset($count_visit)) {
			$html .='<table border="0" cellpadding="5" cellspacing="10">';
				$html .='<tr>';
					$html .='<th>'.__('Page id', 'page-visit-counter').'</th>';
					$html .='<th>'.__('Page Name', 'page-visit-counter').'</th>';
					$html .='<th>'.__('Total Count', 'page-visit-counter').'</th>';
				$html .='</tr>';
				
					foreach ($count_visit as $visitpage ){
						$page = get_post($visitpage->page_id);
						$html .='<tr>';
							$html .='<td>'.$page->ID.'</td>';
							$html .='<td><a href="'.get_admin_url().'post.php?post='.$page->ID.'&action=edit">'.__($page->post_title,'page-visit-counter').'</a></td>';	
							$html .='<td>'.$visitpage->c.'</td>';
						$html .='</tr>';
					}
			$html .='</table>';
			} else {
					$html .='No Page Found.';
				}
			$html .='</div>';
			echo $html;
		}
	}
	
	/**
	 * this function use to page settings submit callback function
	 * add option by option table 
	 * add page count option and duration. 
	 */
	public function add_page_count_option(){
		global $wpdb;
		
		$page_count_option = array();
		
		$getformsumbitaction = !empty( $_POST['action'] ) ? $_POST['action']:'';
		$getformactiontype = !empty( $_POST['action-which'] ) ? $_POST['action-which']:'';
		
		if( !empty( $getformsumbitaction ) && $getformsumbitaction == 'submit_form_pvc' && !empty( $getformactiontype ) && $getformactiontype == 'add' ) {
		
			$type = isset($_POST['post_ty']) ? $_POST['post_ty'] : array();
			$ipAddress = isset($_POST['ip-basic']) ? $_POST['ip-basic'] : array();
			$userList = isset($_POST['user-basic']) ? $_POST['user-basic'] : array();
			$hidefrontview = isset($_POST['hidefrontview']) ? $_POST['hidefrontview'] : '';
			$text_color_page_visit = isset($_POST['textcolor']) ? $_POST['textcolor'] : '';
			
			$twitter_url_page_visit = isset($_POST['twitter_url_page_visit']) ? $_POST['twitter_url_page_visit'] : '';
			$gplus_url_page_visit = isset($_POST['gplus_url_page_visit']) ? $_POST['gplus_url_page_visit'] : '';
			$fb_url_page_visit = isset($_POST['fb_url_page_visit']) ? $_POST['fb_url_page_visit'] : '';
			$no_of_days_to_display = isset($_POST['no_of_days_to_display']) ? $_POST['no_of_days_to_display'] : '';
			
			delete_option('wfap_post_type');
			if (isset($type) && $type != null) {
				update_option('wfap_post_type',json_encode(array_values($type)));
			}
			
			delete_option('ipaddress_visit');
			if (isset($ipAddress) && $ipAddress != null) {
				update_option('ipaddress_visit',json_encode(array_values($ipAddress)));
			}
			
			delete_option('userlist_visit');
			if (isset($userList) && $userList != null) {
				update_option('userlist_visit',json_encode(array_values($userList)));
			}
			
			if( isset($hidefrontview) && $hidefrontview != null ){
				update_option('counter_hide_show_front_vew',$hidefrontview);
			} else {
				update_option('counter_hide_show_front_vew','');
			}
			
			if( isset($no_of_days_to_display) && $no_of_days_to_display != null ){
				update_option('no_of_days_to_display',$no_of_days_to_display);
			} else {
				update_option('no_of_days_to_display','');
			}
			
			if( isset($text_color_page_visit) && $text_color_page_visit != null ){
				update_option('text_color_page_visit',$text_color_page_visit);
			}
			
			if( isset($twitter_url_page_visit) && $twitter_url_page_visit != null ){
				update_option('twitter_url_page_visit',$twitter_url_page_visit);
			}
			
			if( isset($gplus_url_page_visit) && $gplus_url_page_visit != null ){
				update_option('gplus_url_page_visit',$gplus_url_page_visit);
			}
			
			if( isset($fb_url_page_visit) && $fb_url_page_visit != null ){
				update_option('fb_url_page_visit',$fb_url_page_visit);
			}
		} else if (!empty( $getformsumbitaction ) && $getformsumbitaction == 'submit_form_pvc' && !empty( $getformactiontype ) && $getformactiontype == 'reset') {
			delete_option('wfap_post_type');
			delete_option('ipaddress_visit');
			delete_option('userlist_visit');
			update_option('no_of_days_to_display','');
			update_option('counter_hide_show_front_vew','');
			update_option('text_color_page_visit','');
			update_option('twitter_url_page_visit','');
			update_option('gplus_url_page_visit','');
			update_option('fb_url_page_visit','');
		} else if (!empty( $getformsumbitaction ) && $getformsumbitaction == 'submit_form_pvc' && !empty( $getformactiontype ) && $getformactiontype == 'resetcount') {

			$table_name = $wpdb->prefix."page_visit";
			
			$query = "TRUNCATE TABLE $table_name";
			$wpdb->query($query);
			
			$table_name = $wpdb->prefix . "page_visit_history";
			$query = "TRUNCATE TABLE $table_name";
			$wpdb->query($query);
		}
		
		wp_safe_redirect(site_url("/wp-admin/admin.php?page=page_visit_settings"));
		exit();
		
		//die();			
	}
	
	/**
	 * select_input_page_value use in ajax callback function
	 * handle the date and page title on change event.
	 */
	public function select_input_page_value() {
		global $wpdb;
		$table_name = $wpdb->prefix."page_visit";
		$table_post = $wpdb->prefix."posts";
		$html = '';
		$page_title = isset( $_POST['page_name'] ) ? $_POST['page_name'] : '';
		$page_date = isset( $_POST['page_date'] ) ? $_POST['page_date'] : '';
		$string ='';
		if( $page_date == '' && $page_title =='' ) {
			$html .='<table id="example" class="display" cellpadding="0" cellspacing="0">
				 <thead>
					<tr>
						<th width="10%">'.__('No', 'page-visit-counter').'</th>
						<th width="10%">'.__('Page ID', 'page-visit-counter').'</th>
						<th>'.__('Page Title', 'page-visit-counter').'</th>
						<th width="20%">'.__('Total Count', 'page-visit-counter').'</th>
						<th width="20%">'.__('Share', 'page-visit-counter').'</th>
						<th width="10%">'.__('Report', 'page-visit-counter').'</th>
					</tr>
				</thead>
				<tbody>';
				$postperpage = -1;		
				$post_types = get_post_types();
				$posts_array = array();
				if (isset($post_types) && !empty($post_types)) {
					foreach ($post_types as $cpost) {
						if($cpost != "attachment" && $cpost != "revision" && $cpost != "nav_menu_item" && $cpost != "product_variation" && $cpost != "shop_order" && $cpost != "shop_order_refund" && $cpost != "shop_coupon" && $cpost != "shop_webhook" && $cpost != "scheduled-action") {
							$args = array(
								'post_type' => "$cpost",
								'post_status' => 'publish',
								'order' => 'ASC',
								'posts_per_page'   => $postperpage,
							);
							$posts_array[] = get_posts( $args );
						}
					}
				}	
				$counter = 0;
				foreach ( $posts_array as $result ) {
					foreach ($result as $results) {
					$counter = $counter + 1;
						$html .='<tr>';
							$html .='<td>'.$counter.'</td>';
							$html .='<td>'.$results->ID.'</td>';
							$html .='<td><a href="'.get_admin_url().'post.php?post='.$results->ID.'&action=edit">'.__($results->post_title,'page-visit-counter').'</a></td>';	
							$count_visit = $wpdb->get_results("SELECT SUM(page_visit) as page_visit from $table_name where page_id ='".$results->ID."'");
							$count = 0;
							foreach ( $count_visit as $countval) {	
								$count = $count + 1;
							}
							if ($count_visit[0]->page_visit == '') {
								$countC = 0;
							} else {
								$countC = $count_visit[0]->page_visit;
							}
							$html .='<td>'.$countC.'</td>';
							
							$site_title = get_bloginfo( 'name' );
							$page_social_content = $results->post_title.' - Total Visits '.$countC.' - '.$site_title;
							
							$html .='<td>
										<a target="_blank" style="margin-right: 5px;" href="https://www.facebook.com/sharer/sharer.php?u='.esc_url( get_permalink($results->ID) ).'"><img src="' . plugins_url( 'images/Facebook.png', dirname(__FILE__) ) . '" /></a>
										<a target="_blank" style="margin-right: 5px;" href="https://twitter.com/intent/tweet?text='.$page_social_content.'&url='.esc_url( get_permalink($results->ID) ).'"><img src="' . plugins_url( 'images/twitter.png', dirname(__FILE__) ) . '" /></a>
										<a target="_blank" href="https://plus.google.com/share?url='.esc_url( get_permalink($results->ID) ).'"><img src="' . plugins_url( 'images/Google_Plus.png', dirname(__FILE__) ) . '" /></a></td>';
							$html .='<td><a href="'.site_url().'/wp-admin/admin.php?page=page_visit_counter&id='.$results->ID.'" title="'.__($results->post_title,'page-visit-counter').'" class="" id="'.$results->ID.'">'.__('View Report','page-visit-counter').'</a></td>';
						$html .='</tr>';
					}   
				}
			$html .='</tbody>
					 <tfoot><tr>
							<th width="10%">'.__('No', 'page-visit-counter').'</th>
							<th width="10%">'.__('Page ID', 'page-visit-counter').'</th>
							<th>'.__('Page Title', 'page-visit-counter').'</th>
							<th width="20%">'.__('Total Count', 'page-visit-counter').'</th>
							<th width="20%">'.__('Share', 'page-visit-counter').'</th>
							<th width="10%">'.__('Report', 'page-visit-counter').'</th>
						</tr></tfoot></table>';
			echo $html;
		} else {
			if( $page_title != '' ){
				if($page_date){
					$string .= "wposts.post_title LIKE '$page_title%' AND ";
				}else{
					$string .= "wposts.post_title LIKE '$page_title%' ";
				}
			}
			if( $page_date != '' ){
				if( $page_title ){
					$string .= "$table_name.date = '".$page_date."' AND";
				}else{
					$string .= "$table_name.date = '".$page_date."'";
				}
			}
			$clean = rtrim($string," AND ");
			$querySet = "SELECT DISTINCT wposts.* FROM $table_post wposts INNER JOIN $table_name ON (wposts.ID = $table_name.page_id) WHERE $clean";
			$dataquery =$wpdb->get_results($querySet);
			if(empty( $dataquery ) || $dataquery == ''){
				$QUERY = "SELECT * from $table_post where post_title LIKE '$page_title%' AND post_status='publish'";
				$notvisit = $wpdb->get_results($QUERY);	
				$html .='<table id="example" class="display" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
						<th width="10%">'.__('No', 'page-visit-counter').'</th>
						<th width="10%">'.__('Page ID', 'page-visit-counter').'</th>
						<th>'.__('Page Title', 'page-visit-counter').'</th>
						<th width="20%">'.__('Total Count', 'page-visit-counter').'</th>
						<th width="20%">'.__('Share', 'page-visit-counter').'</th>
						<th width="10%">'.__('Report', 'page-visit-counter').'</th>
					</tr></thead><tbody>';
					$counter = 0;
					foreach ( $notvisit as $results ){
						$counter = $counter + 1;
						$html .='<tr>';
						$html .='<td>'.$counter.'</td>';
						$html .='<td>'.$results->ID.'</td>';
						$html .='<td><a href="'.get_admin_url().'post.php?post='.$results->ID.'&action=edit">'.__($results->post_title,'page-visit-counter').'</a></td>';		
						$html .='<td> 0 </td>';
						$site_title = get_bloginfo( 'name' );
						$page_social_content = $results->post_title.' - Total Visits 0 - '.$site_title;
						
						$html .='<td>
									<a target="_blank" style="margin-right: 5px;" href="https://www.facebook.com/sharer/sharer.php?u='.esc_url( get_permalink($results->ID) ).'"><img src="' . plugins_url( 'images/Facebook.png', dirname(__FILE__) ) . '" /></a>
									<a target="_blank" style="margin-right: 5px;" href="https://twitter.com/intent/tweet?text='.$page_social_content.'&url='.esc_url( get_permalink($results->ID) ).'"><img src="' . plugins_url( 'images/twitter.png', dirname(__FILE__) ) . '" /></a>
									<a target="_blank" href="https://plus.google.com/share?url='.esc_url( get_permalink($results->ID) ).'"><img src="' . plugins_url( 'images/Google_Plus.png', dirname(__FILE__) ) . '" /></a></td>';
						$html .='<td><a href="'.site_url().'/wp-admin/admin.php?page=page_visit_counter&id='.$results->ID.'" title="'.__($results->post_title,'page-visit-counter').'" class="" id="'.$results->ID.'">'.__('View Report','page-visit-counter').'</a></td>';
						$html .='</tr>';	
					}
				$html .='</tbody><tfoot>
						<tr>
							<th width="10%">'.__('No', 'page-visit-counter').'</th>
							<th width="10%">'.__('Page ID', 'page-visit-counter').'</th>
							<th>'.__('Page Title', 'page-visit-counter').'</th>
							<th width="20%">'.__('Total Count', 'page-visit-counter').'</th>
							<th width="20%">'.__('Share', 'page-visit-counter').'</th>
							<th width="10%">'.__('Report', 'page-visit-counter').'</th>
						</tr></tfoot></table>';
				echo $html;
			}else if( $dataquery != '' ){	
				$html .='<table id="example" class="display" cellpadding="0" cellspacing="0">
					 <thead>
						<tr>
							<th width="10%">'.__('No', 'page-visit-counter').'</th>
							<th width="10%">'.__('Page ID', 'page-visit-counter').'</th>
							<th>'.__('Page Title', 'page-visit-counter').'</th>
							<th width="20%">'.__('Total Count', 'page-visit-counter').'</th>
							<th width="20%">'.__('Share', 'page-visit-counter').'</th>
							<th width="10%">'.__('Report', 'page-visit-counter').'</th>
						</tr></thead><tbody>';
				$counter = 0;
				foreach ( $dataquery as $results ){
					$counter = $counter + 1;
						$html .='<tr>';
							$html .='<td>'.$counter.'</td>';
							$html .='<td>'.$results->ID.'</td>';
							$html .='<td><a href="'.get_admin_url().'post.php?post='.$results->ID.'&action=edit">'.__($results->post_title,'page-visit-counter').'</a></td>';	
					$str ='';
					if( $page_title != '' ){
						if( $page_date != '' ){
							$str .="page_id ='".$results->ID."' AND ";
						}else{
							$str .="page_id ='".$results->ID."'";
						}
					}
					
					if($page_date != ''){
						if( $page_title != '' ){
							$str .="date ='".$page_date."' AND ";
						}else{
							$str .="date ='".$page_date."' ";
						}
					}
					$remove = rtrim($str," AND ");
					if($page_date != '' && $page_title != '' ){
						$count_visit = $wpdb->get_results("SELECT * from $table_name where $remove");
					} elseif ($page_title != '' ) {
						$count_visit = $wpdb->get_results("SELECT SUM(page_visit) as page_visit from $table_name where $remove");
					} elseif ($page_date != '' ) {
						$count_visit = $wpdb->get_results("SELECT * from $table_name where page_id=$results->ID AND  $remove");
					}
					if ($count_visit[0]->page_visit == '') {
						$countC = 0;
					} else {
						$countC = $count_visit[0]->page_visit;
					}
					
					$html .='<td>'.$countC.'</td>';
					
					$site_title = get_bloginfo( 'name' );
					$page_social_content = $results->post_title.' - Total Visits '.$countC.' - '.$site_title;
					
					$html .='<td>
								<a target="_blank" style="margin-right: 5px;" href="https://www.facebook.com/sharer/sharer.php?u='.esc_url( get_permalink($results->ID) ).'"><img src="' . plugins_url( 'images/Facebook.png', dirname(__FILE__) ) . '" /></a>
								<a target="_blank" style="margin-right: 5px;" href="https://twitter.com/intent/tweet?text='.$page_social_content.'&url='.esc_url( get_permalink($results->ID) ).'"><img src="' . plugins_url( 'images/twitter.png', dirname(__FILE__) ) . '" /></a>
								<a target="_blank" href="https://plus.google.com/share?url='.esc_url( get_permalink($results->ID) ).'"><img src="' . plugins_url( 'images/Google_Plus.png', dirname(__FILE__) ) . '" /></a></td>';
					$html .='<td><a href="'.site_url().'/wp-admin/admin.php?page=page_visit_counter&id='.$results->ID.'" title="'.__($results->post_title,'page-visit-counter').'" class="" id="'.$results->ID.'">'.__('View Report','page-visit-counter').'</a></td>';
					
					$html .='</tr>';	
				}
				$html .='</tbody><tfoot>
						<tr>
							<th width="10%">'.__('No', 'page-visit-counter').'</th>
							<th width="10%">'.__('Page ID', 'page-visit-counter').'</th>
							<th>'.__('Page Title', 'page-visit-counter').'</th>
							<th width="20%">'.__('Total Count', 'page-visit-counter').'</th>
							<th width="20%">'.__('Share', 'page-visit-counter').'</th>
							<th width="10%">'.__('Report', 'page-visit-counter').'</th>
						</tr></tfoot</table>';		
				echo $html;	
			}
		}
		die();
	}
	
	public function add_custom_meta_box_page_visit() {
		global $wpdb;
		
		$fetchSelecetedPostTypes = json_decode(get_option('wfap_post_type'));
		if (isset($fetchSelecetedPostTypes) && !empty($fetchSelecetedPostTypes)) {
			$i = 0;
			foreach ($fetchSelecetedPostTypes as $postsingle) {
				add_meta_box("header-meta-box-page-visit-$i", "Page Visit Counter", "custom_meta_box_markup_page_visit", "$postsingle", "side", "high", null);	
				$i++;
			}
		} else {
			$i = 0;
			// Get all the registered post type
			$post_types = get_post_types();
			foreach ($post_types as $cpost) {
				if($cpost != "attachment" && $cpost != "revision" && $cpost != "nav_menu_item" && $cpost != "product_variation" && $cpost != "shop_order" && $cpost != "shop_order_refund" && $cpost != "shop_coupon" && $cpost != "shop_webhook" && $cpost != "scheduled-action" && $cpost != "shop_subscription"&& $cpost != "wpcf7_contact_form"&& $cpost != "mc4wp-form") {
					add_meta_box("header-meta-box-page-visit-$i", "Page Visit Counter", "custom_meta_box_markup_page_visit", "$cpost", "side", "high", null);	
					$i++;
				}
			}
		}
		
		function add_new_selected_post_columns($columns) {
		   
		    return array_merge( $columns, 
        array( 'page_visit_count' => __( 'Total Visits', 'page-visit-counter' ) ) );
		 
		    
		}
		function custom_columns_add_page_visit_count( $column, $post_id ) {
				global $wpdb, $wp;
				if ($column == 'page_visit_count'){
			        $table_name = $wpdb->prefix."page_visit";
					$pageCount = $wpdb->get_results("SELECT SUM(page_visit) as total FROM $table_name WHERE `page_id` = $post_id");
					$total = (int) $pageCount[0]->total;
					echo $total;
			    }
			}
		function custom_meta_box_markup_page_visit($object) {
			global $wp, $wpdb;
			
			$post_id = get_the_ID();
			$enable_page_count = get_post_meta($post_id, "enable_page_count", true);
			$enable_page_count_day_wise = get_post_meta($post_id, "enable_page_count_day_wise", true);
			
			$table_name = $wpdb->prefix."page_visit";
			
			$pageCount = $wpdb->get_results("SELECT SUM(page_visit) as total FROM $table_name WHERE `page_id` = $post_id");
	
			$total = (int) $pageCount[0]->total;
			?>
			<input name="pageidvisit" type="hidden" value="<?php echo  $post_id; ?>">
				<p><?php echo __('Do you want to enable page visits count for this page?', 'page-visit-counter'); ?></p>
				<p>
					<?php if ($enable_page_count == '') { ?>
						<input type="radio" checked ="checked" name="autoupdate_page_visit" id="autoupdate_page1" value="yes"><?php echo __('Yes', 'page-visit-counter'); ?> 
						<input type="radio" name="autoupdate_page_visit" id="autoupdate_page2" value="no"><?php echo __('No', 'page-visit-counter'); ?>
					<?php } else { ?>
						<input type="radio" <?php if($enable_page_count=='yes'){ ?> checked ="checked" <?php } ?> name="autoupdate_page_visit" id="autoupdate_page1" value="yes"> Yes 
						<input type="radio" <?php if($enable_page_count=='no'){ ?> checked ="checked" <?php } ?> name="autoupdate_page_visit" id="autoupdate_page2" value="no">No<?php 
					} ?>
				</p>
				<p><?php echo __('Do you want to display today page visits count for this page?', 'page-visit-counter'); ?></p>
				<p>
					<?php if ($enable_page_count_day_wise == '') { ?>
						<input type="radio" checked ="checked" name="autoupdate_page_visit_day_wise" id="autoupdate_page1_day_wise" value="yes"><?php echo __('Yes', 'page-visit-counter'); ?> 
						<input type="radio" name="autoupdate_page_visit_day_wise" id="autoupdate_page2_day_wise" value="no"><?php echo __('No', 'page-visit-counter'); ?>
					<?php } else { ?>
						<input type="radio" <?php if($enable_page_count_day_wise=='yes'){ ?> checked ="checked" <?php } ?> name="autoupdate_page_visit_day_wise" id="autoupdate_page1_day_wise" value="yes"> Yes 
						<input type="radio" <?php if($enable_page_count_day_wise=='no'){ ?> checked ="checked" <?php } ?> name="autoupdate_page_visit_day_wise" id="autoupdate_page2_day_wise" value="no">No<?php 
					} ?>
				</p>
			<p><?php echo __('Do you want to reset all visits count for this page?', 'page-visit-counter'); ?></p>
			<p>
				<input type="radio" name="page_visit_reset" id="page_visit_reset_yes" value="yes"><?php echo __('Yes', 'page-visit-counter'); ?> 
				<input type="radio" checked ="checked" name="page_visit_reset" id="page_visit_reset_yes" value="no"><?php echo __('No', 'page-visit-counter'); ?>
			</p>
			<p><?php echo __('Total visits:','page-visit-counter'); ?> <?php echo $total; ?></p>
			<?php
		}
	}
	
	
	
	function save_custom_meta_box_page_visit($post_id) {
	    global $wp, $wpdb, $post;
	    
	    if(!current_user_can("edit_post", $post_id)) {
	        return $post_id;
	    }
	    
	    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
	        return $post_id;
	    }
	    
	 	if(isset($_POST["autoupdate_page_visit"]))
	    {
	        update_post_meta($post_id, "enable_page_count",$_POST["autoupdate_page_visit"]);
	    }
	    
	    if(isset($_POST["autoupdate_page_visit_day_wise"]))
	    {
	        update_post_meta($post_id, "enable_page_count_day_wise",$_POST["autoupdate_page_visit_day_wise"]);
	    }
	    
	    if(isset($_POST["page_visit_reset"]) && 'yes' === $_POST["page_visit_reset"])
	    {
	        $table_name = $wpdb->prefix."page_visit";
	        
	        $query = "DELETE FROM $table_name WHERE `page_id` = $post_id";
			
			$pageCount = $wpdb->query($query);
			
			$table_name = $wpdb->prefix . "page_visit_history";
			$query = "DELETE FROM $table_name WHERE `page_id` = $post_id";
			$wpdb->query($query);
	    }
	    
	}

	
	function check_page_visit_history_table_exisit() {
		global $wpdb, $wp;
		
		$table_name = $wpdb->prefix . "page_visit_history";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE $table_name (
				id int(11) unsigned NOT NULL AUTO_INCREMENT,
				page_id int(11) NOT NULL,
				date  date NOT NULL,
				lastdate  date NOT NULL,
				ipaddress varchar(255) NOT NULL,
				browser_full_name varchar(255) NOT NULL,
				browser_short_name varchar(255) NOT NULL,
				browser_version varchar(255) NOT NULL,
				os varchar(255) NOT NULL,
				http_referer varchar(255) NOT NULL,
				PRIMARY KEY  (id)
				);";	
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		//add_option( 'contact_db_version', $contact_db_version );
		}
		
	}
	
	function get_page_visit_record_report() {
		global $wpdb;
		
		$table_name = $wpdb->prefix . "page_visit_history";
		
		$pageId = $_REQUEST['page_id'];
		
		$countQuery = "SELECT COUNT(`page_id`) as total FROM $table_name WHERE `page_id` = $pageId";
		$result = $wpdb->get_results($countQuery);
		
		if ( (int) $result[0]->total > 0) {
		
			$queryTopBrowser = "SELECT COUNT(`page_id`) as total, `browser_full_name` as browser FROM $table_name WHERE `page_id` = $pageId GROUP BY `browser_full_name`";
			
			$topBrowserArr = $wpdb->get_results($queryTopBrowser);
			
			$topBrowserStringArr = array();
			
			
			$topBrowserStringArr['Browsers'] = 'Total Visits';
			if ( (int) $result[0]->total > 0) {
			foreach ($topBrowserArr as $topBrowser) {
				$topBrowserStringArr[$topBrowser->browser] = (int) $topBrowser->total;
			}
			}
			
			//$queryTopIpAddress = "SELECT COUNT(  `page_id` ) AS total,  `ipaddress` AS ipaddress FROM $table_name WHERE  `page_id` =$pageId GROUP BY  `ipaddress` ORDER BY total DESC LIMIT 10";
			$queryTopIpAddress = "SELECT COUNT(  `page_id` ) AS total,  `ipaddress` AS ipaddress FROM $table_name WHERE `page_id` =$pageId AND date > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY  `ipaddress` ORDER BY total DESC LIMIT 10";
			
			$topIpArr = $wpdb->get_results($queryTopIpAddress);
			
			$topIpStringArr = array();
			
			$topIpStringArr["IP Address"] = 'Total Visits';
			if ( (int) $result[0]->total > 0) {
			foreach ($topIpArr as $topIp) {
				$topIpStringArr["$topIp->ipaddress"] = (int) $topIp->total;
			}
			}
			
			$queryTopReferer = "SELECT COUNT(`page_id`) as total,SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(REPLACE(LOWER(`http_referer`), 'https://', ''), 'http://', ''), '/', 1), '?', 1) AS domain FROM $table_name WHERe `page_id` = $pageId AND `http_referer` != '' GROUP BY `http_referer` ORDER BY total DESC LIMIT 10";
			
			$topRefererArr = $wpdb->get_results($queryTopReferer);
			
			$topRefererStringArr = array();
			
			$topRefererStringArr["Domain"] = 'Total Visits';
			if ( (int) $result[0]->total > 0) {
			foreach ($topRefererArr as $topReferer) {
				if (!array_key_exists("$topReferer->domain", $topRefererStringArr)) {
					$topRefererStringArr["$topReferer->domain"] = (int) $topReferer->total;
				} else {
					$val = (int) $topRefererStringArr["$topReferer->domain"];
					$topRefererStringArr["$topReferer->domain"] = $val + (int) $topReferer->total;
				}
			}
			unset($topRefererArr);
			}
			
			$custom_page_visit_history_datatbase_table_name = $wpdb->prefix."page_visit_history";
			//$queryWeeklyReport = "SELECT SUM(page_id) AS total,DATE_ADD(date, INTERVAL(0-WEEKDAY(date)) DAY) as Week_Start_Date,DATE_ADD(date, INTERVAL(6-WEEKDAY(date)) DAY) as week_end_date,YEARWEEK( DATE, 1 ) AS YearAndWeek FROM $table_name WHERE page_id = $pageId GROUP BY YEARWEEK(date,1) ORDER BY YearAndWeek DESC LIMIT 5";
			$queryWeeklyReport = "SELECT SUM(page_id) AS total,DATE_ADD(date, INTERVAL(0-WEEKDAY(date)) DAY) as Week_Start_Date,DATE_ADD(date, INTERVAL(6-WEEKDAY(date)) DAY) as week_end_date,YEARWEEK( DATE, 1 ) AS YearAndWeek, YEAR(DATE) as year, WEEK( DATE,1 ) as week FROM $custom_page_visit_history_datatbase_table_name WHERE page_id = 1 GROUP BY YEARWEEK(date,1) ORDER BY YearAndWeek DESC LIMIT 5";
			
			$topWeeklyArr = $wpdb->get_results($queryWeeklyReport);
			
			$topWeeklyStringArr = array();
			
			$topWeeklyStringArr["Week Year"] = 'Total Visits';
			if ( (int) $result[0]->total > 0) {
			foreach (array_reverse($topWeeklyArr) as $topWeekly) {
				$topWeeklyStringArr["$topWeekly->year - $topWeekly->week"] = (int) $topWeekly->total;
			}
			unset($topWeeklyArr);
			}
			
			$queryMonthlyReport = "SELECT SUM(  `page_id` ) AS total, DATE_FORMAT(`date`,'%M %Y') AS month FROM  `$table_name` WHERE  `page_id` =$pageId AND YEAR(  `date` ) = YEAR( CURDATE( ) ) GROUP BY MONTH(  `date` ) ORDER BY MONTH(  `date` ) ASC LIMIT 5";
			
			$topMonthlyArr = $wpdb->get_results($queryMonthlyReport);
			
			$topMonthlyStringArr = array();
			
			$topMonthlyStringArr["Month"] = "Total Visits";
			if ( (int) $result[0]->total > 0) {
			foreach ($topMonthlyArr as $topMonthly) {
				$topMonthlyStringArr["$topMonthly->month"] = (int) $topMonthly->total;
			}
			unset($topMonthlyArr);
			}
			
			$queryYearlyReport = "SELECT SUM(  `page_id` ) AS total, YEAR(  `date` ) AS year FROM  `$table_name` WHERE  `page_id` =$pageId GROUP BY YEAR(  `date` ) ORDER BY YEAR(  `date` ) DESC LIMIT 10";
			
			$topYearlyArr = $wpdb->get_results($queryYearlyReport);
			
			$topYearlyStringArr = array();
			
			foreach ($topYearlyArr as $topYearly) {
				$topYearlyStringArr["$topYearly->year"] = $topYearly->total;
			}
			unset($topYearlyArr);
			
			$resultsArr = array();
			
			$resultsArr['topBrowserString'] = $topBrowserStringArr;
			$resultsArr['topIpString'] = $topIpStringArr;
			$resultsArr['topRefererString'] = $topRefererStringArr;
			$resultsArr['topWeeklyString'] = $topWeeklyStringArr;
			$resultsArr['topMonthlyString'] = $topMonthlyStringArr;
			$resultsArr['topYearlyString'] = $topYearlyStringArr;
			
			echo json_encode( $resultsArr ); 
			unset($resultsArr);
			//print_r($topBrowserStringArr);
		} else {
			echo json_encode('novisit'); 
		}
		
		die();
	} 
	
	
	public function custom_admin_pointers_footer() {
	    $admin_pointers = custom_admin_pointers();
	    ?>
	    <script type="text/javascript">
	        /* <![CDATA[ */
	        ( function($) {
	            <?php
	            foreach ( $admin_pointers as $pointer => $array ) {
	               if ( $array['active'] ) {
	                  ?>
	            $( '<?php echo $array['anchor_id']; ?>' ).pointer( {
	                content: '<?php echo $array['content']; ?>',
	                position: {
	                    edge: '<?php echo $array['edge']; ?>',
	                    align: '<?php echo $array['align']; ?>'
	                },
	                close: function() {
	                    $.post( ajaxurl, {
	                        pointer: '<?php echo $pointer; ?>',
	                        action: 'dismiss-wp-pointer'
	                    } );
	                }
	            } ).pointer( 'open' );
	            <?php
	         }
	      }
	      ?>
	        } )(jQuery);
	        /* ]]> */
	    </script>
	<?php
	} 
	
	
	/**
	 * Function For display pointer in admin side
	 *  
	 */
	
	
		
}
	
/**
 * The Widget functionality for this plugin.
 * widget provide Most visited page.
 *
 */
class My_Widget extends WP_Widget { 
 public function __construct() {
      $widget_ops = array('classname' => 'My_Widget', 'description' => 'Most Visited Pages' );
      parent::__construct('My_Widget', 'Recent Most Visit page', $widget_ops);
  }
 
  function widget($args, $instance) {
   global  $wpdb;
   $table_name = $wpdb->prefix."page_visit";
   $html ='';
    extract($args, EXTR_SKIP);
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $html .= (isset($before_widget)?$before_widget:'');
    if (!empty($title))
      $html .= $before_title . $title . $after_title;
		$count_visit = $wpdb->get_results("SELECT page_id,id,SUM(page_visit) as c from $table_name group by page_id order by c DESC limit 5");												
		foreach ($count_visit as $visitpage ){
			$page = get_post($visitpage->page_id);
			$html .='<h6 style="font-size: 14px;font-weight: normal;line-height: 14px;">'.$page->post_title.'</h6>';
			$html .="<br>";
		}
      $html .= (isset($after_widget)?$after_widget:'');
      echo $html;
  }
  public function form( $instance ) {
     $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
     $title = $instance['title']; 
     $html ='';
     $html .= '<p> <label for="'.$this->get_field_id("title").'">Title:
       		   <input class="widefat" id="'.$this->get_field_id("title").'"
               name="'.$this->get_field_name("title").'" type="text"
               value="'.attribute_escape($title).'" /></label></p>';  
     echo $html;  	   
  }
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("My_Widget");') );

 function custom_admin_pointers() {
	    
		$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
	    $version = '1_0'; // replace all periods in 1.0 with an underscore
	    $prefix = 'custom_admin_pointers' . $version . '_';
	
	    $new_pointer_content = '<h3>' . __( 'Page Visit Counter' ) . '</h3>';
	    $new_pointer_content .= '<p>' . __( 'This plugin will count the total visits of your sites pages.' ) . '</p>';
	
	    return array(
	        $prefix . 'page_visit_counter_notice_view' => array(
	            'content' => $new_pointer_content,
	            'anchor_id' => '#toplevel_page_page_visit_counter',
	            'edge' => 'left',
	            'align' => 'left',
	            'active' => ( ! in_array( $prefix . 'page_visit_counter_notice_view', $dismissed ) )
	        )
	    );
	
	}