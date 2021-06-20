<?php
if (!defined('ABSPATH')) exit;
class style_Variable_1
{

    static public function style_1($title_support, $text_not_found, $desc_support, $text_button )
    {

        global $product, $post;
        $variations = $product->get_available_variations();

        ?>
        <div class="scroll-adviser-products">
            <table class="adviser-table-products">
                <tbody>
                <tr>
                    <th style="padding: 5px 15px;"><?php __('Producto', 'adviser_voral_piedra');?></th>
                    <th style="padding: 5px 15px;"><?php __('Precio', 'adviser_voral_piedra');?></th>
                </tr>
                <?php
                foreach ($variations as $key => $value) {
                    ?>
                    <tr>
                        <td class="column-1">
                            <p><?php
                                $attribute = implode(', ', $value['attributes']);
                                echo str_replace("-", " ", $attribute);
                                echo $value['variation_description'];
                                ?></p>
                        </td>
                        <td class="column-2">
                            <p><?php echo (!empty($value['price_html'])) ? $value['price_html'] : $product->get_price_html(); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                            if (!empty($value['attributes'])) {
                                foreach ($value['attributes'] as $attr_key => $attr_value) {
                                    ?>
                                    <input type="hidden" name="<?php echo $attr_key ?>"
                                           value="<?php echo $attr_value ?>">
                                    <?php
                                }
                            }
                            ?>
                            <button id-product="<?php echo esc_attr($post->ID); ?>"
                                    id-variation="<?php echo $value['variation_id'] ?>"
                                    class="button_action"><?php echo $text_button ?></button>
                        </td>
                    </tr>

                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <!--Modal Client Devise-->
        <div class="loader-adviser">
            <div class="lds-ripple-loader">
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="support-product-chat">
            <div class="modal-shadow"></div>
            <div class="chat-whatsapp-advise">

                <span class="close-modal-support">&#x00d7;</span>
                <div id="header_html"></div>
                <div class="whatsapp-voral">
                    <div class="select-adviser">
                        <h4 class="title-adviser"><?php echo $title_support; ?></h4>
                        <p class="txt-parrafo"><?php echo $desc_support; ?></p>
                        <?php
                        $xbox = Xbox::get('support-product');
                        $value = $xbox->get_field_value('support-whatsapp');

                        echo '<div class="whatsapp-voral">';

                        if (empty($value)) {

                            echo "<div class='adviser-not-found'>" . $text_not_found . "</div>";

                        } else {

                            foreach ($value as $item) { ?>
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
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <?php
    }

}

new style_Variable_1();