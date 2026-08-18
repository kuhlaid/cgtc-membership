<?php
// wpg - adding Qcodo framework to prevent a cross site scripting exploit by executing a request like
// /t3/assets/php/_core/calendar.php?strFormId=<script>alert(document.domain)</script>
// changed all $_GET requests to use Qcodo framework
require('../../../includes/prepend.inc.php');
if (array_key_exists("strHtml", $_POST)) {
	$strHtml = _xssCheck($_POST["strHtml"]);
	print($strHtml);
}
?>