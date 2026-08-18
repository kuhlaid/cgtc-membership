<?php
/**
 * June 13, 2017 - wpg
 * - changing the wording on the form to be generic for members and non-members
 */
	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strClub_MemberLogin___;
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin(); ?>

		<br class="item_divider" />

		<div>Enter your last name and email address (saved under your club membership) then click the 'Continue' button and an email will be sent to you with a link to access your membership information online.</div>
<br/>
		<?php $this->txtLastName->RenderWithName(); ?>
		<br class="item_divider" />

		<?php $this->txtEmail->RenderWithName(); ?>
		<br class="item_divider" />

		<br />
		<?php $this->btnSave->Render(); ?>

	<?php $this->RenderEnd(); ?>

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>