<?php
	// This is the HTML template include file (.tpl.php) for the membership_log_list.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent
	// code re-generations do not overwrite your changes.

	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strClub_MembershipLogs___;
	define('__SEL_MENU__',$strPageTitle);
	require(__INCLUDES__ . '/header.inc.php');
	function showTabs($strOption) {
		$rtn='';
		$arrayStatus=array("all"=>"All logs","expired90"=>"Expired for 90 days");
		$rtn .= '<ul class="nav nav-tabs">';
		foreach ($arrayStatus as $key => $value) {
			if ($strOption == $key || ($strOption == '' && $key == "all")) $class = " active font-weight-bold";
			else $class = " ";
			$rtn .= '<li class="nav-item '.$class.' pr-1"><a href="?strOption='.$key.'" class="nav-link '.$class.'">'.$value.'</a></li>';
		}
		$rtn .= "</ul>";
		return $rtn;
	}
	$strTabs='';
?>

	<?php
	// if membership admin or read only
	if(checkAccess(1) || checkAccess(4)) {
		$strTabs = showTabs($this->strOption);
	}
	$this->RenderBegin(); ?>
<?php print $_glblWrapper;  // NOTE: this flex bootstrap tag MUST BE inside the Qcodo form and not outside of it?> 
<div class="p-2 col-md-12">
    <?php // build the page title and critical links ?>
    <div class="d-flex justify-content-between">
        <div class="h1 p-1"><?=$strPageTitle;?></div>
		
    </div>
		<?php
		print $strTabs;
		/*
<a href="#">Missing payment information filter [in progress]</a><br/>
<a href="#">Current memberships filter [in progress]</a><br/>
*/ ?>
		<?php $this->dtgMembershipLog->Render() ?>
</div>
	<?php $this->RenderEnd() ?>

<?php require(__INCLUDES__ . '/footer.inc.php'); ?>