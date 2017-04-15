<?php

/*
 * root path
 */
define('ROOT_PATH', realpath(dirname(__FILE__)));

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', ROOT_PATH . '/application');

// Define application environment development production development
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] =='on') ? 'https' : 'http';
define('BASE_URL', "$protocol://" . $_SERVER['SERVER_NAME']);
define('STATIC_URL', BASE_URL . '/public');

//------------KHAI BAO DUONG DAN THUC DEN CAC THU MUC --------------
//Duong dan den thu muc /public
define('PUBLIC_PATH', realpath(dirname(__FILE__) . '/public'));
define('TEMP_PATH', PUBLIC_PATH . '/tmp');
define('FILES_PATH', PUBLIC_PATH . '/files');
define('SCRIPTS_PATH',PUBLIC_PATH . '/scripts');
define('CAPTCHA_PATH',PUBLIC_PATH . '/captcha');
define('UPLOAD_PATH',PUBLIC_PATH . '/uploads');
define('BLOCK_PATH',APPLICATION_PATH . '/blocks');
define('BLOCK_DEFAULT_PATH',APPLICATION_PATH . '/modules/default/blocks');
define('BLOCK_ADMIN_PATH',APPLICATION_PATH . '/modules/admin/blocks');

//Duong dan den thu muc /templates
define('TEMPLATE_PATH', PUBLIC_PATH . '/templates');

//------------KHAI BAO DUONG DAN URL DEN CAC THU MUC --------------

//Duong dan den thu muc ung
define('APPLICATION_URL',''); 
define('SRCIPTS_URL', APPLICATION_URL . '/public/scripts');
//Duong dan den thu muc /templates
define('TEMPLATE_URL', '/public/templates');
define('TEMPLATE_DEFAULT_URL', '/public/templates/public');
define('TEMPLATE_ADMIN_URL', '/public/templates/admin');
define('CAPTCHA_URL', APPLICATION_URL . '/public/captcha');

define('FILES_URL', APPLICATION_URL . '/public/files');
define('UPLOAD_URL', APPLICATION_URL . '/public/uploads');

// Ensure library/ is on include_path
//set_include_path(ROOT_PATH . "/library");
set_include_path(implode(PATH_SEPARATOR, array( realpath(APPLICATION_PATH."/../library"),
get_include_path())));

/**
 * load file constants
 */
require_once APPLICATION_PATH . '/configs/constants.php';

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();
