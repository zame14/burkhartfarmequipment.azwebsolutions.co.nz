<?php
vc_map( array(
    "name"                    => __( "Search" ),
    "base"                    => "bfe_search",
    "category"                => __( 'Content' ),
    'show_settings_on_create' => false
) );

add_shortcode( 'bfe_search', 'bfeSearch' );

function bfeSearch() {
    $html = '';
    $search_str = '';
    $keyword_search = request('keyword');
    $new = request('new');
    $used = request('used');
    $search_result_text = '';
    if(request('keyword')) {
        $search_str = ' AND (Item_Name LIKE "%' . $keyword_search . '%" || Meta_Value LIKE "%' . $keyword_search . '%")';
        $search_result_text .= ' "' . $keyword_search . '"';
    }
    if($new == 'y') {
        // restrict search to new equipment
        $search_str .= ' AND Category_ID = 2';
        ($search_result_text == '') ? $search_result_text .= ' new equipment' : $search_result_text .= ' + new equipment';
    }
    if($used == 'y') {
        // restrict search to used equipment
        $search_str .= ' AND Category_ID = 3';
        ($search_result_text == '') ? $search_result_text .= ' used equipment' : $search_result_text .= ' + used equipment';
    }
    if($search_result_text == '') $search_result_text .= "all";
    $products = getProductsSearch($search_str);
    $count = 1;

    $html = '<div class="search-text-wrapper"><p>search results (' . count($products) . ') for: ' . $search_result_text . '</p></div>';
    if(count($products) > 0) {
        $html .= '<div class="row">
        <a name="top"></a>';
        foreach($products as $product) {
            ($product->Item_Price <> '') ? $display_price = '$' . $product->Item_Price . ' +GST' : $display_price = 'For sale price: Call';
            $slug = getProductSlug($product->SubCategory_ID);
            $has_sold = getProductExtras($product->Item_ID, 3);
            ($has_sold == "Yes") ? $sold_class = 'sold' : $sold_class = '';
            $ref = strtolower($product->Item_Name);
            $ref = str_replace(" ", "_", $ref);
            $html .= '
            <div class="col-xs-12 col-md-4 search-panel">
                <a href="' . $slug . '#' . $ref . '">
                    <div class="image-wrapper">
                        <img src="' . $product->Item_Photo_URL . '" alt="' . $product->Item_Name . '">
                        <div class="sold-overlay ' . $sold_class . '"><span>SOLD</span></div>
                    </div>
                    <div class="details-wrapper">
                        <h2>' . $product->Item_Name . '</h2>
                        <div class="price">' . $display_price . '</div>
                        <div class="category">Category: ' . $product->Category_Name . '</div>                    
                    </div>
                </a>    
            </div>';
            $count++;
        }
        if($count > 5) {
            // display to top button
            $html .= '<a class="fa fa-arrow-circle-o-up top"></a>';
        }
        $html .= '</div>';
    } else {
        $html .= '
        <div class="no-search-results-wrapper">
            <hr />
            <h4>No results found...</h4>
            <p>Please try a different keyword.</p>
            <p>If you cannot find what you are looking for, please <a href="' . get_page_link(9) . '">contact us</a>.</p>
            <hr />
        </div>';
    }

    return $html;
}