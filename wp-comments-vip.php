<?php
/*

**************************************************************************

Plugin Name:  WP Comments VIP
Plugin URI:   http://www.arefly.com/wordpress-comment-vip/
Description:  Add VIP Comments Rank into your blog's comments.
Version:      1.2
Author:       Arefly
Author URI:   http://www.arefly.com/
Text Domain:  wp-comments-vip
Domain Path:  /lang/

**************************************************************************

	Copyright 2014  Arefly  (email : eflyjason@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

**************************************************************************/

define("WP_COMMENTS_VIP_PLUGIN_URL", plugin_dir_url( __FILE__ ));
define("WP_COMMENTS_VIP_FULL_DIR", plugin_dir_path( __FILE__ ));
define("WP_COMMENTS_VIP_TEXT_DOMAIN", "wp-comments-vip");

/* Plugin Localize */
function wp_comments_vip_load_plugin_textdomain() {
	load_plugin_textdomain(WP_COMMENTS_VIP_TEXT_DOMAIN, false, dirname(plugin_basename( __FILE__ )).'/lang/');
}
add_action('plugins_loaded', 'wp_comments_vip_load_plugin_textdomain');

include_once WP_COMMENTS_VIP_FULL_DIR."options.php";

/* Add Links to Plugins Management Page */
function wp_comments_vip_action_links($links){
	$links[] = '<a href="'.get_admin_url(null, 'options-general.php?page='.WP_COMMENTS_VIP_TEXT_DOMAIN.'-options').'">'.__("Settings", WP_COMMENTS_VIP_TEXT_DOMAIN).'</a>';
	return $links;
}
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'wp_comments_vip_action_links');

/* Add CSS code */
function wp_comments_vip_enqueue_styles(){
	wp_enqueue_style(WP_COMMENTS_VIP_TEXT_DOMAIN, WP_COMMENTS_VIP_PLUGIN_URL.'style.min.css');
}
add_action('wp_enqueue_scripts', 'wp_comments_vip_enqueue_styles');

function wp_comments_vip_get_author_class($comment_author_email, $user_id){
	global $wpdb;
	$author_count = count($wpdb->get_results("SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "));
	if(get_option("wp_comments_vip_display_admin_vip") == "hide"){
		$adminEmail = get_option('admin_email');
		if($comment_author_email == $adminEmail){
			return;
		}
	}
	for($num = 1; $num <= 7; $num++){
		${"level_num_".$num} = get_option("wp_comments_vip_level_num_".$num);
	}
	if($author_count>=$level_num_1 && $author_count<$level_num_2){
		?><a class="vip1" title="VIP 1"></a><?php
	}else if($author_count>=$level_num_2 && $author_count<$level_num_3){
		?><a class="vip2" title="VIP 2"></a><?php
	}else if($author_count>=$level_num_3 && $author_count<$level_num_4){
		?><a class="vip3" title="VIP 3"></a><?php
	}else if($author_count>=$level_num_4 && $author_count<$level_num_5){
		?><a class="vip4" title="VIP 4"></a><?php
	}else if($author_count>=$level_num_5 && $author_count<$level_num_6){
		?><a class="vip5" title="VIP 5"></a><?php
	}else if($author_count>=$level_num_6 && $author_count<$level_num_7){
		?><a class="vip5" title="VIP 5"></a><?php
	}else if($author_count>=$level_num_7){
		?><a class="vip7" title="VIP 7"></a><?php
	}
}

function wp_comments_vip($author_link) {
	$comment = get_comment($comment_id);
	echo $author_link;
	wp_comments_vip_get_author_class($comment->comment_author_email, $comment->user_id);
}
add_filter('get_comment_author_link', 'wp_comments_vip');
