<?php
/**
 * @abstract Memership log HTML template for member access only.
 *
 * Jan. 8, 2018 - wpg
 * - adding membership renewal options
 */
	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strClub_Membership___;
	define('__SEL_MENU__',$strPageTitle);
	define('__HIDE_MENU__',true);
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin();?>
	<?php print $_glblWrapper;  // NOTE: this flex bootstrap tag MUST BE inside the Qcodo form and not outside of it?> 
<div class="p-2 col-md-12">

	<?php
	// simple membership renewal type selection
	if ($this->strOption=='renewalType'){
	?>
		<?php $this->txtLogType->RenderWithName(); ?>

		<h3>NOTE: You do not need a PayPal account to make a credit card payment. There is <i>no service charge to pay online</i>.</h3>
		<?php $this->txtPaymentType->RenderWithName(); ?>

		<h3>Medical Personnel</h3>
		<div>As a safety precaution, we like to know if a club member might be willing to help if medical assistance is needed at one of our events.  Some of our races/events require that we have licensed medical personnel present during the event.</div>
		<br class="item_divider" />
		<?php $this->txtMedTrainingType->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->chkWillingMedVolunteer->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->btnCancel->Render(); ?>&nbsp;&nbsp;&nbsp;<?php $this->btnSave->Render(); ?>

	<?php }
	else {?>
<?php // build the page title and critical links ?>
	<div class="d-flex justify-content-between">
        <div class="h1 p-1"><?=$strPageTitle;?></div>
    </div>

		<?php $this->lstMemberIdObject->RenderWithName(); ?>
		<br/><hr class="item_divider" />

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
</div>
	<?php
	}
	$this->RenderEnd(); ?>

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>