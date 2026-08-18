<?php
/**
 * @abstract Simple form for showing current club discounts
 * @author w. Patrick Gale
 *
 * Jly 16, 2017 - wpg
 * - adding basic view
 */
	// Include prepend.inc to load Qcodo
	require('includes/prepend.inc.php');

	class currentClubDiscounts extends QForm {}

	currentClubDiscounts::Run('currentClubDiscounts', 'template/currentClubDiscounts.tpl.php');
?>