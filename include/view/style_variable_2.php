<?php
if (!defined('ABSPATH')) exit;

class style_Variable_2
{
    static public function style_2($id_product, $text_not_found, $desc_support, $text_button)
    {
        global $product;
       

        $attributes = $product->get_variation_attributes();
        $attribute_keys = array_keys($attributes);

        echo "<div id='whatsapp-adv-form'>
              <input type='hidden' value='$id_product' name='id_product' id='id_product' />
              <input type='hidden' value='$id_product' name='id_variable' id='id_variable' />";

        $count = 1;

        foreach ($attributes as $attribute_name => $options) :
            if ($count <= 1) {
                ?>
                <tr>
                <td class="value">
                <div class="box-adv-whatsapp">
                <label class="label-adv" for="<?php echo sanitize_title($attribute_name); ?>"><?php echo wc_attribute_label($attribute_name); ?></label>
                <?php
                $selected = isset($_REQUEST['attribute_' . sanitize_title($attribute_name)]) ? wc_clean(urldecode($_REQUEST['attribute_' . sanitize_title($attribute_name)])) : $product->get_variation_default_attribute($attribute_name);
                $args = array('options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected);
                self::wc_dropdown_variation_attribute_options_adviser($args);
                echo end($attribute_keys) === $attribute_name ? apply_filters('woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . __('Clear', 'woocommerce') . '</a>') : '';
                echo '</div>';
            } else {
                ?>
                <div class="attribute-woocommerce box-adv-whatsapp">
                <label class="label-adv"  for="<?php echo sanitize_title($attribute_name); ?>">
                    <?php echo wc_attribute_label($attribute_name); ?>  </label>
                    <select id="attribute-<?php echo sanitize_title($attribute_name); ?>"
                            class="attribute-select select-adv-whatsapp"></select>
                <div id="attribute-<?php echo sanitize_title($attribute_name); ?>_adv" class="select-attr-adv" ></div>
                </div>
            <?php } ?>
            </td>
            </tr>
            <?php

            $count++;
        endforeach;
        echo "<div id='clean-attributes'><button id='clean-attribute' class='clean-reset'><i class='icon-trash-adv'></i>".__('Limpiar', '')."</button></div>";
        echo "<div id='button_payment_answer'><button id='answer-whatsapp' class='btn-cotiza'>$text_button</button></div>";
        echo "</div>";
        echo '<div id="adv-whatsapp-adviser"></div>';
        echo '<div class="loader-adviser">
                        <div class="lds-ripple-loader">
                            <div></div>
                            <div></div>
                        </div>
                    </div>';
        echo'<div id="input-file-adv"></div>';

    }

    public static function wc_dropdown_variation_attribute_options_adviser($args = array())
    {
        $args = wp_parse_args(
            apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args),
            array(
                'options' => false,
                'attribute' => false,
                'product' => false,
                'selected' => false,
                'name' => '',
                'id' => '',
                'class' => '',
                'show_option_none' => __('Choose an option', 'woocommerce'),
            )
        );

        // Get selected value.
        if (false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product) {
            $selected_key = 'attribute_' . sanitize_title($args['attribute']);
            // phpcs:disable WordPress.Security.NonceVerification.Recommended
            $args['selected'] = isset($_REQUEST[$selected_key]) ? wc_clean(wp_unslash($_REQUEST[$selected_key])) : $args['product']->get_variation_default_attribute($args['attribute']);
            // phpcs:enable WordPress.Security.NonceVerification.Recommended
        }

        $options = $args['options'];
        $product = $args['product'];
        $attribute = $args['attribute'];
        $name = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title($attribute);
        $id = $args['id'] ? $args['id'] : sanitize_title($attribute);
        $class = $args['class'];
        $show_option_none = (bool)$args['show_option_none'];
        $show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __('Choose an option', 'woocommerce'); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

        if (empty($options) && !empty($product) && !empty($attribute)) {
            $attributes = $product->get_variation_attributes();
            $options = $attributes[$attribute];
        }

        $html = '<select id="' . esc_attr($id) . '" class="' . esc_attr($name) . ' select-adviser select-adv-whatsapp" name="' . esc_attr($name) . '" data-attribute_name="attribute_' . esc_attr(sanitize_title($attribute)) . '" data-show_option_none="' . ($show_option_none ? 'yes' : 'no') . '">';
        $html .= '<option value="">' . esc_html($show_option_none_text) . '</option>';

        if (!empty($options)) {
            if ($product && taxonomy_exists($attribute)) {
                // Get terms if this is a taxonomy - ordered. We need the names too.
                $terms = wc_get_product_terms(
                    $product->get_id(),
                    $attribute,
                    array(
                        'fields' => 'all',
                    )
                );

                foreach ($terms as $term) {

                    if (in_array($term->slug, $options, true)) {
                        $html .= '<option value="' . esc_attr($term->slug) . '" ' . selected(sanitize_title($args['selected']), $term->slug, false) . '>' . esc_html(apply_filters('woocommerce_variation_option_name', $term->name, $term, $attribute, $product)) . '</option>';
                    }
                }
            } else {
                foreach ($options as $option) {
                    // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
                    $selected = sanitize_title($args['selected']) === $args['selected'] ? selected($args['selected'], sanitize_title($option), false) : selected($args['selected'], $option, false);
                    $html .= '<option value="' . esc_attr($option) . '" ' . $selected . '>' . esc_html(apply_filters('woocommerce_variation_option_name', $option, null, $attribute, $product)) . '</option>';
                }
            }
        }

        $html .= '</select>';

        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo apply_filters('woocommerce_dropdown_variation_attribute_options_html', $html, $args);
    }


}

new style_Variable_2();

