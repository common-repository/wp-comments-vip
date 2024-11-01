<?php
function wp_comments_vip_register_settings() {
	add_option('wp_comments_vip_level_num_1', '10');
	add_option('wp_comments_vip_level_num_2', '20');
	add_option('wp_comments_vip_level_num_3', '40');
	add_option('wp_comments_vip_level_num_4', '80');
	add_option('wp_comments_vip_level_num_5', '160');
	add_option('wp_comments_vip_level_num_6', '320');
	add_option('wp_comments_vip_level_num_7', '640');
	add_option('wp_comments_vip_display_admin_vip', 'display');
	register_setting('wp_comments_vip_options', 'wp_comments_vip_level_num_1');
	register_setting('wp_comments_vip_options', 'wp_comments_vip_level_num_2');
	register_setting('wp_comments_vip_options', 'wp_comments_vip_level_num_3');
	register_setting('wp_comments_vip_options', 'wp_comments_vip_level_num_4');
	register_setting('wp_comments_vip_options', 'wp_comments_vip_level_num_5');
	register_setting('wp_comments_vip_options', 'wp_comments_vip_level_num_6');
	register_setting('wp_comments_vip_options', 'wp_comments_vip_level_num_7');
	register_setting('wp_comments_vip_options', 'wp_comments_vip_display_admin_vip');
}
add_action('admin_init', 'wp_comments_vip_register_settings');

function wp_comments_vip_register_options_page() {
	add_options_page(__('WP Comments Vip Options Page', WP_COMMENTS_VIP_TEXT_DOMAIN), __('WP Comments Vip', WP_COMMENTS_VIP_TEXT_DOMAIN), 'manage_options', WP_COMMENTS_VIP_TEXT_DOMAIN.'-options', 'wp_comments_vip_options_page');
}
add_action('admin_menu', 'wp_comments_vip_register_options_page');

function wp_comments_vip_get_select_option($select_option_name, $select_option_value, $select_option_id){
	?>
	<select name="<?php echo $select_option_name; ?>" id="<?php echo $select_option_name; ?>">
		<?php
		for($num = 0; $num < count($select_option_id); $num++){
			$select_option_value_each = $select_option_value[$num];
			$select_option_id_each = $select_option_id[$num];
			?>
			<option value="<?php echo $select_option_id_each; ?>"<?php if (get_option($select_option_name) == $select_option_id_each){?> selected="selected"<?php } ?>>
				<?php echo $select_option_value_each; ?>
			</option>
		<?php } ?>
	</select>
	<?php
}

function wp_comments_vip_get_vip_level_text_option($text_name, $time){
	for($num = 1; $num <= $time; $num++){
		$name = $text_name.'_'.$num;
		?>
		<td><input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" pattern="\d*" title="<?php _e('Number Only', WP_COMMENTS_VIP_TEXT_DOMAIN); ?>" size="3" value="<?php echo get_option($name); ?>" /></td>
	<?php
	}
}

function wp_comments_vip_options_page() {
?>
<style>
#wp_comments_vip_level_num td{
	text-align: center;
}
</style>
<div class="wrap">
	<h2><?php _e("WP Comments Vip Options Page", WP_COMMENTS_VIP_TEXT_DOMAIN); ?></h2>
	<form method="post" action="options.php">
		<?php settings_fields('wp_comments_vip_options'); ?>
		<h3><?php _e("General Options", WP_COMMENTS_VIP_TEXT_DOMAIN); ?></h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="wp_comments_vip_level_num"><?php _e("Each VIP Level's Comments Numbers: ", WP_COMMENTS_VIP_TEXT_DOMAIN); ?></label></th>
					<td>
						<table id="wp_comments_vip_level_num">
							<tr>
								<td><?php _e("VIP Level", WP_COMMENTS_VIP_TEXT_DOMAIN); ?></td>
								<?php for($vip_level_num = 1; $vip_level_num <= 7; $vip_level_num++){ ?>
									<td>VIP <?php echo $vip_level_num; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td><?php _e("From", WP_COMMENTS_VIP_TEXT_DOMAIN); ?></td>
								<?php wp_comments_vip_get_vip_level_text_option("wp_comments_vip_level_num", 7); ?>
							</tr>
						</table>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="wp_comments_vip_display_admin_vip"><?php _e("Display Admin in VIP Level?", WP_COMMENTS_VIP_TEXT_DOMAIN); ?></label></th>
					<td>
						<?php wp_comments_vip_get_select_option("wp_comments_vip_display_admin_vip", array(__('Display', WP_COMMENTS_VIP_TEXT_DOMAIN), __('Hide', WP_COMMENTS_VIP_TEXT_DOMAIN)), array('display', 'hide')); ?>
					</td>
				</tr>
			</table>
		<?php submit_button(); ?>
	</form>
</div>
<?php
}
?>