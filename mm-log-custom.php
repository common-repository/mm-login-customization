<?php
/*
Plugin Name: MM Login Customization
Piugin URI: https://www.matrixnmedia.com
Description: To hide admin login url by this plugin auto generated URL and make secure your site and it's data. You may frequenty change the URL for your site's safety. Because URL is auto generated it will be unable to predict and missuse.
Version: 1.4
Author: Matrix Media
Author URI: https://www.matrixnmedia.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
*/ 

define( 'MMLC_VERSION', '1.4' );
define( 'MMLC_BASE', plugin_basename( __FILE__ ) );
define( 'MMLC_DIR', plugin_dir_path( __FILE__ ) );
define( 'MMLC_URL', plugin_dir_url( __FILE__ ) );
define( 'MMLC_AST', plugin_dir_url( __FILE__ ).'assets/' );
define( 'MMLC_IMG_FRONT', plugin_dir_url( __FILE__ ).'assets/images/front' );
define( 'MMLC_CSS_FRONT', plugin_dir_url( __FILE__ ).'assets/css/front' );
define( 'MMLC_JS_FRONT', plugin_dir_url( __FILE__ ).'assets/js/front' );
define( 'MMLC_IMG_BACK', plugin_dir_url( __FILE__ ).'assets/images/back' );
define( 'MMLC_CSS_BACK', plugin_dir_url( __FILE__ ).'assets/css/back' );
define( 'MMLC_JS_BACK', plugin_dir_url( __FILE__ ).'assets/js/back' );
define( 'MMLC_INC_FRONT', plugin_dir_path( __FILE__ ).'template/front' );
define( 'MMLC_INC_BACK', plugin_dir_path( __FILE__ ).'template/back' );

require 'init/mmlc-setup.php';
require 'init/admin/mmlc-admin-settings.php';
require 'init/admin/mmlc-admin-settings-setup.php';
require 'init/admin/mmlc-admin-settings-template.php';
require 'init/admin/mmlc-admin-help.php';

register_activation_hook(__FILE__, 'initLoginCustomActive');
register_deactivation_hook(__FILE__, 'initLoginCustomDective');	