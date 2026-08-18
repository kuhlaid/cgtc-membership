<?php
/**
 * @abstract HTML template for member contact edit form
 *
 * Jan. 8, 2018 - wpg
 * - adding membership renewal options
 */

	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strCGTC_MemberContact___;
	define('__SEL_MENU__',$strPageTitle);
	define('__HIDE_MENU__',true);
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>
	<?php print $_glblWrapper;  // NOTE: this flex bootstrap tag MUST BE inside the Qcodo form and not outside of it?> 
<div class="p-2 col-md-12">
<?php // build the page title and critical links ?>
	<div class="d-flex justify-content-between">
        <div class="h1 p-1"><?=$strPageTitle;?></div>
    </div>

		<?php $this->txtFirstName->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtLastName->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtEmail->RenderWithName(); ?>


		<div style='padding:20px;background-color:#f7f7f7;'><h3>Email addresses to use for membership login if different from your email address above (otherwise leave blank)</h3>
		<?php $this->txtGoogleEmail->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtFacebookEmail->RenderWithName(); ?>
		</div><br/>

		<?php $this->txtAddr1->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtAddr2->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtCity->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtState->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtZip->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtGender->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtBirthDay->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtMainPhone->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtAltPhone->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->calJoinedClub->RenderWithName(); ?>
		<br class="item_divider" />

		<br />
		<?php // simple membership renewal type selection
	if ($this->strOption=='contactCheck'){
	?>
		<?php $this->btnCancel->Render(); ?>&nbsp;&nbsp;&nbsp;<?php $this->btnSave->Render(); ?>

	<?php }
	else {?>
		<?php $this->btnSave->Render(); ?>
		&nbsp;&nbsp;&nbsp;
		<?php $this->btnCancel->Render(); ?>

	<?php
	}
	?>
</div>
	<?php $this->RenderEnd(); ?>

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>