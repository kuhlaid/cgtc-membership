<?php
/**
 * April 14, 2017 - wpg
 * - creating basic list of membership birthdays coming up and anniversaries (need to pull 'joined' data from old spreadsheet) and new members
 */

	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strClub_MembershipCorner___;
	define('__SEL_MENU__',$strPageTitle);
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>
	<?php print $_glblWrapper;  // NOTE: this flex bootstrap tag MUST BE inside the Qcodo form and not outside of it?> 
<div class="p-2 col-md-12">
<?php // build the page title and critical links ?>
	<div class="d-flex justify-content-between">
        <div class="h1 p-1"><?=$strPageTitle;?></div>
		<div class="p-1">for <?php $this->lstMonth->RenderNoBreaks(); ?> <?php $this->lstYear->RenderNoBreaks(); ?></div>
    </div>
		

		<?php $this->dtg1NewMembers->RenderWithName(); ?><br/>
		<?php $this->dtg2MemberAnniversaries->RenderWithName(); ?><br/>
		<?php $this->dtg3MemberBirthdays->RenderWithName(); ?>
<hr/>
<?php $this->txtCopy->RenderWithName(); ?>
</div>
	<?php $this->RenderEnd() ?>

<?php require(__INCLUDES__ . '/footer.inc.php'); ?>