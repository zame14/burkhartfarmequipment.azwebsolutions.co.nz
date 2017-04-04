<?php
$cat_arr = getSubCategoriesArray();
vc_map( array(
    "name"                    => __( "Equipment" ),
    "base"                    => "bfe_equipment",
    "category"                => __( 'Content' ),
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => __("Product Category"),
            "param_name" => "product_category",
            "value" => $cat_arr
        ),
    )
) );

add_shortcode( 'bfe_equipment', 'bfeEquipment' );

function bfeEquipment($atts) {
    $args = vc_map_get_attributes('bfe_equipment', $atts);
    $category = $args['product_category'];
    $count = 1;
    $html = '';
    (request('srch')) ? $search_results = request('srch') : $search_results = '';
    ($category == "Used Equipment") ? $products = getProductsByCategoryID(3, $search_results) : $products = getProductsByCategory($category);
    if($category == "Used Equipment") {
        // display search box
        $html .= '
        <div class="row">
            <div class="col-xs-12 col-sm-12 search-box-outer-wrapper">
                <div class="search-box-wrapper">
                    <h3>Search for Used Equipment</h3>
                    <form id="search-box" method="post" action="' . get_page_link(37) . '">
                        <div><input type="text" name="used_search" class="form-control" placeholder="Search by keyword" required="required" value="' . $search_results . '" /> <input type="submit" class="btn btn-danger" value="Search"></div>
                    </form>                  
                </div>';
                if($search_results <> '') {
                    $html .= '
                    <div class="search-results-wrapper">
                        <p>Search results for: "' . $search_results . '"</p> <a href="' . get_page_link(37) . '" class="btn btn-danger">Reset</a>
                    </div>';
                }
                if(count($products) == 0) {
                    $html .= '
                    <div class="no-search-results-wrapper">
                        <hr />
                        <h4>No results found...</h4>
                        <p>Please try a different keyword.</p>
                        <p>If you cannot find what you are looking for, please <a href="' . get_page_link(9) . '">contact us</a>.</p>
                        <hr />
                    </div>';
                }
            $html .= '   
            </div>
        </div>';
    }
    foreach($products as $product) {
        $product_images = getExtraProductImages($product->Item_ID);
        $extras = getProductExtras($product->Item_ID, 1);
        $extras_date = getProductExtras($product->Item_ID, 2);
        $has_sold = getProductExtras($product->Item_ID, 3);
        ($has_sold == "Yes") ? $sold_class = 'sold' : $sold_class = '';
        ($product->Item_Price <> '') ? $display_price = '$' . $product->Item_Price . ' +GST' : $display_price = 'For sale price: Call';
        $ref = strtolower($product->Item_Name);
        $ref = str_replace(" ", "_", $ref);
        ($product->SubCategory_ID == 0) ? $item = $product->SubCategory_Name : $item = 'Used Equipment';
        $item .= ' - ' . $product->Item_Name;
        $enquire_link = add_query_arg(array(
            'item' => $item
        ), get_page_link(9));
        $enquire_link .= '#form';
        $html .= '
        <div class="product-wrapper">
            <a name="top"></a>
            <div class="row">
                <div class="col-xs-12 col-md-6 image-wrapper">';
                    if(count($product_images) > 0) {
                        // this product has more than images - use owl carousel
                        $html .= '
                        <div class="owl-carousel owl-theme">
                            <div><img src="' . $product->Item_Photo_URL . '" alt="' . $product->Item_Name . '"></div>';
                            foreach($product_images as $image) {
                                $html .= '<div><img src="' . $image . '" alt="' . $product->Item_Name . '"></div>';
                            }
                        $html .= '
                        </div>';
                    } else {
                        $html .= '<img src="' . $product->Item_Photo_URL . '" alt="' . $product->Item_Name . '">';
                    }
                    $html .= ' 
                    <div class="sold-overlay ' . $sold_class . '"><span>SOLD</span></div>
                </div>
                <div class="col-xs-12 col-md-6 product-details-wrapper">
                    <a name="' . $ref . '"></a>
                    <h2>' . $product->Item_Name . '</h2>
                    <div class="price">' . $display_price . '</div>';
                    if($category == "Used Equipment" && $extras_date <> '') {
                        $html .= '<div class="date-added-wrapper">Date added: ' . $extras_date . '</div>';
                    }
                    $html .= '
                    <div class="description">' . $product->Item_Description . '</div>';
                    if($extras <> '') {
                        $extras_arr = explode('|', $extras);
                        $html .= '
                        <div class="extras-wrapper">
                            <h3>Extras</h3>';
                            foreach($extras_arr as $extra) {
                                $html .= '<div class="extra">' . $extra . '</div>';
                            }
                        $html .= '    
                        </div>';
                    }
                    $html .= '
                    <div class="enquire-btn-wrapper ' . $sold_class . '"><a href="' . $enquire_link . '" class="btn btn-default">Enquire</a></div>
                </div>
                <hr />
            </div>
        </div>';
        $count++;
    }
    if($count > 5) {
        // display to top button
        $html .= '<a class="fa fa-arrow-circle-o-up top"></a>';
    }

    return $html;
}