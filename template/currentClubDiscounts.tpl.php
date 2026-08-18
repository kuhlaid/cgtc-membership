<?php
/**
 * April 14, 2017 - wpg
 * - creating basic list of current member emails
 */

	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;
	$strOption = QApplication::QueryString('option');
	$strPageTitle = __strCGTC_CurrentClubDiscounts___;
	define('__SEL_MENU__',$strPageTitle);
	if ($strOption!='showMenu')
		define('__HIDE_MENU__',1);
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>
	<?php print $_glblWrapper;  // NOTE: this flex bootstrap tag MUST BE inside the Qcodo form and not outside of it?> 
<div class="p-2 col-md-12">
<?php // build the page title and critical links ?>
	<div class="d-flex justify-content-between">
        <div class="h1 p-1"><?=$strPageTitle;?></div>
    </div>
		<?php print nl2br(PartnerBusiness::currentPbWebList());?>
		</div>
	<?php $this->RenderEnd() ?>

<?php require(__INCLUDES__ . '/footer.inc.php'); ?>