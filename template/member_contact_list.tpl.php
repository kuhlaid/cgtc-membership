<?php
/**
 * Dec. 31, 2017 - wpg
 * - adding member access to this list
 *
 * April 9, 2017 - wpg
 * - adding tabs for filtering all members or expired
 */

	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strClub_MembershipList___;
	define('__SEL_MENU__',$strPageTitle);
	require(__INCLUDES__ . '/header.inc.php');

	function showTabs($strOption) {
		$rtn='';
		$arrayStatus=array("all"=>"All members","showExpired"=>"Expired memberships","notActive"=>"No longer active");
		$rtn .= "<div class='tab_bar'>&nbsp;";
		foreach ($arrayStatus as $key => $value) {
			if ($strOption == $key || ($strOption == '' && $key == "all")) $class = "status_tab_active";
			else $class = "status_tab";
			$rtn .= '<a href="?strOption='.$key.'" class="'.$class.'">'.$value.'</a> ';
		}
		$rtn .= "</div><br/>";
		return $rtn;
	}
	$addLink=$strTabs='';
	// if membership admin
	if(checkAccess(1)) {
		$addLink = '<a href="MemberContact.php" id="createOpt">Add a new member</a>';
	}

	// if membership admin or read only
	if(checkAccess(1) || checkAccess(4)) {
		$strTabs = showTabs($this->strOption);
	}

	$this->RenderBegin();
	$this->objDefaultWaitIcon->Render();?>

		<div class="title"><?=$strPageTitle; ?><?=$addLink;?></div><br/>
	<?
	print $strTabs;
	$this->txtSearch->RenderWithName();/* ?>
Membership expires after <?php $this->dttStart->RenderNoBreaks() ?> or before <?php $this->dttEnd->RenderNoBreaks() ?>
		<?php */ $this->dtgMemberContact->Render() ?>

	<?php $this->RenderEnd() ?>

<?php require(__INCLUDES__ . '/footer.inc.php'); ?>