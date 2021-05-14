<?php
/**
 * Easy Author Box Widget
 *
 * @author            Shaun Hamman
 * @copyright         Copyright (c) 2021, Shaun Hamman
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Author Box Widget
 * Plugin URI:        https://github.com/Drakmyth/wp-easy-author-box-widget
 * Description:       Adds a widget to display a simple configurable author box with social icons.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shaun Hamman
 * Author URI:        https://drakmyth.com
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       easy-author-box-widget
 * Domain Path:       /languages
 */

/**
 * Prevent plugin from being accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) exit;

require_once( 'widget-class.php' );
require_once( 'user-profile.php' );

/**
 * Activation hook
 */
function eabw_on_activation() {

}
register_activation_hook( __FILE__, 'eabw_on_activation');

/**
 * Deactivation hook
 */
function eabw_on_deactivation() {

}
register_deactivation_hook( __FILE__, 'eabw_on_deactivation');

/**
 * Uninstall hook
 */
function eabw_on_uninstall() {

}
register_uninstall_hook( __FILE__, 'eabw_on_uninstall');

function eabw_on_widgets_init() {
    register_widget( 'EABW_Widget' );
}
add_action( 'widgets_init', 'eabw_on_widgets_init' );

function eabw_on_enqueue_scripts() {
    wp_enqueue_script( 'eabw-font-awesome-script', 'https://kit.fontawesome.com/72f61814cc.js');
    wp_enqueue_style( 'eabw-font-awesome-brand-colors', plugins_url('/css/brand-colors.min.css', __FILE__) );

    wp_enqueue_script( 'eabw-admin-user-profile-script', plugins_url('/js/user-profile.js', __FILE__) );
    wp_enqueue_style( 'eabw-admin-user-profile-style', plugins_url('/css/user-profile.css', __FILE__) );
}
add_action( 'wp_enqueue_scripts', 'eabw_on_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'eabw_on_enqueue_scripts' );
?>