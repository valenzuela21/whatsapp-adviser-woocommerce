<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function adviser_result_whatsapp() {
    
    if(isset( $_POST['respuesta'] ) ) {
        $respuestas = wp_unslash( $_POST['respuesta'] );
        array();
    }
    
    $product_id = $respuestas[0];
    $variation_id = $respuestas[1];
    
    $variation = wc_get_product($variation_id);
    $variation_title = $variation->get_title();
    $variation_attributes = $variation->get_variation_attributes();
    $variation_price = $variation->get_price_html();
    
    //$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($variation_id), array('220','220'), true );
    //$thumbnail_url = $thumbnail_url[0];

    $thumbnail_url = get_option( 'adviser-admin-whatsapp' );
    $thumbnail_url = $thumbnail_url['image-file'];

    if(empty($thumbnail_url)){
        $thumbnail_url = 'https://via.placeholder.com/250';
    }

    $textafter =   esc_attr( get_post_meta($product_id, 'symbol_price_voral', true));
    
    $description = get_post_meta($variation_id, '_variation_description', true);
    
    header("Content-type: application/json");
    echo json_encode([ $variation_title,  $variation_attributes, $variation_price."<span>".$textafter."<span>", $thumbnail_url,  $description]);

    die();

}
add_action('wp_ajax_nopriv_adviser_result_whatsapp', 'adviser_result_whatsapp');
add_action('wp_ajax_adviser_result_whatsapp', 'adviser_result_whatsapp');




function adviser_result_whatsapp_select(){
    if(isset( $_POST['respuesta'] ) ) {
        $respuestas = wp_unslash( $_POST['respuesta'] );
        array();
    }

    $product_id = $respuestas[0];

    $args = [
        'p'=> $product_id,
        'post_status' => 'publish',
        'post_type' => 'product',
    ];

    $consult = get_posts($args);

    $array_general_attributes = [];

    foreach ($consult as $key => $item) {
        $product = new WC_Product_Variable($product_id);
        $variables = $product->get_children();
        $attributes_link = $product->get_permalink();

        foreach ( $variables as $variation ) {
            $variation_ID = $variation;
            $textafter =   esc_attr( get_post_meta($product_id, 'symbol_price_voral', true));
            // get variations meta
            // https://woocommerce.github.io/code-reference/classes/WC-Product-Variation.html
            $product_variation = new WC_Product_Variation($variation_ID);
            $id_variation = $product_variation->get_id();
            $data = $product_variation->get_data();
            $attributes_summary = $product_variation->get_attribute_summary();
            $attributes_price = $product_variation->get_price_html();
            $attributes_title = $product_variation->get_title();
            $attributes_custom = get_post_meta($variation_ID, 'custom_field_whatsapp_data', true);
          

            if(in_array($respuestas[1], $data["attributes"])) {
                array_push($array_general_attributes, [$id_variation, $data["attributes"], $attributes_summary, $attributes_price.'<span class="textafter"> '.$textafter.'</span>', $attributes_custom, $attributes_link, $attributes_title]);
            }
        }
    }


    header("Content-type: application/json");
    echo json_encode([$array_general_attributes]);

    die();

}

add_action('wp_ajax_nopriv_adviser_result_whatsapp_select', 'adviser_result_whatsapp_select');
add_action('wp_ajax_adviser_result_whatsapp_select', 'adviser_result_whatsapp_select');