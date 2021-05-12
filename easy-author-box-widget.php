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
?>