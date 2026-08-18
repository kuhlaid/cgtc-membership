<?php
/**
 * Dec. 11, 2019 - wpg
 * - adding yearly mileage chart
 */
	
	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strClub_MemberMileageLogs___.' Logs';
	define('__SEL_MENU__',__strClub_MemberMileageLogs___);

	require(__INCLUDES__ . '/header.inc.php');
	
	//$currentYear = QDateTime::Now()->toString('YYYY');
	function showTabs($strOption) {
		$rtn='';
		$arrayStatus=array("my"=>'<span data-toggle="tooltip" title="View your mileage logs and progress" >My mileage</span>',"other"=>"<span class='oi oi-people'></span> <span data-toggle='tooltip' title='See the mileage your fellow members are logging'>Other members</span>","leader"=>"<span class='oi oi-bar-chart'></span> <span data-toggle='tooltip' title='View the total miles logged to date for you and others'>Leader board</span>", "about"=>"<span data-toggle='tooltip' title='Learn more about the challenge'>About the challenge</span>");
		$rtn .= '<ul class="nav nav-tabs">';
		foreach ($arrayStatus as $key => $value) {
			if ($strOption == $key || ($strOption == '' && $key == "my")) $class = " active font-weight-bold";
			else $class = " ";
			$rtn .= '<li class="nav-item '.$class.' pr-1"><a href="?strOption='.$key.'" class="nav-link '.$class.'">'.$value.'</a></li>';
		}
		$rtn .= "</ul>";
		return $rtn;
	}
	//error_log('test membermileagelogs.tpl');
	$strTabs = showTabs($this->strOption);
	$addLink = '<div class="p-1"><a href="MemberMileageLog.php" class="btn btn-primary"><span class="oi oi-plus"></span>  Log mileage</a></div>';
?>
	<?php $this->RenderBegin() ?>
	<?php print $_glblWrapper;  // NOTE: this flex bootstrap tag MUST BE inside the Qcodo form and not outside of it?> 
<div class="p-2 col-md-12">
<?php // build the page title and critical links ?>
	<div class="d-flex justify-content-between">
        <div class="h1 p-1"><?=$strPageTitle;?></div>
		<?=$addLink;?>
    </div>
		<?=$strTabs;?>
		<?php $this->yrMileageGraph->Render(); ?>
<?php if ($this->intMemberMileage > 0 && $this->strOption == 'my') { 
	// NOTE: a material chart will show subtitles but not decimal point data
	?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	$(window).resize(function(){
	  	drawChart();
	});


	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {

	var data = google.visualization.arrayToDataTable([
		['Year', 'My Miles', { role: 'annotation' }, '1,001 Mile Challenge', { role: 'annotation' }],
        ['<?=$this->currentYear;?>', <?=number_format($this->intMemberMileage,1,'.','');?>, '<?=__txtC_RunningPerson__;?>', 1001.0, '<?=__txtC_FinishFlag__;?>']
	]);

	// var data = google.visualization.arrayToDataTable([
	// 	['Year', 'Miles',  { role: 'style' }, { role: 'annotation' }, 'Miles', { role: 'style' }, { role: 'annotation' }],
    //     ['<?=$this->currentYear;?>', <?=number_format($this->intMemberMileage,1);?>, "#fa7380", 'Actual', 1001.0, "#a7fa73", 'Goal']
	// ]);

	var options = {
		title: '1,001 Mile Challenge \n <?=number_format($this->intMemberMileage,1);?> miles logged this year',
		format: 'decimal',
		animation: {
			startup: 'true',
			duration: 2000
		},
		hAxis: {
          title: 'Miles',
          minValue: 0
        },
        vAxis: {
          title: 'Year'
        }
	};

	var chart = new google.visualization.BarChart(document.getElementById('barchart_miles'));
	chart.draw(data, options);

	}
</script>
<?php } ?>
<?php $this->lstMember->RenderNoBreaks() ?>
		<?php $this->lstYear->RenderNoBreaks() ?>
		<?php $this->dtgMemberMileage->Render() ?>
</div>
	<?php $this->RenderEnd() ?>
	
<?php require(__INCLUDES__ . '/footer.inc.php'); ?>