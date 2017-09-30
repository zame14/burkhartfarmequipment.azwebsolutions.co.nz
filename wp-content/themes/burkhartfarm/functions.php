<?php
require_once(STYLESHEETPATH . '/includes/wordpress-tweaks.php');
// Load custom visual composer templates
apex_loadVCTemplates();
$designWidth = 1150;
$apexAdjustStylesheet = 'understrap-theme';



add_action( 'wp_enqueue_scripts', 'bfe_enqueue_styles');
function bfe_enqueue_styles() {
    wp_enqueue_style( 'understrap-theme', get_stylesheet_directory_uri() . '/css/child-theme.css?' . filemtime(get_stylesheet_directory() . '/css/child-theme.css'));
    wp_enqueue_style( 'owl-carousel', get_stylesheet_directory_uri() . '/node_modules/owl.carousel/dist/assets/owl.carousel.css');
    wp_enqueue_style( 'google_font_nunito', 'https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800');
    wp_enqueue_style( 'google_font_montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:400,700');
    wp_enqueue_script( 'owl-carousel', get_stylesheet_directory_uri() . '/node_modules/owl.carousel/dist/owl.carousel.js');
    wp_enqueue_script( 'elevate-zoom', get_stylesheet_directory_uri() . '/js/jquery.elevatezoom.js');
    wp_enqueue_script( 'waypoint', get_stylesheet_directory_uri() . '/node_modules/waypoints/lib/noframework.waypoints.min.js');
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



add_filter( 'vc_load_default_templates', 'bfe_vc_load_default_templates' ); // Hook in
function bfe_vc_load_default_template( $data ) {
    return array();
}

add_action('init', 'bfe_register_menus');
function bfe_register_menus() {
    register_nav_menus(
        Array(
            'footer-menu' => __('Footer Menu'),
        )
    );
}


add_image_size( 'home_banner', 1632, 450, true);
add_image_size( 'odds_ends_banner', 1150, 800, true);
add_image_size( 'inside_banner', 1150, 300, true);

if(request('used_search')) {
    // used equipment search
    $search_str = request('used_search');
    $url = add_query_arg('srch', $search_str, get_page_link(37));
    header('Location: ' . $url);
    exit;
}

if(request('new_search')) {
    // used equipment search
    $search_str = request('new_search');
    $url = add_query_arg('srch', $search_str, get_page_link(30));
    header('Location: ' . $url);
    exit;
}

if(request('odds_search')) {
    // used equipment search
    $search_str = request('odds_search');
    $url = add_query_arg('srch', $search_str, get_page_link(38));
    header('Location: ' . $url);
    exit;
}

if(request('action') == "search") {
    // main search
    $keyword_search = request('keyword');
    $type_new = request('new');
    $type_used = request('used');
    $url = add_query_arg(array(
        'keyword' => $keyword_search,
        'new' => $type_new,
        'used' => $type_used
    ), get_page_link(205));
    header('Location: ' . $url);
    exit;
}

function getProductsSearch($search_str) {
    global $wpdb;
    $sql = '
    SELECT i.Item_ID, Item_Name, Item_Slug, Item_Description, Item_Price, Item_Photo_URL, Category_ID, Category_Name, SubCategory_ID, SubCategory_Name, m.Meta_Value
    FROM wp_UPCP_Items i
    LEFT OUTER JOIN wp_UPCP_Fields_Meta m
    ON i.Item_ID = m.Item_ID
    AND m.Field_ID = 4
    WHERE Item_Display_Status = "Show"
    AND Category_ID <> 4';

    if($search_str <> '') {
        $sql .= $search_str;
    }
    $products = $wpdb->get_results($sql);
    return $products;
}

function getProductSlug($id) {
    switch($id) {
        case 1:
            $slug = get_page_link(28);
            break;
        case 2:
            $slug = get_page_link(32);
            break;
        case 3:
            $slug = get_page_link(34);
            break;
        case 4:
            $slug = get_page_link(35);
            break;
        case 5:
            $slug = get_page_link(36);
            break;
        case 6:
            $slug = get_page_link(656);
            break;
        case 7:
            $slug = get_page_link(817);
            break;
        default:
            $slug = get_page_link(37);
    }
    return $slug;
}

function getProductsByCategory($category, $search_str = '') {
    global $wpdb;
    $sql = 'SELECT Item_ID, Item_Name, Item_Slug, Item_Description, Item_Price, Item_Photo_URL, Category_ID, Category_Name, SubCategory_Name, SubCategory_ID, SubCategory_Name FROM wp_UPCP_Items WHERE Item_Display_Status = "Show"';
    $sql .= ' AND SubCategory_Name = "' . $category . '"';
    if($search_str <> '') {

    }

    $products = $wpdb->get_results($sql);
    return $products;
}

function getProductsByCategoryID($id, $search_str = '') {
    global $wpdb;
    $sql = '
    SELECT i.Item_ID, Item_Name, Item_Slug, Item_Description, Item_Price, Item_Photo_URL, Category_ID, Category_Name, SubCategory_ID, SubCategory_Name, SubCategory_Name, m.Meta_Value
    FROM wp_UPCP_Items i
    LEFT OUTER JOIN wp_UPCP_Fields_Meta m
    ON i.Item_ID = m.Item_ID
    AND m.Field_ID = 4
    WHERE Item_Display_Status = "Show"';
    $sql .= ' AND Category_ID = "' . $id . '"';
    if($search_str <> '') {
        $sql .= ' AND Meta_Value LIKE "%' . $search_str . '%"';
    }
    $products = $wpdb->get_results($sql);
    return $products;
}
function getProductsByID($id, $search_str = '') {
    global $wpdb;
    $sql = '
    SELECT i.Item_ID, Item_Name, Item_Slug, Item_Description, Item_Price, Item_Photo_URL, Category_ID, Category_Name, SubCategory_ID, SubCategory_Name, SubCategory_Name, m.Meta_Value
    FROM wp_UPCP_Items i
    LEFT OUTER JOIN wp_UPCP_Fields_Meta m
    ON i.Item_ID = m.Item_ID
    AND m.Field_ID = 4
    WHERE Item_Display_Status = "Show"';
    $sql .= ' AND i.Item_ID = "' . $id . '"';
    if($search_str <> '') {
        $sql .= ' AND Meta_Value LIKE "%' . $search_str . '%"';
    }
    $products = $wpdb->get_results($sql);
    return $products;
}

function getSubCategoriesArray() {
    global $wpdb;
    $sql = 'SELECT SubCategory_ID, SubCategory_Name FROM wp_UPCP_SubCategories';
    $subcategories = $wpdb->get_results($sql);

    $subcategories_arr = array();
    foreach ($subcategories as $subcategory) {
        $subcategories_arr[] = $subcategory->SubCategory_Name;
    }
    $subcategories_arr[] .= 'Used Equipment';
    return $subcategories_arr;
}

function fbe_get_post_type($type, $orderby = '') {
    $args = array(
        'post_type' => $type,
        'post_status' => 'publish',
        'orderby' => $orderby,
        'order' => 'ASC'
    );
    $result = array();
    $result = new WP_Query($args);

    return $result;
}

function getExtraProductImages($productid) {
    global $wpdb;
    $sql = 'SELECT Item_Image_URL FROM wp_UPCP_Item_Images WHERE Item_ID = ' . $productid;
    $images = $wpdb->get_results($sql);

    $images_arr = array();
    foreach($images as $image) {
        $images_arr[] = $image->Item_Image_URL;
    }
    return $images_arr;
}

function getProductExtras($productid, $fieldid) {
    global $wpdb;
    $sql = 'SELECT Meta_Value FROM wp_UPCP_Fields_Meta WHERE Item_ID = ' . $productid . ' AND Field_ID = ' . $fieldid;
    $result = $wpdb->get_results($sql);

    return $result[0]->Meta_Value;
}

function getProductVideo($productid) {
    global $wpdb;
    $sql = 'SELECT Item_Video_URL FROM wp_UPCP_Videos WHERE Item_ID = ' . $productid;
    $result = $wpdb->get_results($sql);

    return $result[0]->Item_Video_URL;
}