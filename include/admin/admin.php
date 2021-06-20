<?php
if( ! defined( 'XBOX_HIDE_DEMO' ) ){
    define( 'XBOX_HIDE_DEMO', true );
}
add_action( 'xbox_init', 'metabox_view_support_product');
function metabox_view_support_product(){
    $options = array(
        'id' => 'support-product',//Must be unique for each metabox that is created with xbox.
        'title' => __('Whatsapp Author', 'adviser_voral_piedra'),
        'post_types' => array('product'),
    );
    $xbox = xbox_new_metabox( $options );
    $xbox->add_field(array(
        'id' => 'active-support',
        'name' => __( 'Active Support', 'adviser_voral_piedra' ),
        'type' => 'checkbox',
        'default' => '',
        'items' => array(
            'option1' => 'ACTIVE',
        )
    ));
    $group = $xbox->add_group( array(
        'name' => __('whatsapp', 'adviser_voral_piedra'),
        'id' => 'support-whatsapp',
        'options' => array(
            'add_item_text' => __('New Whatsapp', 'adviser_voral_piedra'),
        ),
        'controls' => array(
            'name' => 'Support #'
        )
    ));
    $group->add_field(array(
        'id' => 'name-whatsapp-author',
        'name' => __( 'Name Person', 'adviser_voral_piedra' ),
        'type' => 'text',
    ));
    $group->add_field(array(
        'id' => 'support-whatsapp-author',
        'name' => __( 'Area Person', 'adviser_voral_piedra' ),
        'type' => 'text',
    ));
    $group->add_field(array(
        'id' => 'phone-whatsapp-author',
        'name' => __( 'Phone Person', 'adviser_voral_piedra' ),
        'type' => 'text',
    ));

}