<?php
// Configuration constants for the app.

require($_ENV['TEXT_TEMPLATES']); 

define('__APPLICATION_TITLE__', '');
define('__VERSION_Num__',$_ENV['VERSION_Num']);
define ('__APP_DOMAIN__', $_ENV['APP_HTTP_ROOT']);
define ('__SESSION_PREFIX__', $_ENV['SESSION_PREFIX']);

define('MYSQL_CLIENT_SSL',$_ENV['MYSQL_CLIENT_SSL']);	// this is the mysqli.default_socket
// PayPal configuration variables (in testing mode)
define('__PAYPAL_CLIENT_ID__', $_ENV['PAYPAL_CLIENT_ID']);
define('__PAYPAL_CLIENT_SECRET__',$_ENV['PAYPAL_CLIENT_SECRET']);
define('__PAYPAL_AUTH_URL__', $_ENV['PAYPAL_AUTH_URL']);
define('__PAYPAL_WEBHOOK_NOTIFICATION_URL__',$_ENV['PAYPAL_WEBHOOK_NOTIFICATION_URL']);
define('__PAYPAL_WEBHOOK_SDK_DIR__', $_ENV['PAYPAL_WEBHOOK_SDK_DIR']);

// Google authentication
define('__GOOGLELOGIN_ClientId__',$_ENV['GOOGLELOGIN_ClientId']);
define('__GOOGLELOGIN_ClientSecret__',$_ENV['GOOGLELOGIN_ClientSecret']);
define('__GOOGLELOGIN_RedirectUri__',$_ENV['GOOGLELOGIN_RedirectUri']);

// used as 'salt' for email login link
define ('__EMAIL_KEY__', $_ENV['EMAIL_KEY']);
define ('__EMAIL_IV__', $_ENV['EMAIL_IV']);

// other application constants (NOTE: we MUST specify the server as an IP address so the connection will go over TCP/IP instead of sockets if we used localhost otherwise we get crappy errors)
define ('__DOCROOT__', $_ENV['DOCROOT']);
define('DB_CONNECTION_1', serialize(array(
'adapter' => $_ENV['DB_ADAPTOR'],
'server'   => $_ENV['DB_HOST'],
'port'     => $_ENV['DB_PORT'],
'database' => $_ENV['DB_NAME'],
'username' => $_ENV['DB_USER'],
'password' => $_ENV['DB_PASS'],
'profiling' => false)));

define('ALLOW_REMOTE_ADMIN', true);
define ('__VIRTUAL_DIRECTORY__', '');
define ('__SUBDIRECTORY__', $_ENV['APP_HTTP_SUBDIRECTORY']);
define ('__URL_REWRITE__', 'none');
define ('__INCLUDES__', __DOCROOT__ .  __SUBDIRECTORY__ . '/includes');
define ('__RESOURCES__', __SUBDIRECTORY__ . '/resources');
define ('__QCODO__', __DOCROOT__ .  __SUBDIRECTORY__ .'/_core_qcodo');
define ('__QCOREBASE__', __QCODO__);
define ('__ZENDGDATA_LIB__', __QCODO__.'/ZendGdata-1.11.2/library');
define ('__APPLICATION_ROOT__',__QCODO__);	// needed for fck editor class code
define ('__FCK_BASEPATH__',__SUBDIRECTORY__.'/_core_qcodo/fckeditor/');
define ('__QCODO_URL__', __SUBDIRECTORY__ .'/_core_qcodo');
define ('__QCODO_CORE__', __DOCROOT__ .  __SUBDIRECTORY__ .'/_core_qcodo/_core');
define ('__DEVTOOLS_CLI__', __DOCROOT__ .  __SUBDIRECTORY__ . '/_devtools_cli');
define ('__DEVTOOLS__', __DOCROOT__ .  __SUBDIRECTORY__ . '/_devtools');
define ('__DATA_CLASSES__', __INCLUDES__ . '/data_classes');
define ('__DATAGEN_CLASSES__', __INCLUDES__ . '/data_classes/generated');
define ('__FORMBASE_CLASSES__', __INCLUDES__ . '/formbase_classes_generated');
define ('__FORM_DRAFTS__', __SUBDIRECTORY__.'/form_drafts');
define ('__PANELBASE_CLASSES__', __INCLUDES__ . '/ajaxbase_classes_generated');
define ('__PANEL_DRAFTS__', __SUBDIRECTORY__.'/ajax_drafts');
define ('__ADMIN_FORM_DIR__', '/admin');

define ('__EXAMPLES__', null);

define ('__JS_ASSETS__', __QCODO_URL__ . '/assets/js');
define ('__JAVASCRIPT_ASSETS__', __SUBDIRECTORY__ . '/assets/js');
define ('__CSS_ASSETS__', __SUBDIRECTORY__ . '/assets/css');
define ('__QCSS_ASSETS__', __QCODO_URL__ . '/assets/css');
define ('__IMAGE_ASSETS__', __SUBDIRECTORY__ . '/assets/images');
define ('__PHP_ASSETS__', __SUBDIRECTORY__ . '/assets/php');
define ('__PHP_ASSETS_PATH__', __QCODO_URL__ . '/assets/php');
define ('__CAL_ASSETS__', __SUBDIRECTORY__ . '/assets/calendar');

function _editIcon($title=''){
	return '<img src="'.__IMAGE_ASSETS__.'/edit_f2.png" border="0" width="20px" title="'.$title.'">';
}

define ('__ADD_ICON__', '<img src="'.__IMAGE_ASSETS__.'/add.png" border="0" width="20px">');
define ('__CHECK_ICON__', '<img src="'.__IMAGE_ASSETS__.'/tick.png" border="0" alt="true">');
define ('__DOWNLOAD_ICON__', '<img src="'.__IMAGE_ASSETS__.'/file_f2.png" border="0" alt="download" height="15px" title="download">');
define ('__PERSON_ICON__', '<img src="'.__IMAGE_ASSETS__.'/person.png" border="0" alt="profile icon" height="15px" title="profile icon">');

if ((function_exists('date_default_timezone_set')) && (!ini_get('date.timezone')))
	date_default_timezone_set($_ENV['TIMEZONE']);

define('ERROR_PAGE_PATH', __DOCROOT__.__PHP_ASSETS_PATH__ . '/_core/error_page.php');

define('__APP_URL__',__APP_DOMAIN__.__SUBDIRECTORY__)
define ('__CLUB_LOGO_300px__', "<img src='".__APP_DOMAIN__.__IMAGE_ASSETS__."/CgtcLogo300px.png' alt='CGTC Logo' title='CGTC Logo' class='m-2'/>");
// wpg force the visitor onto SSL at all times
if (empty($_SERVER['HTTPS'])) {
	header('Location: '.__APP_URL__);
	exit;
}
define ('__EMAIL_FROM__', $_ENV['EMAIL_MEMBERSHIP']);
?>