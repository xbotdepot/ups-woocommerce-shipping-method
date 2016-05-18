<?php

/*

	Plugin Name: UPS (BASIC) WooCommerce Shipping

	Plugin URI: http://www.wooforce.com/shop

	Description: Obtain Real time shipping rates via the UPS Shipping API.

	Version: 1.1.3

	Author: WooForce

	Author URI: http://www.wooforce.com

*/

//Dev Version: 2.6.1

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

}

// Required functions

if ( ! function_exists( 'wf_is_woocommerce_active' ) ) {

	require_once( 'wf-includes/wf-functions.php' );

}

// WC active check

if ( ! wf_is_woocommerce_active() ) {

	return;

}



define("WF_UPS_ID", "wf_shipping_ups");

define("WF_UPS_ADV_DEBUG_MODE", "off"); // Turn 'on' for demo/test sites.



/**

 * WC_UPS class

 */

class UPS_WooCommerce_Shipping {



	/**

	 * Constructor

	 */

	public function __construct() {

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'wf_plugin_action_links' ) );

		add_action( 'woocommerce_shipping_init', array( $this, 'wf_shipping_init') );

		add_filter( 'woocommerce_shipping_methods', array( $this, 'wf_ups_add_method') );

		add_action( 'admin_enqueue_scripts', array( $this, 'wf_ups_scripts') );

	}



	/**

	 * Plugin page links

	 */

	public function wf_plugin_action_links( $links ) {

		$plugin_links = array(

			'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=shipping&section=wf_shipping_ups' ) . '">' . __( 'Settings', 'ups-woocommerce-shipping' ) . '</a>',

			'<a href="http://www.wooforce.com/product/woocommerce-ups-shipping-plugin-with-print-label/" target="_blank">' . __( 'Premium Upgrade', 'wf-shipping-canada-post' ) . '</a>',

			'<a href="https://wordpress.org/support/plugin/ups-woocommerce-shipping-method" target="_blank">' . __( 'Support', 'ups-woocommerce-shipping' ) . '</a>',

		);

		return array_merge( $plugin_links, $links );

	}

	

	/**

	 * wc_ups_init function.

	 *

	 * @access public

	 * @return void

	 */

	function wf_shipping_init() {

		include_once( 'includes/class-wf-shipping-ups.php' );

	}



	/**

	 * wc_ups_add_method function.

	 *

	 * @access public

	 * @param mixed $methods

	 * @return void

	 */

	function wf_ups_add_method( $methods ) {

		$methods[] = 'WF_Shipping_UPS';

		return $methods;

	}



	/**

	 * wc_ups_scripts function.

	 *

	 * @access public

	 * @return void

	 */

	function wf_ups_scripts() {

		wp_enqueue_script( 'jquery-ui-sortable' );

	}

}

new UPS_WooCommerce_Shipping();



/* Add a new country to countries list */

function wf_add_puert_rico_country( $country ) {

  $country["PR"] = 'Puert Rico';  

    return $country; 

}

add_filter( 'woocommerce_countries', 'wf_add_puert_rico_country', 10, 1 );

