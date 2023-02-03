<div class="ebn_settings_page wrap">
	<h1 class="ebn_settings_page_title">Easy Buy Now</h1>
	<div class="ebn_settings_page_desc about-text">
		<p>Thank you for using our plugin! If you are satisfied</p>
	</div>
	<!--	-->
	<?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) { ?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'Settings updated.', 'wpc-buy-now-button' ); ?></p>
		</div>
	<?php } ?>
	<div class="ebn_settings_page_content">
		<form method="post" action="options.php">
			<table class="form-table">
				<tr class="heading">
					<th>General</th>
					<td>General settings.</td>
				</tr>
				<tr>
					<th scope="row">Button text</th>
					<td>
						<input type="text" name="ebn_settings[button_text]" value="" placeholder="Buy now"/>
						<span class="description">Leave blank to use the default text or its equivalent translation in multiple languages.</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Button position on archive</th>
					<td>
						<?php $position_archive = apply_filters( 'ebn_button_position_archive', 'default' ); ?>
						<select name="ebn_settings[button_position_archive]">
							<option value="before_add_to_cart">Before add to cart button</option>
							<option value="after_add_to_cart">After add to cart button</option>
							<option value="0">None (hide it)</option>
						</select>
						<span class="description">You also can use the shortcode<code>[ebn_btn_archive]</code></span>
					</td>
				</tr>
				<tr>
					<th scope="row">Button position on single</th>
					<td>
						<select name="ebn_settings[button_position_single]">
							<option value="before_add_to_cart">Before add to cart button</option>
							<option value="after_add_to_cart">After add to cart button</option>
							<option value="0">None (hide it)</option>
						</select>
						<span class="description">You also can use the shortcode<code>[ebn_btn_single]</code></span>
					</td>
				</tr>
				<tr>
					<th>Parameter</th>
					<td>
						<input type="text" name="ebn_settings[parameter]" placeholder="buy-now" value=""/>
						<span class="description">Parameter for the buy now button or link. Default <code>buy-now</code>'</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Reset cart</th>
					<td>
						<select name="ebn_settings[reset_cart]">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
						<span class="description">Reset the cart before doing buy now</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Redirect to</th>
					<td>
						<select name="ebn_settings[redirect]" class="ebn_redirect">
							<option value="checkout">Checkout page</option>
							<option value="cart">Cart page</option>
							<option value="custom">Custom page</option>
						</select>
						<input name="ebn_settings[redirect_custom]" type="url" class="regular-text ebn_redirect_custom" value=""/>
					</td>
				</tr>
				<tr class="submit">
					<th colspan="2">
						<?php settings_fields( 'ebn_settings' ); ?>
						<?php submit_button(); ?>
					</th>
				</tr>
			</table>
		</form>
	</div>
</div>