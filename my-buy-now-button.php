<?php
/*
	Plugin Name:Easy Buy now Button for WooCommerce
	Description:
	Version: 0.0.4
 */


if (!defined('ABSPATH')) {
	die;
}

define( "EBN_DIR", __DIR__ . '/');
define('EBN_URL', plugins_url('/', __FILE__));

define('MY_BUY_NOW_BUTTO_FOR_WC_VERSION', '0.0.4');


global $woocommerce;
//载入buy now按钮方法
require "include/buy-now.php";
if ( ! function_exists( 'ebnbtn_init' ) ) {
	add_action( 'plugins_loaded', 'ebnbtn_init', 11 );

}

//添加附加菜单
if( ! class_exists( "Menu" )){
	require "include/backend.php";

	new Menu();
}
//if ( $woocommerce->is_product() ){
//	print_r("load btn");
//}
