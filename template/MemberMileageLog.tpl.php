<?php
	// This is the HTML template include file (.tpl.php) for the member_mileage_edit.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.
	
	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = 'Log Mileage';
	require(__INCLUDES__ . '/header.inc.php');

$this->RenderBegin(); ?>
<?php print $_glblWrapper;  // NOTE: this flex bootstrap tag MUST BE inside the Qcodo form and not outside of it?> 
<div class="p-2 col-md-12">
    <?php // build the page title and critical links ?>
    <div class="d-flex justify-content-between">
        <div class="h1 p-1"><?=$strPageTitle;?></div>
		
    </div>

		<?php $this->txtMiles->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->calLoggedOn->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtYear->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtNotes->RenderWithName(); ?>
		<br class="item_divider" />

		<?php // if a member has family members they can log mileage for them ?>
		<?php $this->lstMember->RenderWithName(); ?>

		<br />
		<?php $this->btnSave->Render(); ?>
		&nbsp;&nbsp;&nbsp;
		<?php $this->btnCancel->Render(); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php $this->btnDelete->Render(); ?>
</div>
	<?php $this->RenderEnd(); ?>	

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>