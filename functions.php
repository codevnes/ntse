<?php
/**
 * NTS Energy Theme Functions
 * Child theme của Flatsome
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Định nghĩa các hằng số
define('NTSE_VERSION', '1.0.0');
define('NTSE_DIR', get_stylesheet_directory());
define('NTSE_URI', get_stylesheet_directory_uri());

/**
 * Include các files cần thiết
 */

// Core files
require_once NTSE_DIR . '/includes/setup.php';        // Theme setup & configuration
require_once NTSE_DIR . '/includes/enqueue.php';      // Enqueue scripts & styles  
require_once NTSE_DIR . '/includes/shortcodes.php';   // Shortcodes

// Include all files in includes directory
function include_all_include_files() {
    $include_dir = NTSE_DIR . '/includes/';
    
    if (file_exists($include_dir) && is_dir($include_dir)) {
        $include_files = scandir($include_dir);
        
        foreach ($include_files as $file) {
            if ($file === '.' || $file === '..' || 
                $file === 'setup.php' || 
                $file === 'enqueue.php' || 
                $file === 'shortcodes.php') {
                continue;
            }
            
            $file_path = $include_dir . $file;
            if (is_file($file_path) && pathinfo($file_path, PATHINFO_EXTENSION) === 'php') {
                require_once $file_path;
            }
        }
    }
}
add_action('after_setup_theme', 'include_all_include_files');

// Include all files in UX builder directory
function include_all_ux_files() {
    $ux_dir = NTSE_DIR . '/ux/';
    
    if (file_exists($ux_dir) && is_dir($ux_dir)) {
        $ux_files = scandir($ux_dir);
        
        foreach ($ux_files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            
            $file_path = $ux_dir . $file;
            if (is_file($file_path) && pathinfo($file_path, PATHINFO_EXTENSION) === 'php') {
                require_once $file_path;
            }
        }
    }
}
add_action('after_setup_theme', 'include_all_ux_files');

// Include the partners admin page
require_once NTSE_DIR . '/generate-partners-admin.php';

function my_flatsome_setup() {
	/* Theme setup here */
}
add_action( 'after_setup_theme', 'my_flatsome_setup' );


// Begin NTSe Theme Setup
function ntse_setup() {
	// Include nhóm tùy chỉnh
	include_once get_stylesheet_directory() . '/includes/setup.php';
	include_once get_stylesheet_directory() . '/includes/enqueue.php';
	include_once get_stylesheet_directory() . '/includes/shortcodes.php';
	include_once get_stylesheet_directory() . '/includes/productsPostType.php';
	include_once get_stylesheet_directory() . '/includes/servicesPostType.php';
	include_once get_stylesheet_directory() . '/includes/projectPostType.php';
	include_once get_stylesheet_directory() . '/includes/partners-shortcode.php';
	include_once get_stylesheet_directory() . '/includes/breadcrumb.php';
	include_once get_stylesheet_directory() . '/includes/settings.php';

}
add_action( 'after_setup_theme', 'ntse_setup', 9 );
