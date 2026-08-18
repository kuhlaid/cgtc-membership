<?php
/**
 * @abstract Template for sending email updates online.
 */
// kick user away from script if they are not going through the proper channels
if (!defined('__PREPEND_INCLUDED__')) exit;

	define('__SEL_BDYCOL__', 1);
	define('__HIDE_MENU__', true);
	require(__INCLUDES__ . '/header.inc.php');

$this->RenderBegin();
$this->strReport->RenderNoBreaks();
$this->RenderEnd();
require(__INCLUDES__ .'/footer.inc.php');
?>