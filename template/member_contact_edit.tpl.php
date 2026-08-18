<?php
/**
 * @abstract HTML template for the membership contact form.
 * @author w. Patrick Gale
 *
 * Jan. 12, 2018 - wpg
 * - copying the extra email fields from the member contact form
 */

	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strClub_MemberContact___;
	define('__SEL_MENU__',$strPageTitle);
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>
		<div class="title"><?=$strPageTitle; ?></div>
		<br class="item_divider" />

		<?php $this->txtFirstName->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtLastName->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtEmail->RenderWithName(); ?>
		<br class="item_divider" />

		<div style='padding:20px;background-color:#f7f7f7;'><h3>Email addresses to use for membership login ONLY if different from your email address above (otherwise leave blank)</h3>
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

		<?php $this->txtBirthMonth->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtBirthYear->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtMainPhone->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtAltPhone->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtNote->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->calJoinedClub->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->lstPartnerBusiness->RenderWithName(); // added May 9, 2017 - wpg?>
		<br class="item_divider" />

		<?php $this->chkNotActive->RenderWithName(); // added June 4, 2017 - wpg?>
		<br class="item_divider" />
		<br />
		<?php $this->btnSave->Render(); ?>
		&nbsp;&nbsp;&nbsp;
		<?php $this->btnCancel->Render(); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php //$this->btnDelete->Render(); ?>

	<?php $this->RenderEnd(); ?>

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>