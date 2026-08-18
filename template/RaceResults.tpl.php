<?php
	// This is the HTML template include file (.tpl.php) for the race_results_list.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent
	// code re-generations do not overwrite your changes.

	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strCGTC_RaceResults___;
	define('__SEL_MENU__',$strPageTitle);
	require(__INCLUDES__ . '/header.inc.php');
	$addLink='';
	// if membership admin
	if(checkAccess(1)) {
		$addLink = '<a href="RaceResult.php?strOption=edit" class="btn btn-primary">Add a race result</a>';
	}
?>

	<?php $this->RenderBegin() ?>
	<?php print $_glblWrapper;  // NOTE: this flex bootstrap tag MUST BE inside the Qcodo form and not outside of it?> 
<div class="p-2 col-md-12">
<?php // build the page title and critical links ?>
	<div class="d-flex justify-content-between">
        <div class="h1 p-1"><?=$strPageTitle;?></div>
		<div class="p-1"><?=$addLink;?></div>
    </div>
		<b>Note:</b> There is no consistent way to convert race result PDF files to plain text and not lose too much of the 
		formatting or have a consistent plain text format (What happened to the days of simple text file race results?).  
		You may use Excel to create [Fixed Width .prn] formatted data from tab or comma delimited data 
		(see this online tool which is simple to use 
		<a href='http://www.convertcsv.com/csv-to-flat-file.htm' target='_blank'>http://www.convertcsv.com/csv-to-flat-file.htm</a>)

		<?php $this->dtgRaceResults->Render() ?>
		</div>
	<?php $this->RenderEnd() ?>

<?php require(__INCLUDES__ . '/footer.inc.php'); ?>