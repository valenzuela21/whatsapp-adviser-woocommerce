<?php
/*
Plugin Name:  Voral Piedra Cotizador Adviser
Plugin URI:   https://www.ideoviral.com.co/
Description:  Adviser select whatsapp for woocommerce single product
Version:      1.0
Author:       David Valenzuela Pardo
Author URI:   https://www.behance.net/vlzdavid127aa9
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  adviser_voral_piedra
*/

if ( ! defined( 'ABSPATH' ) ) exit;

class Wc_Adviser_call{

    /**
     * Wc_Adviser_call constructor.
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'frontend_styles_adviser']);
        add_action( 'woocommerce_product_meta_start', [$this, 'woocommerce_product_adviser'], 20 );
        add_action( 'woocommerce_product_thumbnails', [$this, 'woocommerce_view_attributes_adviser'], 500);
        add_filter( 'woocommerce_product_tabs', array($this,'tutsplus_remove_product_attributes_tab'), 100 );
    }

    public function frontend_styles_adviser(){
        $xbox = Xbox::get( 'adviser-admin-whatsapp' );
        $xbox_general = Xbox::get('support-product');
        $active =  $xbox_general->get_field_value('active-support');
        $subititle = $xbox->get_field_value( 'desc-support' );
        $no_found = $xbox->get_field_value( 'text-not-found' );


        wp_enqueue_style('style_frontend_adviser_call', plugins_url('./assets/css/style.css', __FILE__) );
        
        if ($active) {
            wp_enqueue_script('js_frontend_adviser_call_1', plugins_url('./assets/js/script.js', __FILE__), array('jquery'), 1.0, true);
            
            wp_localize_script('js_frontend_adviser_call_1', 'admin_url', array(
                'ajax_url' => admin_url('admin-ajax.php'),
            ));
            
            wp_enqueue_script('js_frontend_adviser_call_2', plugins_url('./assets/js/select_script.js', __FILE__), array('jquery'), 1.0, true);
          
            wp_localize_script('js_frontend_adviser_call_2', 'object_data', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'subtitle' => $subititle,
                'no_found' => $no_found,
            ));
        }else{
            wp_enqueue_script('js_frontend_adviser_call_2', plugins_url('./assets/js/select_script_cart.js', __FILE__), array('jquery'), 1.0, true);
            wp_localize_script('js_frontend_adviser_call_2', 'admin_url', array(
                'ajax_url' => admin_url('admin-ajax.php'),
            ));
        }

    }

    public function woocommerce_product_adviser()
    {
        require_once plugin_dir_path(__FILE__) . './include/view_hook_cotiza.php';
    }

    public function woocommerce_ajax_relations(){
        require_once plugin_dir_path(__FILE__) . './xbox/xbox.php';
        require_once plugin_dir_path(__FILE__) . './include/ajax_select_relations.php';
        require_once plugin_dir_path(__FILE__) . './include/admin/admin.php';
        require_once plugin_dir_path(__FILE__) . './include/admin/admin_general.php';

        require_once plugin_dir_path(__FILE__) . './include/view/style_variable_1.php';
        require_once plugin_dir_path(__FILE__) . './include/view/style_variable_2.php';
        require_once plugin_dir_path(__FILE__) . './include/view/style_add_cart.php';

        require_once plugin_dir_path(__FILE__) . './include/custom_field_attributes.php';
        require_once plugin_dir_path(__FILE__) . './include/add_cart_action.php';
    }
    
    public function woocommerce_view_attributes_adviser(){
            global $product;
			echo wc_display_product_attributes( $product );
    }
    public function adviser_remove_product_attributes_tab( $tabs ) {
 		unset( $tabs['additional_information'] );
     	return $tabs;
 	}

}

$app = new Wc_Adviser_call();
$app->woocommerce_ajax_relations();









