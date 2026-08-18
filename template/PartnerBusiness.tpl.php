<?php
	// This is the HTML template include file (.tpl.php) for the partner_business_edit.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent
	// code re-generations do not overwrite your changes.

	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strClub_PartnerBusinesses___;
	define('__SEL_MENU__',$strPageTitle);
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>
		<div class="title"><?=$strPageTitle; ?></div>
		<br class="item_divider" />

		<?php $this->txtName->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtPhone->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtAddress->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtHours->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtWebsite->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtDiscount->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->chkActive->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->calVerifiedDiscountDate->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtUpdateResponse->RenderWithName(); ?>
		<br class="item_divider" />


		<br />
		<?php $this->btnSave->Render(); ?>
		&nbsp;&nbsp;&nbsp;
		<?php $this->btnCancel->Render(); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php $this->btnDelete->Render(); ?>

	<?php $this->RenderEnd(); ?>

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>