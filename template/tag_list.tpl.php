<?php
	// This is the HTML template include file (.tpl.php) for the tag_list.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent
	// code re-generations do not overwrite your changes.

	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strCGTC_TAGS___;
	define('__SEL_MENU__',$strPageTitle);
	require(__INCLUDES__ . '/header.inc.php');

	$addLink='';
	// if membership admin
	if(checkAccess(1)) {
		$addLink = '<a href="Tag.php" id="createOpt">Add a new tag</a>';
	}
?>

	<?php $this->RenderBegin() ?>
		<div class="title"><?=$strPageTitle; ?><?=$addLink;?></div>
		<div>Note:<br/>
		Jan. 1, 2018 - wpg</br>
		This is a work in progress. The goal is allow members to log their participation in club activities. At the moment
		it is mainly used by volunteers helping with membership.</div>
		<br class="item_divider" />

		<?php $this->dtgTag->Render() ?>

	<?php $this->RenderEnd() ?>

<?php require(__INCLUDES__ . '/footer.inc.php'); ?>