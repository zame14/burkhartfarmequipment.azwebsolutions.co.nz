<?php
vc_map( array(
    "name"                    => __( "Odds & Ends" ),
    "base"                    => "bfe_odds_ends",
    "category"                => __( 'Content' ),
    'show_settings_on_create' => false
) );

add_shortcode( 'bfe_odds_ends', 'bfeOddsEnds' );

function bfeOddsEnds() {
    $html = '';
    (request('srch')) ? $search_results = request('srch') : $search_results = '';
    if(request('itemid')) {
        // display specific item
        $products = getProductsByID(request('itemid'));
        $count = 1;
        foreach($products as $product) {
            $product_images = getExtraProductImages($product->Item_ID);
            $extras = getProductExtras($product->Item_ID, 1);
            $extras_date = getProductExtras($product->Item_ID, 2);
            $html .= '
            <div class="product-wrapper">
                <a name="top"></a>
                <div class="row">
                    <div class="col-xs-12 col-md-6 image-wrapper">';
            if(count($product_images) > 0) {
                // this product has more than images - use owl carousel
                $html .= '
                            <div class="owl-carousel owl-theme">
                                <div><img src="' . $product->Item_Photo_URL . '" alt="' . $product->Item_Name . '" class="first"></div>';
                foreach($product_images as $image) {
                    $html .= '<div><img src="' . $image . '" alt="' . $product->Item_Name . '"></div>';
                }
                $html .= '
                            </div>';
            } else {
                $html .= '<img src="' . $product->Item_Photo_URL . '" alt="' . $product->Item_Name . '" class="first">';
            }
            $html .= '    
                    </div>
                    <div class="col-xs-12 col-md-6 product-details-wrapper">
                        <h2>' . $product->Item_Name . '</h2>';
                        if($extras_date <> '') {
                            $html .= '<div class="price">' . $extras_date . '</div>';
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
                    <div class="enquire-btn-wrapper"><a href="' . get_page_link(38) . '" class="btn btn-default">Back to Odds & Ends</a></div>
                    </div>
                    <hr />
                </div>
            </div>';
            $count++;
        }
        if($count >= 5) {
            // display to top button
            $html .= '<a class="fa fa-arrow-circle-o-up top"></a>';
        }
    } else {
        // display all odds and ends
        $products = getProductsByCategoryID(4, $search_results);
        $count = 1;
        $html = '
        <div class="row">
            <div class="col-xs-12 col-sm-12 search-box-outer-wrapper">
                <div class="search-box-wrapper">
                    <h3>Search Odds & Ends</h3>
                    <form id="search-box" method="post" action="' . get_page_link(38) . '">
                        <div><input type="text" name="odds_search" class="form-control" placeholder="Search by keyword" required="required" value="' . $search_results . '" /> <input type="submit" class="btn btn-danger" value="Search"></div>
                    </form>                  
                </div>';
                if ($search_results <> '') {
                    $html .= '
                            <div class="search-results-wrapper">
                                <p>Search results for: "' . $search_results . '"</p> <a href="' . get_page_link(38) . '" class="btn btn-danger">Reset</a>
                            </div>';
                }
                if (count($products) == 0) {
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
        </div>
        <div class="row">
            <a name="top"></a>';
            foreach ($products as $product) {
                $slug = get_page_link(38);
                $ref = 'itemid='.$product->Item_ID;
                $ref = str_replace(" ", "_", $ref);
                $html .= '
                <div class="col-xs-12 col-md-4 search-panel">
                    <a href="' . $slug . '?' . $ref . '">
                        <div class="image-wrapper">
                            <img src="' . $product->Item_Photo_URL . '" alt="' . $product->Item_Name . '">
                        </div>
                        <div class="details-wrapper odds">
                            <h2>' . $product->Item_Name . '</h2>                  
                        </div>
                    </a>    
                </div>';
                $count++;
            }
            if($count > 5) {
                // display to top button
                $html .= '<a class="fa fa-arrow-circle-o-up top"></a>';
            }
            $html .= '
            <hr />
        </div>';
    }

    return $html;
}