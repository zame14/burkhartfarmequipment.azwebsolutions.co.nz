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
    $products = getProductsByCategoryID(4);
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


    return $html;
}