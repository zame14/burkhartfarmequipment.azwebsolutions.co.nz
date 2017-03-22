<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 3/3/2017
 * Time: 12:18 PM
 */

/**
 * Forces a stylesheet (usually the theme's) to appear at the very end when wp_head() is being generated
 *
 * @return void
 *
 * @author Nigel Wells
 * @modified 2016.02.29
 */
add_action( 'wp_print_styles', 'apex_adjustStylesheetOrder', 99);
function apex_adjustStylesheetOrder() {
    global $wp_styles, $apexAdjustStylesheet;

    if(!$apexAdjustStylesheet) return;

    $keys=[];
    $keys[] = $apexAdjustStylesheet;

    foreach($keys as $currentKey) {
        $keyToSplice = array_search($currentKey,$wp_styles->queue);

        if ($keyToSplice!==false && !is_null($keyToSplice)) {
            $elementToMove = array_splice($wp_styles->queue,$keyToSplice,1);
            $wp_styles->queue[] = $elementToMove[0];
        }

    }

    return;
}

/**
 * Load any Visual Composer templates to map in to the editor
 *
 * @param string $vcDir     Directory to search for custom Visual Composer templates
 *
 * @return void
 *
 * @author Nigel Wells
 * @modified 2016.03.02
 */
function apex_loadVCTemplates($vcDir = '') {
    if(!function_exists('vc_map')) return;
    // Set default
    if(!$vcDir) {
        $vcDir = STYLESHEETPATH . '/includes/vc_templates/';
    }
    if (is_dir($vcDir)) {
        if ( $dh = opendir( $vcDir ) ) {
            while ( ( $file = readdir( $dh ) ) !== false ) {
                if ( substr( $file, 0, 3 ) == 'vc_' && substr( $file, - 4 ) == '.php' ) {
                    require_once($vcDir . $file);
                }
            }
        }
    }
}
/**
 * Gravity Forms Bootstrap Styles
 *
 * Applies bootstrap classes to various common field types.
 * Requires Bootstrap to be in use by the theme.
 *
 * Using this function allows use of Gravity Forms default CSS
 * in conjuction with Bootstrap (benefit for fields types such as Address).
 *
 * @see  gform_field_content
 * @link http://www.gravityhelp.com/documentation/page/Gform_field_content
 *
 * @return string Modified field content
 */
add_filter("gform_field_content", "bootstrap_styles_for_gravityforms_fields", 10, 5);
function bootstrap_styles_for_gravityforms_fields($content, $field, $value, $lead_id, $form_id){
    // Currently only applies to most common field types, but could be expanded.
    if($field["type"] != 'hidden' && $field["type"] != 'list' && $field["type"] != 'multiselect' && $field["type"] != 'checkbox' && $field["type"] != 'fileupload' && $field["type"] != 'date' && $field["type"] != 'html' && $field["type"] != 'address') {
        $content = str_replace('class=\'medium', 'class=\'form-control medium', $content);
        $content = str_replace('class=\'large', 'class=\'form-control large', $content);
    }

    if($field["type"] == 'name' || $field["type"] == 'address') {
        $content = str_replace('<input ', '<input class=\'form-control\' ', $content);
    }

    if($field["type"] == 'textarea') {
        $content = str_replace('class=\'textarea', 'class=\'form-control textarea', $content);
    }

    if($field["type"] == 'checkbox') {
        $content = str_replace('li class=\'', 'li class=\'checkbox ', $content);
        $content = str_replace('<input ', '<input style=\'margin-left:1px;\' ', $content);
    }

    if($field["type"] == 'radio') {
        $content = str_replace('li class=\'', 'li class=\'radio ', $content);
        $content = str_replace('<input ', '<input style=\'margin-left:1px;\' ', $content);
    }

    return $content;
}