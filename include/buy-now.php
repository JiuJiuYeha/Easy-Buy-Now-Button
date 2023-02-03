<?php
if ( ! defined( "ABSPATH" ) ) {
	die;
}

if ( ! function_exists( 'ebnbtn_init' ) ) {
	add_action( 'plugins_loaded', 'ebnbtn_init', 11 );

	function ebnbtn_init() {
		// load text-domain
		//load_plugin_textdomain( 'easy-buy-now-button', false, basename( __DIR__ ) . '/languages/' );

		if ( ! function_exists( 'WC' ) || ! version_compare( WC()->version, '3.0', '>=' ) ) {
			add_action( 'admin_notices', 'ebnbtn_notice_wc' );

			return false;
		}

		if ( ! class_exists( 'EBNbuyNowBtn' ) && class_exists( 'WC_Product' ) ) {
			class EBNbuyNowBtn {
				protected static $instance = null;
				protected static $settings = [];

				public static function instance() {
					if ( is_null( self::$instance ) ) {
						self::$instance = new self();
					}

					return self::$instance;
				}

				function __construct() {
					self::$settings = (array) get_option('ebn_settings', []);

					//添加样式与js
					add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
					add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
					//添加按钮
					add_action( 'woocommerce_after_add_to_cart_button', [ $this, 'buynow_button' ] );
					//添加buy now处理事件
					add_action( 'easy_buy_now_handle', [ $this, 'buynow_handle' ] );
					
					//add_action( 'admin_init', [ $this, 'register_settings' ] );
					//添加后台菜单
					add_menu_page(
						"Easy Buy Now",
						"Easy Buy Now",
						"manage_options",
						"easyBuyNow",
						[$this , "setting_menu"],
						'/',
						81
					);
				}
				//添加设置页
				function setting_menu(){
					?>
					<h1>Setting</h1>
					<?php
					include EBN_DIR . "template/setting_content.php";
				}

				//引用前台样式与js脚本
				function enqueue_scripts() {
					wp_enqueue_style( 'wpcbn-frontend', EBN_URL . 'static/css/easy-buy-now-styles.css', array(), 0.1 );
					wp_enqueue_script( 'wpcbn-frontend', EBN_URL . 'static/js/easy-buy-now-ajax.js', array( 'jquery' ), 0.1, true );
				}
				//引用后台样式与js脚本
				function admin_enqueue_scripts() {
					wp_enqueue_script( 'wpcbn-backend', EBN_URL . 'static/js/backend.js', array( 'jquery' ), WPCBN_VERSION, true );
				}

				//设置buy now按钮
				function buynow_button(){
					global $product;

					printf("<button id='easy-buy-now' type='submit' name='easy-buy-now' value='%s' class='checkout-button button alt'>Buy Now</button>", $product->get_ID());
				}

				//设置购物车处理方法
				function buynow_handle(){
					if ( ! isset( $_REQUEST[ 'easy-buy-now'] ) ) {
						return false;
					}
					
					$product_id   = absint( $_REQUEST[ 'easy-buy-now' ] ?: 0 );
					$quantity     = floatval( isset( $_REQUEST['quantity'] ) ? $_REQUEST['quantity'] : 1 );
					$variation_id = absint( isset( $_REQUEST['variation_id'] ) ? $_REQUEST['variation_id'] : 0 );
					$variation    = [];
					
					foreach ( $_REQUEST as $name => $value ) {
						if ( substr( $name, 0, 10 ) === 'attribute_' ) {
							$variation[ $name ] = $value;
						}
					}
					
					if ( $product_id ) {
						//if ( self::get_setting( 'reset_cart', 'no' ) === 'yes' ) {
							//WC()->cart->empty_cart();
						//}
						
						WC()->cart->empty_cart();
						
						if ( $variation_id ) {
							//if ( self::get_setting( 'reset_cart', 'no' ) === 'yes' ) {
								//WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation );
							//}
							WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation );
						} else {
							WC()->cart->add_to_cart( $product_id, $quantity );
						}
						
						//switch ( apply_filters( 'wpcbn_redirect', self::get_setting( 'redirect', 'checkout' ) ) ) {
							//case 'checkout':
								//$redirect = wc_get_checkout_url();
								//break;
							//case 'cart':
								//$redirect = wc_get_cart_url();
								//break;
							//default:
								//$redirect = self::get_setting( 'redirect_custom', '/' );
						//}
						$redirect = wc_get_checkout_url();
						$redirect = esc_url( apply_filters( 'wpcbn_redirect_url', $redirect ) );
						
						if ( empty( $redirect ) ) {
							$redirect = '/';
						}
						
						wp_safe_redirect( $redirect );
						exit;
					}
				}
			}

			return EBNbuyNowBtn::instance();
		}
	}
}

if ( ! function_exists( 'ebnbtn_notice_wc' ) ) {
	function ebnbtn_notice_wc() {
		?>
		<div class="error">
			<p><strong>Easy Buy Now Button</strong> requires WooCommerce version 3.0 or greater.</p>
		</div>
		<?php
	}
}