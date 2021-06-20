<?php
add_action( 'xbox_init', 'adviser_admin_page_whatsapp');
function adviser_admin_page_whatsapp(){
	$options = array(
		'id' => 'adviser-admin-whatsapp',//It will be used as "option_name" key to save the data in the wp_options table
		'title' => __( 'Whatsapp Support Product', 'adviser_voral_piedra' ),
		'menu_title' => __( 'Whatsapp Support Product', 'adviser_voral_piedra' ),
		'icon' => 'dashicons-whatsapp',
	);
 
	$xbox = xbox_new_admin_page( $options );
	$xbox->add_field(array(
	'id' => 'text-wellcom',
	'name' => __( 'Text Wellcom', 'adviser_voral_piedra' ),
	'type' => 'text',
	'default' => __( 'Cotizar con un asesor el tema de envio', 'adviser_voral_piedra' ),));
	
	$xbox->add_field(array(
	'id' => 'title-support',
	'name' => __( 'Title Support', 'adviser_voral_piedra' ),
	'type' => 'text',
	'default' => __( 'Asesores Disponibles' ),));
	
	$xbox->add_field(array(
	'id' => 'desc-support',
	'name' => __( 'Description Support', 'adviser_voral_piedra' ),
	'type' => 'textarea',
	'default' => __( 'Hola estos son los asesores que estan dispuestos en atenderte', 'adviser_voral_piedra' ),
   ));
   
    $xbox->add_field(array(
	'id' => 'text-button',
	'name' => __( 'Text Button', 'adviser_voral_piedra' ),
	'type' => 'text',
	'default' => __( 'Cotizar', 'adviser_voral_piedra' ),
    ));
    
   $xbox->add_field(array(
	'id' => 'text-not-found',
	'name' => __( 'Description Not Found', 'adviser_voral_piedra' ),
    'type' => 'wp_editor',
	'default' => __( 'No hay asesores disponibles para este producto. <br> contáctenos: info@voralpiedra.com','adviser_voral_piedra', 'adviser_voral_piedra' ),
   ));

   $xbox->add_field(array(
        'id' => 'image-file',
        'name' => __( 'Image', 'adviser_voral_piedra' ),
        'type' => 'file',
    ));


    $xbox->add_field( array(
        'id' => 'type-style-advise',
        'name' => __( 'Select Style Product Variable', 'adviser_voral_piedra' ),
        'type' => 'select',
        'default' => '1',
        'items' => array(
            '1' => 'Style 1',
            '2' => 'Style 2',
        ),
    ));

}
 