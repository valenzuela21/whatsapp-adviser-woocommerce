<?php
if (!defined('ABSPATH')) exit;
$xbox = Xbox::get('support-product');
$active = $xbox->get_field_value('active-support');
remove_addtocart_product_adviser();
if ($active) {
    global $product;
    $xbox_general = Xbox::get('adviser-admin-whatsapp');
    $txt_wellcom = $xbox_general->get_field_value('text-wellcom');
    $title_support = $xbox_general->get_field_value('title-support');
    $desc_support = $xbox_general->get_field_value('desc-support');
    $text_button = $xbox_general->get_field_value('text-button');
    $text_not_found = $xbox_general->get_field_value('text-not-found');
    $select_style_variable = $xbox_general->get_field_value('type-style-advise');

    if ($product->is_type('variable')) {

        $id_product = $product->get_id();

        if($select_style_variable == '1'){
            style_Variable_1::style_1($title_support, $text_not_found, $desc_support, $text_button);
        }else{
            style_Variable_2::style_2($id_product, $text_not_found, $desc_support, $text_button);
        }


    } else {

        $xbox = Xbox::get('support-product');
        $value = $xbox->get_field_value('support-whatsapp');

        echo '<div class="whatsapp-voral">';

        if (empty($value)) {

            echo "<div class='adviser-not-found'>" . $text_not_found . "</div>";

        } else {

            ?>

            <div class="select-adviser">
                <h4 class="title-adviser"><?php echo $title_support; ?></h4>
                <p class="txt-parrafo"><?php echo $desc_support; ?></p>
                <?php foreach ($value as $item) { ?>
                    <div class="row-voral">
                        <div class="column-voral-1">
                            <h4 class="title"><?php echo $item['name-whatsapp-author']; ?></h4>
                            <p class="sub-title"><?php echo $item['support-whatsapp-author']; ?></p>
                        </div>
                        <div class="column-voral-2">
                            <i class="phone-call" phone="<?php echo $item['phone-whatsapp-author']; ?>"
                               title="<?php echo $product->post->post_title; ?>"
                               link="<?php echo esc_url(get_permalink(), 'adviser_voral_piedra'); ?>"></i>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
        }
        echo "</div>";
    }
}else{
    global $product;
    $id_product = $product->get_id();
    style_AddCart::view_add_cart($id_product);
}

function remove_addtocart_product_adviser()
{
    //remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
    //remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    remove_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
    //remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
    remove_action('woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30);
    //remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
}