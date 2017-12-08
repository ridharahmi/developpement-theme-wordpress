<?php
/*  
*  Plugin Name: WP Logo Changer
*  Plugin URI: http://www.afzalmultani.com
*  Description: WP Logo Changer
*  Version: 1.2
*  Author: Afzal Multani
*  Author URI: http://www.afzalmultani.com/
*  Author Email: multaniafzal30@gmail.com
*  License: GPLv2 or later
*/
      
   function amll_picker_css( $hook_suffix ) {
       // first check that $hook_suffix is appropriate for your admin page
       wp_enqueue_style( 'wp-color-picker' );
       wp_enqueue_script( 'my-script-handle', plugins_url('js/colorpicker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
       wp_register_style( 'style-css', plugins_url() . '/am-login-logo/css/style.css' );
       wp_enqueue_style( 'style-css');
   }
   add_action( 'admin_enqueue_scripts', 'amll_picker_css' );
   
   include('save.php');
   class amll_featured_plugin {
   	
   	/*
   	 * For easier overriding we declared the keys
   	 * here as well as our tabs array which is populated
   	 * when registering settings
   	 */
   	private $amll_general_settings_key = 'amll_general_settings';
   	private $amll_advanced_settings_key = 'amll_advanced_settings';
   	private $amll_plugin_options_key = 'amll_sett_plugin_options';
   	private $amll_plugin_settings_tabs = array();
   	
   	/*
   	 * Fired during plugins_loaded (very very early),
   	 * so don't miss-use this, only actions and filters,
   	 * current ones speak for themselves.
   	 */
   	function __construct() {
   		add_action( 'init', array( &$this, 'amll_load_settings' ) );
   		add_action( 'admin_init', array( &$this, 'amll_register_general_settings' ) );
   		add_action( 'admin_init', array( &$this, 'amll_register_advanced_settings' ) );
   		add_action( 'admin_menu', array( &$this, 'amll_add_admin_menus' ) );
                                  }
   
   	
   	/*
   	 * Loads both the general and advanced settings from
   	 * the database into their respective arrays. Uses
   	 * array_merge to merge with default values if they're
   	 * missing.
   	 */
   	function amll_load_settings() {
   		$this->amll_general_settings = (array) get_option( $this->amll_general_settings_key );
   		$this->amll_advanced_settings = (array) get_option( $this->amll_advanced_settings_key );
   		
   		// Merge with defaults
   		$this->amll_general_settings = array_merge( array(
   			'amll_general_option' => 'General value'
   		), $this->amll_general_settings );
   		
   		$this->amll_advanced_settings = array_merge( array(
   			'amll_advanced_option' => 'Advanced value'
   		), $this->amll_advanced_settings );
   	}
   	/*
   	 * Registers the general settings via the Settings API,
   	 * appends the setting to the tabs array of the object.
   	 */
   	function amll_register_general_settings() {
   		$this->amll_plugin_settings_tabs[$this->amll_general_settings_key] = 'General';
   		
   		register_setting( $this->amll_general_settings_key, $this->amll_general_settings_key );
   		add_settings_section( 'amll_section_general', '', array( &$this, 'amll_section_general_desc' ), $this->amll_general_settings_key );
   		
   	}
   	
   	/*
   	 * Registers the advanced settings and appends the
   	 * key to the plugin settings tabs array.
   	 */
   	function amll_register_advanced_settings() {
   		$this->amll_plugin_settings_tabs[$this->amll_advanced_settings_key] = 'Advanced';
   		
   		register_setting( $this->amll_advanced_settings_key, $this->amll_advanced_settings_key );
   		add_settings_section( 'amll_section_advanced', '', array( &$this, 'amll_section_advanced_desc' ), $this->amll_advanced_settings_key );
   		
   	}
   	/*
   	 * The following methods provide descriptions
   	 * for their respective sections, used as callbacks
   	 * with amll_add_settings_section
   	 */
   	function amll_section_general_desc() {
           echo '<form novalidate="novalidate" action="#" method="post" enctype="multipart/form-data">'; 
           echo '<table class="form-table"><tbody>';
           echo '<tr>';
           echo '<th scope="row"><label class="amll-width-login-label" for=""><h3>Login Page</h3></label></th>';
           echo '<td></td>';
           echo '</tr>';
           echo '<tr>'; 
           echo '<th scope="row"><label for="amll_loginlogo">Login Page logo</label></th>';
           echo '<td><input type="file" name="amll_loginlogo"/></td>'; 
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_loginpagebackgroundcolor">Login Page Background Color</label></th>';
           echo '<td><input class="regular-text amll-color-field" type="text" value="'; echo get_option( 'wp_sett_loginpagebackgroundcolor' ); echo'" name="amll_loginpagebackgroundcolor" placeholder="#f7f7f7"></td>';
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_loginpagebackgroundimage">Login Page Background Image</label></th>';
           echo '<td><input type="file" name="amll_loginpagebackgroundimage"/></td>'; 
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_loginpageformbackgroundcolor">Login Page Form Background Color</label></th>';
           echo '<td><input class="regular-text amll-color-field" type="text" value="'; echo get_option( 'wp_sett_loginpageformbackgroundcolor' ); echo'" name="amll_loginpageformbackgroundcolor" placeholder="#f7f7f7"></td>'; 
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_loginpageformfieldbackgroundcolor">Login Page Form Field Background Color</label></th>';
           echo '<td><input class="regular-text amll-color-field" type="text" value="'; echo get_option( 'wp_sett_loginpageformfieldbackgroundcolor' ); echo'" name="amll_loginpageformfieldbackgroundcolor" placeholder="#f7f7f7"></td>'; 
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_loginpageformfontcolor">Login Page Form Text Color</label></th>';
           echo '<td><input  class="regular-text amll-color-field" type="text" value="'; echo get_option( 'wp_sett_loginpageformfontcolor' ); echo'" name="amll_loginpageformfontcolor" placeholder="#f7f7f7"></td>'; 
           echo '</tr>';
           echo '</tbody></table>';
           echo '<p class="submit"><input class="button button-primary" type="submit" value="Save Changes" name="amll_section_general_button">&nbsp;<input class="button button-primary" type="submit" value="Reset Changes" name="amll_section_general_reset"></p>';
           echo '</form>';
           }
   	function amll_section_advanced_desc() {
           echo '<form novalidate="novalidate" action="#" method="post" enctype="multipart/form-data">'; 
           echo '<table class="form-table"><tbody>';
           //echo '<tr>';
           //echo '<th scope="row"><label for="amll_profilepicture">Admin Profile Picture</label></th>';
           //echo '<td><input type="file" name="amll_profilepicture"/></td>'; 
           //echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_howdytext">Welcome Message</label></th>';
           echo '<td><input class="regular-text" type="text" value="'; echo get_option( 'wp_sett_howdytext' ); echo'" name="amll_howdytext" placeholder="Howdy" maxlength="100"></td>';
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_footertext">Footer Text</label></th>';
           echo '<td><input class="regular-text" type="text" value="'; echo get_option( 'wp_sett_footertext' ); echo'" name="amll_footertext" placeholder="Enter your Footer Text" maxlength="100"></td>';
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_hideadminlogo">Wordpress Logo</label></th>';
           echo '<td><fieldset><p><label><input type="checkbox" value="hide" name="amll_hideadminlogo"';if(get_option("wp_sett_hideadminlogo")=="hide"){?> checked <?php }echo '>Hide Logo</label></p><p class="amll-field-description">Hide Wordpress Logo from Top Left.</p></fieldset></td>'; 
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_hideadminbar">Admin Bar</label></th>';
           echo '<td><fieldset><p><label><input type="checkbox" value="hide" name="amll_hideadminbar"';if(get_option("wp_sett_hideadminbar")=="hide"){?> checked <?php }echo '>Hide Bar</label></p><p class="amll-field-description">Hide Admin Bar on Frontend Pages while you are Loged In.</p></fieldset></td>'; 
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_navigationbackgroundcolor">Navigation Background Color</label></th>';
           echo '<td><input class="regular-text amll-color-field" type="text" value="'; echo get_option( 'wp_sett_navigationbackgroundcolor' ); echo'" name="amll_navigationbackgroundcolor" placeholder="#f7f7f7"></td>';
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_navigationfontcolor">Navigation Font Color</label></th>';
           echo '<td><input class="regular-text amll-color-field" type="text" value="'; echo get_option( 'wp_sett_navigationfontcolor' ); echo'" name="amll_navigationfontcolor" placeholder="#f7f7f7"></td>';
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_navigationfonthovercolor">Navigation Font Hover Color</label></th>';
           echo '<td><input class="regular-text amll-color-field" type="text" value="'; echo get_option( 'wp_sett_navigationfonthovercolor' ); echo'" name="amll_navigationfonthovercolor" placeholder="#f7f7f7"></td>';
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_navigationhoverbackgroundcolor">Navigation Hover Background Color</label></th>';
           echo '<td><input class="regular-text amll-color-field" type="text" value="'; echo get_option( 'wp_sett_navigationhoverbackgroundcolor' ); echo'" name="amll_navigationhoverbackgroundcolor" placeholder="#f7f7f7"></td>';
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_subnavigationbackgroundcolor">Sub Navigation Background Color</label></th>';
           echo '<td><input class="regular-text amll-color-field" type="text" value="'; echo get_option( 'wp_sett_subnavigationbackgroundcolor' ); echo'" name="amll_subnavigationbackgroundcolor" placeholder="#f7f7f7"></td>';
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_subnavigationfontcolor">Sub Navigation Font Color</label></th>';
           echo '<td><input class="regular-text amll-color-field" type="text" value="'; echo get_option( 'wp_sett_subnavigationfontcolor' ); echo'" name="amll_subnavigationfontcolor" placeholder="#f7f7f7"></td>';
           echo '</tr>';
           echo '<tr>';
           echo '<th scope="row"><label for="amll_iconscolor">Icons Color</label></th>';
           echo '<td><input class="regular-text amll-color-field" type="text" value="'; echo get_option( 'wp_sett_iconscolor' ); echo'" name="amll_iconscolor" placeholder="#f7f7f7"></td>';
           echo '</tr>';
           echo '</tbody></table>';
           echo '<p class="submit"><input class="button button-primary" type="submit" value="Save Changes" name="amll_section_advanced_button">&nbsp;<input class="button button-primary" type="submit" value="Reset Changes" name="amll_section_advanced_reset"></p>';
           echo '</form>';
   }
   
   
   
   /*
   * Called during admin_menu, adds an options
   * page under Settings called sett Settings, rendered
   * using the amll_plugin_options_page method.
   */
   function amll_add_admin_menus() {
   add_menu_page( 'sett Settings', 'AM Plugins', 'manage_options', $this->amll_plugin_options_key, array( &$this, 'amll_plugin_options_page' ) );
   }
   
   /*
   * Plugin Options page rendering goes here, checks
   * for active tab and replaces key with the related
   * settings key. Uses the amll_plugin_options_tabs method
   * to render the tabs.
   */
   function amll_plugin_options_page() {
   $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->amll_general_settings_key;
    $this->amll_plugin_options_tabs();
   echo '<div class="wrap">';
           wp_nonce_field( 'update-options' );
   settings_fields( $tab );
    do_settings_sections( $tab ); 
           echo '</div>';
   
       
   // wp_redirect(admin_url('options-general.php?page=my_plugin_options'));exit;       
   }
   
   
   
   
   
   /*
   * Renders our tabs in the plugin options page,
   * walks through the object's tabs array and prints
   * them one by one. Provides the heading for the
   * amll_plugin_options_page method.
   */
   function amll_plugin_options_tabs() {
   $current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->amll_general_settings_key;
   
   screen_icon();
   echo '<h2 class="nav-tab-wrapper">';
   foreach ( $this->amll_plugin_settings_tabs as $tab_key => $tab_caption ) {
   $active = $current_tab == $tab_key ? 'nav-tab-active' : '';
   echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->amll_plugin_options_key . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';	
   }
   echo '</h2>';
   }
   }
   
   // Initialize the plugin
   add_action( 'plugins_loaded', create_function( '', '$amll_featured_plugin = new amll_featured_plugin;' ) );
   
   
   
   
   /* function to show howdy text */ 
   function amll_change_howdy_text_toolbar($wp_admin_bar)
   {
   
   $amll_howdytext = get_option( 'wp_sett_howdytext' ); 
   if($amll_howdytext){
   
   $amll_getgreetings = $wp_admin_bar->get_node('my-account');
   $amll_rpctitle = str_replace('Howdy',$amll_howdytext,$amll_getgreetings->title);
   $wp_admin_bar->add_node(array("id"=>"my-account","title"=>$amll_rpctitle));
   
    }
   }
   if(get_option('wp_sett_howdytext')){
   add_filter('admin_bar_menu','amll_change_howdy_text_toolbar');
   }
   /* function to show login logo */ 
   function amll_change_login_logo() {
   
   $amll_loginlogoimage = get_option('wp_sett_loginlogo');
   
   if($amll_loginlogoimage){
   echo '<style type="text/css"> h1 a { background-image:url("'.$amll_loginlogoimage.'") !important; } </style>';
   }
   }
   if(get_option('wp_sett_loginlogo')){
   add_filter('login_head', 'amll_change_login_logo');
   }
   /* function to show footer text */ 
   
   function amll_change_footer_text() {
   $amll_footertext = get_option( 'wp_sett_footertext' ); 
   if($amll_footertext){
   echo $amll_footertext;
   }
   }
   if(get_option( 'wp_sett_footertext' )){
   add_filter('admin_footer_text', 'amll_change_footer_text');
   }
   /* function to show navigation background color */ 
   
   function amll_change_navigation_background_color() {
   
   $amll_navigationbackgroundcolor = get_option('wp_sett_navigationbackgroundcolor');
   if($amll_navigationbackgroundcolor){
   echo '<style type="text/css"> #adminmenu, #adminmenuwrap, #adminmenuback, #wpadminbar{ background-color:'.$amll_navigationbackgroundcolor.' !important; } </style>';
   }
   }
   if(get_option('wp_sett_navigationbackgroundcolor')){
   add_action('admin_head', 'amll_change_navigation_background_color');
   }
   /* function to show navigation font color */ 
   function amll_change_navigation_font_color() {
   $amll_navigationfontcolor = get_option('wp_sett_navigationfontcolor');
   if($amll_navigationfontcolor){
   echo '<style type="text/css"> #adminmenu a, #wpadminbar a.ab-item, #wpadminbar > #wp-toolbar span.ab-label, #wpadminbar > #wp-toolbar span.noticon, #collapse-menu{color:'.$amll_navigationfontcolor.' !important; } </style>';
   }
   }
   if(get_option('wp_sett_navigationfontcolor')){
   add_action('admin_head', 'amll_change_navigation_font_color');
   }
   /* function to show navigation font hover color */ 
   function amll_change_navigation_font_hover_color() {
   $amll_navigationfonthovercolor = get_option('wp_sett_navigationfonthovercolor');
   if($amll_navigationfonthovercolor){
   echo '<style type="text/css"> #adminmenu a:hover, #adminmenu a:hover:focus, #wp-toolbar li a:hover, #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, #adminmenu .wp-menu-arrow, #adminmenu .wp-menu-arrow div, #adminmenu li.current a.menu-top, #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, .folded #adminmenu li.current.menu-top, .folded #adminmenu li.wp-has-current-submenu, #collapse-menu:hover,#wpadminbar .ab-submenu .ab-item, #wpadminbar .quicklinks .menupop ul li a, #wpadminbar .quicklinks .menupop ul li a strong, #wpadminbar .quicklinks .menupop.hover ul li a:hover, #wpadminbar.nojs .quicklinks .menupop:hover ul li a:hover{color:'.$amll_navigationfonthovercolor.' !important; } </style>';
   }
   
   }
   if(get_option('wp_sett_navigationfonthovercolor')){
   add_action('admin_head', 'amll_change_navigation_font_hover_color');
   }
   /* function to show navigation hover background color */ 
   function amll_change_navigation_hover_background_color() {
   $amll_navigationhoverbackgroundcolor = get_option('wp_sett_navigationhoverbackgroundcolor');
   if($amll_navigationhoverbackgroundcolor){
   echo '<style type="text/css"> #adminmenu li a:hover, #wp-toolbar li a:hover, #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, #adminmenu .wp-menu-arrow, #adminmenu .wp-menu-arrow div, #adminmenu li.current a.menu-top, #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, .folded #adminmenu li.current.menu-top, .folded #adminmenu li.wp-has-current-submenu, #collapse-menu:hover{background-color:'.$amll_navigationhoverbackgroundcolor.' !important; } </style>';
   }
   }
   
   if(get_option('wp_sett_navigationhoverbackgroundcolor')){
   add_action('admin_head', 'amll_change_navigation_hover_background_color');
   }
   /* function to show sub navigation background color */
   function amll_change_sub_navigation_background_color() {
   
   $amll_subnavigationbackgroundcolor = get_option('wp_sett_subnavigationbackgroundcolor');
   if($amll_subnavigationbackgroundcolor){
   echo '<style type="text/css"> #adminmenu .wp-has-current-submenu .wp-submenu, #adminmenu .wp-has-current-submenu .wp-submenu.sub-open, #adminmenu .wp-has-current-submenu.opensub .wp-submenu, #adminmenu a.wp-has-current-submenu:focus + .wp-submenu, .no-js li.wp-has-current-submenu:hover .wp-submenu, #adminmenu .wp-not-current-submenu .wp-submenu, .folded #adminmenu .wp-has-current-submenu .wp-submenu, .ab-submenu{background-color:'.$amll_subnavigationbackgroundcolor.' !important; } </style>';
   }
   }
   if(get_option('wp_sett_subnavigationbackgroundcolor')){
   add_action('admin_head', 'amll_change_sub_navigation_background_color');
   }
   /* function to show sub navigation font color */ 
   function amll_change_sub_navigation_font_color() {
   
   $amll_subnavigationfontcolor = get_option('wp_sett_subnavigationfontcolor');
   if($amll_subnavigationfontcolor){
   echo '<style type="text/css"> #adminmenu li ul li a , #wpadminbar .ab-submenu .ab-item, #wpadminbar .quicklinks .menupop ul li a, #wpadminbar .quicklinks .menupop ul li a strong, #wpadminbar .quicklinks .menupop.hover ul li a, #wpadminbar.nojs .quicklinks .menupop:hover ul li a{color:'.$amll_subnavigationfontcolor.' !important; } </style>';
   }
   }
   if(get_option('wp_sett_subnavigationfontcolor')){
   add_action('admin_head', 'amll_change_sub_navigation_font_color');
   }
   /* function to show icons color */ 
   function amll_change_icons_color() {
   
   $amll_iconscolor = get_option('wp_sett_iconscolor');
   if($amll_iconscolor){
   echo '<style type="text/css"> #wpadminbar #adminbarsearch::before, #wpadminbar .ab-icon::before, #wpadminbar .ab-item::before, #adminmenu div.wp-menu-image::before, #collapse-button div::after{color:'.$amll_iconscolor.' !important; } </style>';
   }
   }
   if(get_option('wp_sett_iconscolor')){
   add_action('admin_head', 'amll_change_icons_color');
   }
   /* function to show favicon image */
   
   function amll_change_favicon_image(){
   $amll_faviconimage = get_option('wp_sett_faviconimage');
   if($amll_faviconimage){
   echo '<link rel="shortcut icon" href="'.$amll_faviconimage.'"/>';
   }
   }
   if(get_option('wp_sett_faviconimage')){
   add_filter('admin_head', 'amll_change_favicon_image');
   add_filter('wp_head', 'amll_change_favicon_image');
   }
   
   /* function to hide admin logo  */
   
   function amll_hide_admin_logo(){
   
   $amll_hideadminlogo = get_option('wp_sett_hideadminlogo');
   
   if($amll_hideadminlogo=='hide'){
    echo '<style type="text/css"> #wp-admin-bar-wp-logo{ display: none !important; } </style>';
    
   } else{ 
   echo '<style type="text/css"> #wp-admin-bar-wp-logo{ display: block !important; } </style>';
   }
   
   }
   if(get_option('wp_sett_hideadminlogo')){
   add_filter('admin_head', 'amll_hide_admin_logo');
   }
   /* function to hide admin logo */
   function amll_hide_admin_bar(){
   
   $amll_hideadminbar = get_option('wp_sett_hideadminbar');
   
   if($amll_hideadminbar=='hide'){
    echo '<style type="text/css"> #wpadminbar{ display: none !important; } </style>';
    
   } else{ 
   echo '<style type="text/css"> #wpadminbar{ display: block !important; } </style>';
   }
   
   }
   if(get_option('wp_sett_hideadminbar')){
   add_filter('wp_head', 'amll_hide_admin_bar');
   }
   /* function to show login page background color */ 
   function amll_change_login_page_background_color() {
   
   $amll_loginpagebackgroundcolor = get_option('wp_sett_loginpagebackgroundcolor');
   if($amll_loginpagebackgroundcolor){
   echo '<style type="text/css"> body,html{background-color:'.$amll_loginpagebackgroundcolor.' !important; } </style>';
   }
   }
   if(get_option('wp_sett_loginpagebackgroundcolor')){
   add_action('login_head', 'amll_change_login_page_background_color');
   }
   /* function to increase upload file size */ 
   function amll_increase_upload_file_size( $bytes )
   {
    $amll_uploadfilesize = get_option('wp_sett_uploadfilesize');
   if($amll_uploadfilesize){  
    $amll_uploadfilesize = $amll_uploadfilesize * (1024 * 1024);
    
   return $amll_uploadfilesize; // 32 megabytes
   }
   }
   if(get_option('wp_sett_uploadfilesize')){
   add_filter( 'upload_size_limit', 'amll_increase_upload_file_size' );
   }
   /* function to show login page background color */ 
   function amll_change_login_page_background_image() {
   $amll_loginpagebackgroundimage = get_option('wp_sett_loginpagebackgroundimage');
   if($amll_loginpagebackgroundimage){
	echo '<style type="text/css"> body,html{ background-image:url("'.$amll_loginpagebackgroundimage.'") !important; background-size: cover !important; background-repeat: no-repeat;  } </style>';
   }
   }
   if(get_option('wp_sett_loginpagebackgroundimage')){
   add_action('login_head', 'amll_change_login_page_background_image');
   }
   /* function to show login page form background color */ 
   function amll_change_login_page_form_background_color() {
   
   $amll_loginpageformbackgroundcolor = get_option('wp_sett_loginpageformbackgroundcolor');
   if($amll_loginpageformbackgroundcolor){
   echo '<style type="text/css"> .login form,.login .message,.login #login_error{background-color:'.$amll_loginpageformbackgroundcolor.' !important; border-left:none !important ;} </style>';
   }
   }
   if(get_option('wp_sett_loginpageformbackgroundcolor')){
   add_action('login_head', 'amll_change_login_page_form_background_color');
   }
   /* function to show login page form field background color */ 
   function amll_change_login_page_form_field_background_color() {
   
   $amll_loginpageformfieldbackgroundcolor = get_option('wp_sett_loginpageformfieldbackgroundcolor');
   if($amll_loginpageformfieldbackgroundcolor){
	echo '<style type="text/css"> .login form .input, .login form input[type=checkbox], .login input[type=text]{background-color:'.$amll_loginpageformfieldbackgroundcolor.' !important;} </style>';
   }
   }
   if(get_option('wp_sett_loginpageformbackgroundcolor')){
   add_action('login_head', 'amll_change_login_page_form_field_background_color');
   }
   /* function to show login page form field background color */ 
   function amll_change_login_page_form_font_color() {
   
   $amll_loginpageformfontcolor = get_option('wp_sett_loginpageformfontcolor');
   if($amll_loginpageformfontcolor){
	echo '<style type="text/css"> .login label, .login .message,#login p a{color:'.$amll_loginpageformfontcolor.' !important;} </style>';
   }
   }
   if(get_option('wp_sett_loginpageformfontcolor')){
	add_action('login_head', 'amll_change_login_page_form_font_color');
   }
   ?>