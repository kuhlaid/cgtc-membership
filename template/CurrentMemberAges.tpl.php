<?php
/**
 * Jan. 31, 2026 - wpg
 * - creating basic list of current member ages based on a selected day
 */

	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strCGTC_CurrentMemberAges___;
	define('__SEL_MENU__',$strPageTitle);
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>
	<?php print $_glblWrapper;  // NOTE: this flex bootstrap tag MUST BE inside the Qcodo form and not outside of it?> 
<div class="p-2 col-md-12">
<?php // build the page title and critical links ?>
	<div class="d-flex justify-content-between">
        <div class="h1 p-1"><?=$strPageTitle;?></div>
        <div class="p-1"><?php $this->calStartDate->RenderNoBreaks(); ?></div>
		<div class="p-1"><?php $this->btnExport->RenderNoBreaks(); ?></div>
    </div>
		<div class="p-1">This page allows you to download a list of members and their age on a specified event date. This is useful for event directors. Type the date in the event field and then use the Export CSV button to download a data to a file.</div>
		<?php $this->dtgMemberContact->Render() ?>
		</div>
	<?php $this->RenderEnd() ?>

<?php require(__INCLUDES__ . '/footer.inc.php'); ?>