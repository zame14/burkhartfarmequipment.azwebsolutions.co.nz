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
        array(
            "type" => "textfield",
            "heading" => __("Line One"),
            "param_name" => "line_one",
        ),
        array(
            "type" => "textfield",
            "heading" => __("Line Two"),
            "param_name" => "line_two",
        ),
        array(
            "type" => "textfield",
            "heading" => __("Button Text"),
            "param_name" => "button_text",
        ),
        array(
            "type" => "textfield",
            "heading" => __("Button Link"),
            "param_name" => "button_link",
        ),
    )
));
add_shortcode('bfe_odds_ends_cta', 'oddsEndsCTA');
function oddsEndsCTA($atts) {
    $args = shortcode_atts( array(
        'banner' => '',
        'line_one' => '',
        'line_two' => '',
        'button_text' => '',
        'button_link' => ''
    ), $atts);
    $banner = intval($args['banner']);
    $line_one = $args['line_one'];
    $line_two = $args['line_two'];
    $button_text = $args['button_text'];
    $button_link = $args['button_link'];
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
            <p>' . $line_one . '</p>';
            if($line_two <> '') {
                $html .= '<p>' . $line_two . '</p>';
            }
            $html .= '
            <a class="btn btn-default" href="' . $button_link . '">' . $button_text . '</a>
        </div>
        <div class="overlay"></div>
    </div>';
    return $html;
}