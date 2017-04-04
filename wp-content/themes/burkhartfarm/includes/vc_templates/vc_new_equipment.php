<?php
vc_map( array(
    "name"                    => __( "New Equipment" ),
    "base"                    => "bfe_new_equipment",
    "category"                => __( 'Content' ),
    'show_settings_on_create' => false
) );

add_shortcode( 'bfe_new_equipment', 'bfeNewEquipment' );

function bfeNewEquipment()
{
    (request('srch')) ? $search_results = request('srch') : $search_results = '';
    $products = getProductsByCategoryID(2, $search_results);
    $count = 1;
    $html = '
    <div class="row">
        <div class="col-xs-12 col-sm-12 search-box-outer-wrapper">
            <div class="search-box-wrapper">
                <h3>Search for New Equipment</h3>
                <form id="search-box" method="post" action="' . get_page_link(30) . '">
                    <div><input type="text" name="new_search" class="form-control" placeholder="Search by keyword" required="required" value="' . $search_results . '" /> <input type="submit" class="btn btn-danger" value="Search"></div>
                </form>                  
            </div>';
            if ($search_results <> '') {
                $html .= '
                        <div class="search-results-wrapper">
                            <p>Search results for: "' . $search_results . '"</p> <a href="' . get_page_link(30) . '" class="btn btn-danger">Reset</a>
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
                        <div class="category">Category: ' . $product->SubCategory_Name . '</div>                    
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

    return $html;
}