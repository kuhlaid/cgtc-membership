<?php
	// if the control has a URL set for it then print a link and the file icon
	if ($strUrl = $_CONTROL->GetWebUrl()) print('<a href="' . $strUrl . '" target="_blank">');
	$_CONTROL->imgFileIcon->Render();
	if ($strUrl) print ('</a>');
	print('<br/>');

	// wpg - if there is a file specified for the control then show the delete button
	// else we show the upload button
	if ($_CONTROL->File && $_CONTROL->Enabled)
		$_CONTROL->btnDelete->Render();
	elseif ($_CONTROL->Enabled)
		$_CONTROL->btnUpload->Render();

	// if the control is enabled then render the file asset dialog
	if ($_CONTROL->Enabled) $_CONTROL->dlgFileAsset->Render();
?>