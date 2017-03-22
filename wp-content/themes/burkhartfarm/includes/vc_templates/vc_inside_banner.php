<?php
vc_map( array(
    "name" => __("Inside Banner"),
    "base" => "bfe_inside_banner",
    "category" => __('Content'),
    'icon' => 'icon-wpb-single-image',
    'description' => 'Banner for inside pages',
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Page Title"),
            "param_name" => "title",
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Inside Image"),
            "param_name" => "banner",
        ),
    )
));
add_shortcode('bfe_inside_banner', 'insideBanner');
function insideBanner($atts) {
    $args = shortcode_atts( array(
        'title' => '',
        'banner' => '',
    ), $atts);
    $title = $args['title'];
    $banner = intval($args['banner']);
    $bannerImage = '';
    if($banner) {
        //$image = wp_get_attachment_image_src($banner, 'inside_banner');
        //$backgroundImage = $image[0];
        $bannerImage = wp_get_attachment_image($banner, 'inside_banner');
    }
    $html = '
    <div class="inside-banner-wrapper">
        ' . $bannerImage . '
        <h1>' . $title . '</h1>
    </div>';
    return $html;
}