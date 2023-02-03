<?php
defined( 'ABSPATH' ) || exit;


class Menu {
	protected $ext_url = 'http://';
	protected static $_extensions = array(
		'easy-auto-complete'             => array(
			'name' => 'Auto Complete Checkout form',
			'slug' => 'easy-auto-complete',
			'file' => 'wpc-product-bundles.php'
		),
		'easy-auto-coupon'             => array(
			'name' => 'Auto Use Coupons',
			'slug' => 'easy-auto-complete',
			'file' => 'easy-auto-coupon.php'
		),
	);

	function __construct() {
		add_action( "admin_menu", array( $this, 'admin_menu' ) );
	}

	function admin_menu() {
		add_submenu_page(
			"easyBuyNow",
			"EBN Extension",
			"Extension",
			"manage_options",
			"ebn-extension",
			array( $this, 'extension_content' ),
		);
	}

	//显示可安装插件扩展
	function extension_content() {
	?><h1>Extension</h1><?php
		// 查找扩展源
		
		//显示页面内容
		include EBN_DIR . "template/extension_content.php";
	}

	//添加插件扩展
	function add_extension( $extension ) {
		return 0;
	}

	//启用插件扩展
	function active_extension( $extension ) {
		return 0;
	}

	//禁用插件扩展
	function deactive_extension( $extension ) {
		return 0;
	}

	//移除插件扩展
	function remove_extension( $extension ) {
		return 0;
	}
}