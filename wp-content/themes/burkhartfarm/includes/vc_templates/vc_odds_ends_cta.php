<?php
vc_map( array(
    "name" => __("Odds & Ends CTA"),
    "base" => "bfe_odds_ends_cta",
    "category" => __('Content'),
    'icon' => 'icon-wpb-single-image',
    'description' => 'Odds & Ends CTA for home page',
    "params" => array(
        array(
            "type" => "attach_image",
            "heading" => __("Odds & Ends Banner Image"),
            "param_name" => "banner",
        ),
    )
));
add_shortcode('bfe_odds_ends_cta', 'oddsEndsCTA');
function oddsEndsCTA($atts) {
    $args = shortcode_atts( array(
        'banner' => '',
    ), $atts);
    $banner = intval($args['banner']);
    $bannerImage = '';
    if($banner) {
        //$image = wp_get_attachment_image_src($banner, 'inside_banner');
        //$backgroundImage = $image[0];
        $bannerImage = wp_get_attachment_image($banner, 'odds_ends_banner');
    }
    $html = '
    <div class="odds-ends-wrapper">
        ' . $bannerImage . '
        <div class="odds-cta-wrapper">
            <p>We also do Odds & Ends</p>
            <p>There\'s nothing we can\'t do!</p>
            <a class="btn btn-default" href="/contact-us/">View Odds & Ends</a>
        </div>
        <div class="overlay"></div>
    </div>';
    return $html;
}