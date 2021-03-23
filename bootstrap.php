<?php
define("jk",true);

error_reporting( E_ALL );
if ( ! defined( 'DS' ) ) {
    define( 'DS', DIRECTORY_SEPARATOR );
}
if ( ! defined( 'JK_SITE_PATH' ) ) {
    define( 'JK_SITE_PATH', __DIR__ . DS );
}



require_once JK_SITE_PATH.'jk_config.php';
if ( ! defined( 'JK_DIR_INCLUDES' ) ) {
    define( 'JK_DIR_INCLUDES', JK_SITE_PATH .'includes'.DS);
}
if ( ! defined( 'JK_DIR_MODULES' ) ) {
    define( 'JK_DIR_MODULES', JK_SITE_PATH .'modules'.DS);
}
if ( ! defined( 'JK_DIR_THEMES' ) ) {
    define( 'JK_DIR_THEMES', JK_SITE_PATH .'themes'.DS);
}
define( 'JK_URI_THEMES', 'themes'.DS);


require_once JK_DIR_INCLUDES.'PackageLoader.php';
$loader = new PackageLoader\PackageLoader();
$loader->load(JK_DIR_INCLUDES."vendor");

require_once JK_DIR_INCLUDES.'Helpers.php';
require_once JK_DIR_INCLUDES.'Idate.php';
require_once JK_DIR_INCLUDES.'Errors.php';
require_once JK_DIR_INCLUDES.'Route.php';
require_once JK_DIR_INCLUDES.'Modules.php';
require_once JK_DIR_INCLUDES.'View.php';
require_once JK_DIR_INCLUDES.'Languages.php';
require_once JK_DIR_INCLUDES.'Forms.php';
require_once JK_DIR_INCLUDES.'Upload.php';
require_once JK_DIR_INCLUDES.'ACL.php';
require_once JK_DIR_INCLUDES.'Aparat.php';
require_once JK_DIR_INCLUDES.'Theme.php';
set_error_handler('Joonika\Errors::errorHandler');
set_exception_handler('Joonika\Errors::exceptionHandler');



require_once JK_DIR_INCLUDES.'Database.php';

$database=\Joonika\Database::connect();






