<?php
//* code goes here
function custom_login_stylesheet() {
	wp_enqueue_style('custom-login', get_stylesheet_directory_uri() . '/login/login-style.css');
}
add_action('login_enqueue_scripts', 'custom_login_stylesheet');

add_action('wp_enqueue_scripts', 'enqueue_parent_styles');

function enqueue_parent_styles() {
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

function wpb_login_logo_url() {
	return home_url();
}
add_filter('login_headerurl', 'wpb_login_logo_url');

function wpb_login_logo_url_title() {
	return 'Muftijstvo Sandzacko';
}
add_filter('login_headertext', 'wpb_login_logo_url_title');

function remove_logo_wp_admin() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'remove_logo_wp_admin', 0);

function custom_login_title($origtitle) {
	return 'Selamun alejke | ' . get_bloginfo('name');

}
add_filter('login_title', 'custom_login_title', 99);

function custom_admin_title($admin_title, $title) {
	return 'Admin Panel | ' . get_bloginfo('name');
}

add_filter('admin_title', 'custom_admin_title', 10, 2);

// Admin footer modification

function custom_footer_copyright() {
	echo '<span id="footer-thankyou">Developed by Ervin pepic </span>';
}

add_filter('admin_footer_text', 'custom_footer_copyright');

?>
