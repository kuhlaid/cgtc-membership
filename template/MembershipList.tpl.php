<?php
/**
 *
 * April 6, 2018 - wpg
 * - renaming the template file and adding an extra tab for expired for more than 90 days
 *
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
		$arrayStatus=array("all"=>"All members","showExpired"=>"Expired memberships","expired90"=>"Expired 90 days","notActive"=>"No longer active");
		$rtn .= '<ul class="nav nav-tabs">';
		foreach ($arrayStatus as $key => $value) {
			if ($strOption == $key || ($strOption == '' && $key == "all")) $class = " active font-weight-bold";
			else $class = " ";
			$rtn .= '<li class="nav-item '.$class.' pr-1"><a href="?strOption='.$key.'" class="nav-link '.$class.'">'.$value.'</a></li>';
			//'<a href="?strOption='.$key.'" class="'.$class.'">'.$value.'</a> ';
		}
		$rtn .= "</ul>";
		return $rtn;
	}
	$addLink=$strTabs='';
	// if membership admin
	if(checkAccess(1)) {
		$addLink = '<div class="p-1"><a href="MemberContact.php" class="btn btn-primary"><span class="oi oi-plus"></span> Add a new member</a> '.
		'<a href="MembershipList.php?strOption=showExpired&strEmailOption=sendExpirationNotice" class="btn btn-info">Send expiration notice</a></div>';
	}

	// if membership admin or read only
	if(checkAccess(1) || checkAccess(4)) {
		$strTabs = showTabs($this->strOption);
	}

	$this->RenderBegin();
	$this->objDefaultWaitIcon->Render();?>
	<?php print $_glblWrapper;  // NOTE: this flex bootstrap tag MUST BE inside the Qcodo form and not outside of it?> 
<div class="p-2 col-md-12">
    <?php // build the page title and critical links ?>
	<div class="d-flex">
        <div class="h1 p-1"><?=$strPageTitle;?></div><?=$addLink;?>
	</div>
	<?
	print $strTabs;
	$this->txtSearch->RenderWithName();/* ?>
Membership expires after <?php $this->dttStart->RenderNoBreaks() ?> or before <?php $this->dttEnd->RenderNoBreaks() ?>
		<?php */ $this->dtgMemberContact->Render() ?>
</div>
	<?php $this->RenderEnd() ?>

<?php require(__INCLUDES__ . '/footer.inc.php'); ?>