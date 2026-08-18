<?php
	// This is the HTML template include file (.tpl.php) for the member_tag_assoc_list.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent
	// code re-generations do not overwrite your changes.

	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = "Participating Members";
	define('__SEL_MENU__',$strPageTitle);
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>
		<div class="bld"><a href='Tags.php'>Member Participation</a> > "<?=$this->objTag->Name;?>" <?=$strPageTitle; ?></div>
		<br class="item_divider" />

		<?php $this->btnTagging->RenderNoBreaks()?>
		<?php $this->dtgMemberTagAssoc->Render() ?>

	<?php $this->RenderEnd() ?>

<?php require(__INCLUDES__ . '/footer.inc.php'); ?>