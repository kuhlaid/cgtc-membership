<?php
	// This is the HTML template include file (.tpl.php) for the race_list.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent
	// code re-generations do not overwrite your changes.

	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strCGTC_Races___;
	define('__SEL_MENU__',$strPageTitle);
	require(__INCLUDES__ . '/header.inc.php');
	$addLink='';

	function showTabs($strOption) {
		$rtn='';
		$arrayStatus=array("upcoming"=>"Upcoming races","all"=>"All races");
		$rtn .= '<ul class="nav nav-tabs">';
		foreach ($arrayStatus as $key => $value) {
			// default to upcoming
			if ($strOption == $key || ($strOption == '' && $key == "upcoming")) $class = " active font-weight-bold";
			else $class = " ";
			$rtn .= '<li class="nav-item '.$class.' pr-1"><a href="?strOption='.$key.'" class="nav-link '.$class.'">'.$value.'</a></li>';
			//'<a href="?strOption='.$key.'" class="'.$class.'">'.$value.'</a> ';
		}
		$rtn .= "</ul>";
		return $rtn;
	}

	// if membership admin
//	if(checkAccess(1)) {
		$addLink = '<a href="Race.php" class="btn btn-primary">Add a race</a>';
//	}
?>

	<?php $this->RenderBegin() ?>
	<?php print $_glblWrapper;  // NOTE: this flex bootstrap tag MUST BE inside the Qcodo form and not outside of it?> 
<div class="p-2 col-md-12">
<?php // build the page title and critical links ?>
	<div class="d-flex justify-content-between">
        <div class="h1 p-1"><?=$strPageTitle;?></div>
		<div class="p-2"><?php $this->lstDistanceFilter->RenderNoBreaks(); ?></div>
		<div class="p-1"><?=$addLink;?></div>
    </div>
		<?php print showTabs($this->strOption);
		
		$this->dtgRace->Render() ?>
</div>
	<?php $this->RenderEnd() ?>

<?php require(__INCLUDES__ . '/footer.inc.php'); ?>