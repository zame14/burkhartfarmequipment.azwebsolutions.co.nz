<?php
require_once(STYLESHEETPATH . '/includes/wordpress-tweaks.php');
// Load custom visual composer templates
apex_loadVCTemplates();
$designWidth = 1150;
$apexAdjustStylesheet = 'understrap-theme';

add_action( 'wp_enqueue_scripts', 'bfe_enqueue_styles');
function bfe_enqueue_styles() {
    wp_enqueue_style( 'understrap-theme', get_stylesheet_directory_uri() . '/css/child-theme.css?' . filemtime(get_stylesheet_directory() . '/css/child-theme.css'));
    wp_enqueue_style( 'google_font_nunito', 'https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800');
    wp_enqueue_style( 'google_font_montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:400,700');
    wp_enqueue_script('understap-theme', get_stylesheet_directory_uri() . '/js/theme.js?' . filemtime(get_stylesheet_directory() . '/js/theme.js'), array('jquery'));
}

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array());
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), '0.1.0', true );
}

add_filter( 'vc_load_default_templates', 'bfe_vc_load_default_templates' ); // Hook in
function bfe_vc_load_default_template( $data ) {
    return array();
}

add_image_size( 'home_banner', 1632, 450, true);
add_image_size( 'odds_ends_banner', 1150, 400, true);
add_image_size( 'inside_banner', 1150, 300, true);

// facebook stream
function facebook_feed() {
    $FBpage = file_get_contents('https://graph.facebook.com/628079593954120/feed?access_token=416237291746252|ELVzlxEEclLl3uDlWpqhDTLn2fY');
    //Interpret data with JSON
    $FBdata = json_decode($FBpage);
    //Loop through data for each news item
    $count = 1;
    $html = '
    <div class="facebook-feed-wrapper">
        <ul>';
    foreach ($FBdata->data as $news ) {
        if (!empty($news->message) && !empty($news->picture) && $count <= 6) {
            $html .= '<li style="background: url(' . $news->picture . ')"></li>';
            $count++;
        }
    }
    $html .= '
        </ul>
    </div>
    <p class="facebook-link-wrapper"><a href="https://www.facebook.com/Burkhart-Farm-Equipment-Ltd-628079593954120/" target="_blank"><span class="fa fa-facebook-square"></span> Follow us</a></p>';

    return $html;
}