<?php
// wpg - adding Qcodo framework to prevent a cross site scripting exploit by executing a request like
// https://localhost/jocooa.unc.edu/t3/assets/php/_core/calendar.php?strFormId=<script>alert(document.domain)</script>
// changed all $_GET requests to use Qcodo framework
require('../../../includes/prepend.inc.php');
$strHtml = _xssCheck($_POST["strHtml"]);
print($strHtml);
?>