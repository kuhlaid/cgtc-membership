<?php
/**
 * @abstract Shows general stats on the membership.
 * @author w. Patrick Gale
 *
 * May 20, 2017 - wpg
 * - setting up basic
 */
	// Include prepend.inc to load Qcodo
	require('includes/prepend.inc.php');
	QApplication::CheckRemoteAdmin();
	require(__INCLUDES__ . '/header.inc.php');
	?>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<h1>Active members by town</h1><div>(Some may have expired memberships and are still in a grace period. These numbers are simply for getting a sense of where the general population lives.)</div>
  <?php
	$cityState='';
	$cityStateCount=$total=0;
	$objMemberContactArray = MemberContact::QueryArray(
			QQ::OrCondition(
				QQ::Equal(QQN::MemberContact()->NotActive, 0),
				QQ::IsNull(QQN::MemberContact()->NotActive)
			),
			QQ::Clause(QQ::OrderBy(QQN::MemberContact()->City)),array(),array('City','State'));
	if ($objMemberContactArray) foreach($objMemberContactArray as $objMemberContact) {
		$total++;
		$tempCityStateString = $objMemberContact->City.", ".$objMemberContact->State;
		if ($cityState==''){
			$cityState=$tempCityStateString;
		}
		else {
			if ($cityState != $tempCityStateString){
				print $cityState." (".($cityStateCount+1).")<br/>";
				$cityStateCount=0;
				$cityState = $tempCityStateString;
			}
			else
				$cityStateCount++;
		}
	}
	print '<div class="bld">Total: '.$total.'</div>';
	$objMemberContactJoinedArray = MemberContact::QueryArray(
			QQ::OrCondition(
					QQ::Equal(QQN::MemberContact()->NotActive, 0),
					QQ::IsNull(QQN::MemberContact()->NotActive)
			),
			QQ::Clause(QQ::OrderBy(QQN::MemberContact()->JoinedClub)),array(),array('JoinedClub'));
	$yearsInClubArray = array();
	if ($objMemberContactJoinedArray) foreach($objMemberContactJoinedArray as $objMemberContactJoined) {
		//print $objMemberContact->__yearsInClub();
 		if ($objMemberContactJoined->__yearsInClub()!='') {
		    if (!isset($yearsInClubArray[$objMemberContactJoined->__yearsInClub()])) $yearsInClubArray[$objMemberContactJoined->__yearsInClub()] = 0;
			$yearsInClubArray[$objMemberContactJoined->__yearsInClub()]++;
 		}
	}
	?>
	<h1>Active members by years in the club</h1>
	<div><?php foreach ($yearsInClubArray as $years=>$yearCount){
		print "Years in the club: ".$years." (".$yearCount.")<br/>";
	}
	?></div>
	<h1>New memberships by year (not members)</h1>
<?php
$objMembershipLogArray = MembershipLog::QueryArray(
QQ::AndCondition(
	QQ::Equal(QQN::MembershipLog()->NewMembership, 1),
	QQ::LessThan(QQN::MembershipLog()->LogType, 6)
),
QQ::Clause(QQ::OrderBy(QQN::MembershipLog()->StartDate)));
$completedMonth=$strChartTxt='';
$newMembYearTotalArray=array();
if ($objMembershipLogArray) foreach($objMembershipLogArray as $objMembershipLog){
    if (!isset($newMembYearTotalArray[$objMembershipLog->StartDate->toString('YYYY')])) $newMembYearTotalArray[$objMembershipLog->StartDate->toString('YYYY')] = 0;
$newMembYearTotalArray[$objMembershipLog->StartDate->toString('YYYY')]++;
	// the completed month has changed
	if ($completedMonth != $objMembershipLog->StartDate->toString('MMM').$objMembershipLog->StartDate->toString('YY')) {
		$completedMonth = $objMembershipLog->StartDate->toString('MMM').$objMembershipLog->StartDate->toString('YY');	// get the completed month

		// start building the monthly counts
		if ($strChartTxt != '') {
			$strChartTxt .= $completedMonthCount_a.'],';
		}
		$strChartTxt .= "['".$completedMonth."',";

		$completedMonthCount_a = $completedMonthCount_s = 0;
	}
	$completedMonthCount_a++;
}
if ($strChartTxt != '') {
	$strChartTxt .= $completedMonthCount_a.'],';
}
print $strChartTxt;
print_r($newMembYearTotalArray);
	?>

	<h1>Renewal memberships</h1>
<?php
$objMembershipLogArray = MembershipLog::QueryArray(
QQ::AndCondition(
		QQ::Equal(QQN::MembershipLog()->NewMembership, 0),
QQ::LessThan(QQN::MembershipLog()->LogType, 6)
),
	QQ::Clause(QQ::OrderBy(QQN::MembershipLog()->StartDate)));
$completedMonth=$strChartTxt='';
$renewMembYearTotalArray=array();
if ($objMembershipLogArray) foreach($objMembershipLogArray as $objMembershipLog){
    if (!isset($renewMembYearTotalArray[$objMembershipLog->StartDate->toString('YYYY')])) $renewMembYearTotalArray[$objMembershipLog->StartDate->toString('YYYY')] = 0;
	$renewMembYearTotalArray[$objMembershipLog->StartDate->toString('YYYY')]++;
	// the completed month has changed
	if ($completedMonth != $objMembershipLog->StartDate->toString('MMM').$objMembershipLog->StartDate->toString('YY')) {
		$completedMonth = $objMembershipLog->StartDate->toString('MMM').$objMembershipLog->StartDate->toString('YY');	// get the completed month

		// start building the monthly counts
		if ($strChartTxt != '') {
			$strChartTxt .= $completedMonthCount_a.'],';
		}
		$strChartTxt .= "['".$completedMonth."',";

		$completedMonthCount_a = $completedMonthCount_s = 0;
	}
	$completedMonthCount_a++;
}
if ($strChartTxt != '') {
	$strChartTxt .= $completedMonthCount_a.'],';
}
print $strChartTxt;
print_r($renewMembYearTotalArray);
?>
<h1>Members that did not renew (who had a membership expire during the year but did not renew)</h1>
<div>(to be calculated)</div>
<?php
	/* ?>
	<script  type="text/javascript">
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawMultSeries);

	function drawMultSeries() {
	      var data = google.visualization.arrayToDataTable([
	        ['New Members Joined', '2017 Counts', '2018 Counts'],
	        ['New York City, NY', 8175000, 8008000],
	        ['Los Angeles, CA', 3792000, 3694000],
	        ['Chicago, IL', 2695000, 2896000],
	        ['Houston, TX', 2099000, 1953000],
	        ['Philadelphia, PA', 1526000, 1517000]
	      ]);

	      var options = {
	        title: 'New Members Joined',
	        chartArea: {width: '50%'},
	        hAxis: {
	          title: 'Counts',
	          minValue: 0
	        },
	        vAxis: {
	          title: 'Months'
	        }
	      };

	      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
	      chart.draw(data, options);
	    }
	</script>
	<div id="chart_div"></div>
	<?php
	require(__INCLUDES__ .'/footer.inc.php');
	// admin access
// 	class acx1MemberContactEditForm extends QForm {

// 	}
// 	// go to the centralized form executing access control function to run the form and check access control
// 	ACL_Run('Reports');

	/*
	 * protected function txtBlood_Create() {
		// report on blood collected
		$objT4C08Array = T4C08::QueryArray(QQ::Equal(QQN::T4C08()->Complete,1), QQ::Clause(QQ::OrderBy(QQN::T4C08()->CompletedTime)), null, array('q6', 'q9_01','q9_02','q9_04', 'q9_01y','q9_02y','q9_03y', 'completed_time','participant_id'));
		$c08_q6T = $c08_q6Y = $c08_q9_01T = $c08_q9_01Y = $c08_q9_02T = $c08_q9_02Y = $c08_q9_04T = $c08_q9_04Y = $completedMonthCount_a = $completedMonthCount_s = $c08_q10 = $c08_q11 = $c08_q9_01yell = $c08_q9_02yell = $c08_q9_03yell = 0;
		$c08_q6Y_Part = array();
		$completedMonth = $strBloodChartTxt = '';
		$intT4SessionComplete = $intT4ClinicSessionComplete = 0;
		if ($objT4C08Array) foreach ($objT4C08Array as $objT4C08) {

			// the completed month has changed
			if ($completedMonth != $objT4C08->CompletedTime->toString('MMM')) {
				$completedMonth = $objT4C08->CompletedTime->toString('MMM');	// get the completed month

				// start building the monthly counts
				if ($strBloodChartTxt != '') {
					$strBloodChartTxt .= $completedMonthCount_a.','.$completedMonthCount_s.'],';
				}
				$strBloodChartTxt .= "['".$completedMonth."',";

				$completedMonthCount_a = $completedMonthCount_s = 0;
			}
			$completedMonthCount_a++;

			$c08_q9_01T++;
			$c08_q9_02T++;
			$c08_q9_04T++;
			$c08_q6T++;
			// joco blood numbers
			if ($objT4C08->Q901 == 'Y') $c08_q9_01Y++;
			if ($objT4C08->Q902 == 'Y') $c08_q9_02Y++;
			if ($objT4C08->Q904 == 'Y') $c08_q9_04Y++;

			// alphagal blood numbers
			if ($objT4C08->Q901y == 'Y') $c08_q9_01yell++;
			if ($objT4C08->Q902y == 'Y') $c08_q9_02yell++;
			if ($objT4C08->Q903y == 'Y') $c08_q9_03yell++;

			if ($objT4C08->Q6 == 'Y') {
				$c08_q6Y++;
				$completedMonthCount_s++;
			}
			else {
				// participants without blood drawn
				array_push($c08_q6Y_Part, $objT4C08->ParticipantId);
			}

			// Total number of participants in T4 so far who have completed a clinic visit
			$intT4ClinicSessionComplete = T4SessionComplete::QueryCount(
					QQ::AndCondition(
							QQ::IsNotNull(QQN::T4SessionComplete()->ClinicCompleted)
					)
			);

			// Number of participants in T4 so far who have given a partial blood sample (less than what we ask for)
			if (($objT4C08->Q901 == 'N' || $objT4C08->Q902 == 'N' || $objT4C08->Q904 == 'N') && $objT4C08->Q6 == 'Y') {
				$c08_q11++;
			}

			// Number of participants in T4 so far who have  been through clinic but gave NO blood

			$intT4SessionComplete = T4SessionComplete::QueryCount(
					QQ::AndCondition(
							QQ::In(QQN::T4SessionComplete()->ParticipantId, $c08_q6Y_Part),
							QQ::IsNotNull(QQN::T4SessionComplete()->ClinicCompleted)
					)
			);


			// Number of participants in T4 so far from whom we have obtained a complete blood draw (all tubes)
			if ($objT4C08->Q901 == 'Y' && $objT4C08->Q902 == 'Y' && $objT4C08->Q904 == 'Y' && $objT4C08->Q6 == 'Y') {
				$c08_q10++;
			}
		}
		if ($strBloodChartTxt != '') {
			$strBloodChartTxt .= $completedMonthCount_a.','.$completedMonthCount_s.']';
		}

		// report on urine collected
		$objT4C09Array = T4C09::QueryArray(QQ::Equal(QQN::T4C09()->Complete,1), null, null, array('q1','q5'));
		$c09_q1T = $c09_q1Y = $c09_q5T = $c09_q5Y = 0;
		if ($objT4C09Array) foreach ($objT4C09Array as $objT4C09) {
			$c09_q5T++;
			$c09_q1T++;
			if ($objT4C09->Q5 == 'Y') $c09_q5Y++;
			if ($objT4C09->Q1 == 'Y') $c09_q1Y++;
		}

		$this->strBloodChart = new QPlain($this);
		$this->strBloodChart->Text = $strBloodChartTxt;
		// 			"
		// 			['Feb 2013',  1336060,    400361],
		// 	        ['March 2013',  1538156,    366849],
		// 	        ['2005',  1576579,    440514],
		// 	        ['2006',  1600652,    434552],
		// 	        ['2007',  1968113,    393032],
		// 	        ['2008',  1901067,    517206]
		// 			";

		$this->txtBlood = new QPlain($this);
		$this->txtBlood->Text = '
			<h2>JoCo T4 Blood totals</h2>
			<div>Was blood drawn (attempts/successful): <span class="fs18">'.$c08_q6T.'/'.$c08_q6Y.'</span></div>
			<div>Plasma 5 vials (attempts/successful): <span class="fs18">'.$c08_q9_01T.'/'.$c08_q9_01Y.'</span></div>
			<div>1 Vial of White Cells (attempts/successful): <span class="fs18">'.$c08_q9_02T.'/'.$c08_q9_02Y.'</span></div>
			<div>5 Vials of Sera (attempts/successful): <span class="fs18">'.$c08_q9_04T.'/'.$c08_q9_04Y.'</span></div>
			<div>Complete blood draws: <span class="fs18">'.$c08_q10.'</span></div>
			<div>Completed clinic but NO blood drawn: <span class="fs18">'.$intT4SessionComplete.'</span></div>
			<div>Had partial blood draw: <span class="fs18">'.$c08_q11.'</span></div>
			<div>Total clinics completed: <span class="fs18">'.$intT4ClinicSessionComplete.'</span></div>
			<br/>
			<h2>JoCo T4 Urine totals</h2>
			<div>Was urine collected (attempts/successful): <span class="fs18">'.$c09_q1T.'/'.$c09_q1Y.'</span></div>
			<div>5 vials (2 cc) of urine (attempts/successful): <span class="fs18">'.$c09_q5T.'/'.$c09_q5Y.'</span></div>
			<br/>
			<h2>AlphaGal Blood totals</h2>
			<div>Plasma 5 vials: <span class="fs18">'.$c08_q9_01yell.'</span></div>
			<div>1 Vial of White Cells: <span class="fs18">'.$c08_q9_02yell.'</span></div>
			<div>1 Vial of Red Cells: <span class="fs18">'.$c08_q9_03yell.'</span></div>
';
	}
	 */
?>