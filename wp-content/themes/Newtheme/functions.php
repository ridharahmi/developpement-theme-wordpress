<?php

//inclide  navwalker class pour utilise in menu 
require_once('includes/wp-bootstrap-navwalker.php');


function add_styles_css()
{
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css');
    wp_enqueue_style('app-css', get_template_directory_uri() . '/css/app.css');
}

//load function add css  in site
add_action('wp_enqueue_scripts', 'add_styles_css');


/*
  **wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
  **$handle : nom de file: nome unique de chaque file
  **$src : resource de file
  **array :les files eli yest7a9hom
  **false : version de file
  **$in_footer: true :add script files in footer
  ** false :add script files in head
*/

function add_styles_script()
{
    wp_deregister_script('jquery'); //remove register file jquery in wordpress
    wp_register_script('jquery', includes_url('/js/jquery/jquery.js'), array(), false, true);
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), false, true);
    wp_enqueue_script('app-js', get_template_directory_uri() . '/js/app.js', array(), false, true);

    // if internet explorer version < 9
    wp_enqueue_script('html5shiv', get_template_directory_uri() . '/js/explorer/html5shiv.min.js');
    wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');
    wp_enqueue_script('respond', get_template_directory_uri() . '/js/explorer/respond.min.js');
    wp_script_add_data('respond', 'conditional', 'lt IE 9');
}

//load function add js in site
add_action('wp_enqueue_scripts', 'add_styles_script');

/**
 * custom logo site
 */
function logo_site() {
    $defaults = array(
        'height'      => 50,
        'width'       => 100,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    );
    add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'logo_site' );



// function  menus in wp-admin appearance
function add_menu()
{
    /*if une seul menu
	** register_nav_menu('navigation-menu', __('navigation menu bar'));
	*/
    register_nav_menus(array(
        'navigation-menu' => 'Navigation Menu',
        'footer_menu' => 'Footer Menu',
    ));
}

//load menu
add_action('init', 'add_menu');


//function show meni in site page
function navbar_menu()
{
    wp_nav_menu(array(
        'theme_location' => 'navigation-menu',
        'menu_class' => 'nav navbar-nav navbar-right',
        'container' => false,
        'depth' => 2,
        'walker' => new wp_bootstrap_navwalker()
    ));
}
function footer_menu()
{
    wp_nav_menu(array(
        'theme_location' => 'footer_menu',
        'menu_class' => 'list-unstyled list-inline',
        'container' => 'ul',
    ));
}

//add Featured Images support in post
add_theme_support('post-thumbnails');


//function num words(kalma)  in content
function content_length($length)
{
     if(is_author()){
         return 5;
     }elseif(is_category()){
         return 5;
     }else{
         return 20;
     }

}

add_filter('excerpt_length', 'content_length');

// function end content read more
function content_excerpt_more($more)
{
    return ' .....';
}

add_filter('excerpt_more', 'content_excerpt_more');


function pagination_page()
{
    global $wp_query;
    $all_pages = $wp_query->max_num_pages;
    $curret_page = max(1, get_query_var('paged'));
    if ($all_pages > 1) {
        return paginate_links(array(
            'base' => get_pagenum_link() . '%_%',
            'format' => 'page/%#%',
            'current' => $curret_page,
            'mid_size' => 2,
            'end_size' => 2
        ));
    }
}

// function  sidebar in wp-admin appearance
function add_sidebar()
{
    register_sidebar(array(
        'name' => 'Main Sidebar ',
        'id' => 'main-sidebar',
        'description' => 'this is main sidebar ',
        'class' => 'main-sidebar1',
        'before_widget' => '<li class="widget-content">',
        'after_widget' => '</li>',
        'before_title' => '<h5 class="widget-title">',
        'after_title' => '</h5>'
    ));
}
//load menu
add_action('init', 'add_sidebar');

//function update paragraph post
function update_paragraph($content)
{
    remove_filter('the_content', 'wpautop');
    return $content;
}

add_filter('the_content', 'update_paragraph', 0);
