<?php

class Product_Variable_Field
{

    /**
     * Product_Variable_Field constructor.
     */
    public function __construct()
    {
        add_action('woocommerce_product_after_variable_attributes', [$this, 'bbloomer_add_custom_field_to_variations'], 10, 3);
        add_action('admin_enqueue_scripts', [$this, 'require_file_css_js_metabox'], 10, 1);

        add_action('woocommerce_save_product_variation', [$this, 'bbloomer_save_custom_field_variations'], 10, 2);
    }

    public function require_file_css_js_metabox($hook)
    {

        global $post;

        if ($hook == 'post-new.php' || $hook == 'post.php') {
            if ('product' === $post->post_type) {
                wp_enqueue_style('style_form_smart_file_input', plugins_url('../assets/css/smart-forms.css', __FILE__));
                wp_enqueue_style('style_font_awesome_file_input', plugins_url('../assets/css/font-awesome.min.css', __FILE__));
                wp_enqueue_script('js_cloneya_file_input', plugins_url('../assets/js/jquery-cloneya.min.js', __FILE__), array('jquery'), 1.0, false);
                wp_enqueue_script('js_cloneya_script_file_input', plugins_url('../assets/js/script_clone.js', __FILE__), array('jquery'), 1.0, false);
            }
        }
    }

    public function bbloomer_add_custom_field_to_variations($loop, $variation_data, $variation)
    {

        $data = get_post_meta($variation->ID, 'custom_field_whatsapp_data', true);

        ?>
        <script>
            jQuery(document).ready(function ($) {
                /* Simple Cloning
                ------------------------------------------------- */
                $('.clone-fields').cloneya();

            });
        </script>
        <div class="smart-forms">
            <form method="post" action="/" id="account2">
                <div class="clone-fields">


                    <?php
                    if(!empty($data)){

                    $array_name = [];
                    $array_positon = [];
                    $array_phone = [];
                    foreach ($data as $item) {
                        $name = $item["name_whatsapp"];
                        $position = $item["position_whatsapp"];
                        $phone = $item["phone_whatsapp"];
                        array_push($array_name, $name);
                        array_push($array_positon, $position);
                        array_push($array_phone, $phone);
                    }


                       for ($i = 0; $i < count($array_phone[0]); $i++) {
                            ?>
                    <div class="toclone clone-widget">
                            <div class="frm-row">
                                <div class="spacer-b10 colm colm4">
                                    <label class="field">
                                        <input type="text" class="gui-input" name="name_whatsapp_<?php echo $variation->ID ?>[]" id="name_whatsapp"
                                               value="<?php echo esc_html($array_name[0][$i]) ?>"
                                               placeholder="Nombre Contácto">
                                    </label>
                                </div>
                                <div class="spacer-b10 colm colm4">
                                    <label class="field">
                                        <input type="text" class="gui-input" name="position_whatsapp_<?php echo $variation->ID ?>[]" id="name_whatsapp"
                                               value="<?php echo esc_html($array_positon[0][$i]) ?>"
                                               placeholder="Cargo">
                                    </label>
                                </div>
                                <div class="spacer-b10 colm colm4">
                                    <label class="field">
                                        <input type="text" class="gui-input" name="phone_whatsapp_<?php echo $variation->ID ?>[]" id="phone_whatsapp"
                                               value="<?php echo esc_html($array_phone[0][$i]) ?>"
                                               placeholder="Número Telefónico">
                                    </label>
                                </div>
                            </div>
                        <a href="#" class="clone button btn-primary"><i class="fa fa-plus"></i></a>
                        <a href="#" class="delete button"><i class="fa fa-minus"></i></a>
                    </div>
                            <?php
                        }
                    }else{
                        ?>
                        <div class="toclone clone-widget">
                            <div class="frm-row">
                                <div class="spacer-b10 colm colm4">
                                    <label class="field">
                                        <input type="text" class="gui-input" name="name_whatsapp_<?php echo $variation->ID ?>[]" id="name_whatsapp"
                                               placeholder="Nombre Contácto">
                                    </label>
                                </div>
                                <div class="spacer-b10 colm colm4">
                                    <label class="field">
                                        <input type="text" class="gui-input" name="position_whatsapp_<?php echo $variation->ID ?>[]" id="name_whatsapp"
                                               placeholder="Cargo">
                                    </label>
                                </div>
                                <div class="spacer-b10 colm colm4">
                                    <label class="field">
                                        <input type="text" class="gui-input" name="phone_whatsapp_<?php echo $variation->ID ?>[]" id="phone_whatsapp"
                                               placeholder="Número Telefónico">
                                    </label>
                                </div>
                            </div>
                            <a href="#" class="clone button btn-primary"><i class="fa fa-plus"></i></a>
                            <a href="#" class="delete button"><i class="fa fa-minus"></i></a>
                        </div>
                    <?php } ?>

                </div><!-- end #clone-fields -->
            </form>
        </div><!-- end .smart-forms section -->
        <?php
    }

    public function bbloomer_save_custom_field_variations($variation_id, $i)
    {
       
        $name_whatsapp = $_POST['name_whatsapp_'.$variation_id];
        $position_whatsapp = $_POST['position_whatsapp_'.$variation_id];
        $phone_whatsapp = $_POST['phone_whatsapp_'.$variation_id];

        $post = (isset($name_whatsapp) && !empty($name_whatsapp)) &&
        (isset($position_whatsapp) && !empty($position_whatsapp)) &&
        (isset($phone_whatsapp) && !empty($phone_whatsapp));


        if ($post) {
            $array_object = [];
            $array_object['name_whatsapp'] = $name_whatsapp;
            $array_object['position_whatsapp'] = $position_whatsapp;
            $array_object['phone_whatsapp'] = $phone_whatsapp;
            update_post_meta($variation_id, 'custom_field_whatsapp_data', [$array_object]);
        }else{
            update_post_meta($variation_id, 'custom_field_whatsapp_data', ['']);
        }

    }
}

new Product_Variable_Field();




