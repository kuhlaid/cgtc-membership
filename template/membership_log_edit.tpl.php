<?php
/**
 * @abstract Memership log HTML template.
 *
 * March 18, 2017 - wpg
 * - creating basic form for adding membership logs
 */
	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strClub_Membership___;
	define('__SEL_MENU__',$strPageTitle);
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>
	<?php print $_glblWrapper;  // NOTE: this flex bootstrap tag MUST BE inside the Qcodo form and not outside of it?> 
<div class="p-2 col-md-12">
<?php // build the page title and critical links ?>
	<div class="d-flex justify-content-between">
        <div class="h1 p-1"><?=$strPageTitle;?></div>
    </div>

	<div class="p-1 card">
		<div class=" card-header">Member Contact</div>
		<div class=" card-body"><?php $this->lstMemberIdObject->RenderNoBreaks(); ?></div>
	</div><br />

		<?php $this->calPaidOn->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtPaymentType->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtPayPalTransactionId->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtLogType->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->calStartDate->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->calExpireDate->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtNote->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->chkNewMembership->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtMedTrainingType->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->chkWillingMedVolunteer->RenderWithName(); ?>
		<br class="item_divider" />

		<br />
		<?php $this->btnSave->Render(); ?>
		&nbsp;&nbsp;&nbsp;
		<?php $this->btnCancel->Render(); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php $this->btnDelete->Render(); ?>
</div>
	<?php $this->RenderEnd(); ?>

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>