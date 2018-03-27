<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
Plugin Name:  Compartir WP
Description:  Plugin to share new content through social networks automatically.
Version:      1.0.0
Author:       Oscar254
Author URI:   https://forobeta.com/member.php?u=110585
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  compartir-wp
*/

define( 'COMPARTIR_WP__VERSION', '1.0.0' );
define( 'COMPARTIR_WP__NAME', 'Compartir WP' );
define( 'COMPARTIR_WP__TEXT_DOMAIN', 'compartir-wp' );
define( 'COMPARTIR_WP__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'COMPARTIR_WP__PLUGIN_FILE', __FILE__ );
define( 'COMPARTIR_WP__OPTIONS', 'compartir_wp__options' );

// Adding share helpers
require_once( COMPARTIR_WP__PLUGIN_DIR . 'inc/share.php' );

// Adding utils helpers
require_once( COMPARTIR_WP__PLUGIN_DIR . 'inc/utils.php' );