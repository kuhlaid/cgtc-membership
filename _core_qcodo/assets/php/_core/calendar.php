<?php
// wpg - adding Qcodo framework to prevent a cross site scripting exploit by executing a request like
// /t3/assets/php/_core/calendar.php?strFormId=<script>alert(document.domain)</script>
// changed all $_GET requests to use Qcodo framework
require('../../../includes/prepend.inc.php');

	function CastToInt($strNumber) {
		settype($strNumber, "int");
		return $strNumber;
	}
	
	// wpg - running cross site scripting checks on incoming query variables
	$strFormId = _xssCheck(QApplication::QueryString('strFormId'));
	$strId = _xssCheck(QApplication::QueryString('strId'));

	if ((!QApplication::QueryString('intTimestamp'))) {
		$intTimestamp = time();
	} else
		$intTimestamp = _xssCheck(QApplication::QueryString('intTimestamp'));

	$intSelectedMonth = CastToInt(date("n", $intTimestamp));
	$intSelectedDay = CastToInt(date("j", $intTimestamp));
	$intSelectedYear = CastToInt(date("Y", $intTimestamp));
	$intTimestamp = mktime(0,0,0, $intSelectedMonth, $intSelectedDay, $intSelectedYear);
	$dttToday = mktime(0,0,0, date("n"), date("j"), date("Y"));

	/**
	 * wpg - added to allow us to block dates before a certain day
	 * *************************
	 */
	$dblMinimumDate = '';
	$dblMaximumDate = '';
	if (QApplication::QueryString('minimumDate')) {
		$dblMinimumDate = _xssCheck(QApplication::QueryString('minimumDate'));
	}
	if (QApplication::QueryString('maximumDate')) {
		$dblMaximumDate = _xssCheck(QApplication::QueryString('maximumDate'));
	}
	// *************************

	$intMonthStartsOn = CastToInt(date("w", mktime(0,0,0, $intSelectedMonth, 1, $intSelectedYear)));
	$intMonthDays = CastToInt(date("t", $intTimestamp));
	$intPreviousMonthDays = CastToInt(date("t", mktime(0,0,0, $intSelectedMonth - 1, 1, $intSelectedYear)));

	//$strQueryArgs = sprintf("&strFormId=%s&strId=%s", $_GET["strFormId"], $_GET["strId"]);
	$strQueryArgs = sprintf("&strFormId=%s&strId=%s&minimumDate=%s&maximumDate=%s", $strFormId, $strId, $dblMinimumDate, $dblMaximumDate);
	$strChangeCommand = sprintf('window.opener.document.forms["%s"].elements["%s"].value = "%s"; ',
		$strFormId,
		$strId,
		date("M j Y", $intTimestamp));
	$strChangeCommand .= sprintf('window.opener.document.forms["%s"].elements["%s_intTimestamp"].value = "%s"; ',
		$strFormId,
		$strId,
		$intTimestamp);
	$strChangeCommand .= sprintf('if (window.opener.document.forms["%s"].elements["%s"].onchange) window.opener.document.forms["%s"].elements["%s"].onchange();',
		$strFormId,
		$strId,
		$strFormId,
		$strId);
?>
<html>
<head>
	<title>Calendar</title>
	<script>
		function selectDate(intTimestamp) {
			document.location = "calendar.php?intTimestamp=" + intTimestamp + "<?php print($strQueryArgs); ?>";
		}

		function cancel() {
			window.close();
		}

		function done() {
			<?php print($strChangeCommand); ?>
			window.close();
		}
	</script>
	<style>
		.main {
			font-family: verdana, arial, helvetica, sans-serif;
			font-size: 9px;
			text-align: center;
			color: #004d5d
		}

		A {
			text-decoration: none;
		}

		.dropdown {
			background-color: #e5e5e5;
			font-family: arial, helvetica, sans-serif;
			font-size: 8pt;
		}

		.button {
			font-family: verdana, arial, helvetica, sans-serif;
			font-size: 7.5pt;
			font-weight: bold;
			color: #ffffff;
			background-color: #004d5d;
			text-align: center;
			vertical-align: middle;
			height: 18px;
			border: thin solid #223344;
		}

		.offMonth {
			color: #999999;
			background-color: #f0f0f0;
		}

		.onMonth {
			color: #005599;
			background-color: #e0f0f0;
		}

		.selected {
			color: #ffffff;
			background-color: #ee0000;
		}

		td.onMonth, td.offMonth, td.today, td.onMonthWeekend {
			padding:0px;
		}

		a.onMonth, a.offMonth, a.today, a.onMonthWeekend, span.onMonth, span.offMonth, span.today, span.onMonthWeekend {
			display:block;padding:5px;
		}

		a.onMonth:hover, a.today:hover {
			color: #fff;
			background-color: red;
		}

		.onMonthWeekend {
			color: #80aabb;
			background-color: #ffffff;
		}

		.today {
			color: #ffffff;
			background-color: #80aabb;
		}
	</style>
</head>
<body><form method="get" name="myForm"><center>
	<select name="dttMonth" class="dropdown" onchange="selectDate(document.myForm.dttMonth.options[document.myForm.dttMonth.selectedIndex].value)">
<?php
	for ($intMonth = 1; $intMonth <= 12; $intMonth++) {
		$intTimestampLabel = mktime(0,0,0, $intMonth, 1, $intSelectedYear);
		$strLabel = date("F", $intTimestampLabel);
		$strSelected = ($intMonth == $intSelectedMonth) ? "selected" : "";
		printf('<option value="%s" %s>%s</option>', $intTimestampLabel, $strSelected, $strLabel);
	}
?>
	</select> &nbsp;
	<select name="dttYear" class="dropdown" onchange="selectDate(document.myForm.dttYear.options[document.myForm.dttYear.selectedIndex].value)">
<?php
	for ($intYear = 1970; $intYear <= 2010; $intYear++) {
		$intTimestampLabel = mktime(0,0,0, $intSelectedMonth, 1, $intYear);
		$strLabel = date("Y", $intTimestampLabel);
		$strSelected = ($intYear == $intSelectedYear) ? 'selected="selected"' : '';
		printf('<option value="%s" %s>%s</option>', $intTimestampLabel, $strSelected, $strLabel);
	}
?>
	</select>
	<table class="main">
		<tr>
			<td>Su</td>
			<td>Mo</td>
			<td>Tu</td>
			<td>We</td>
			<td>Th</td>
			<td>Fr</td>
			<td>Sa</td>
		</tr>
<?php
	$intDaysBack = ($intMonthStartsOn == 0) ? 7 : $intMonthStartsOn;
	$intIndex = 1 - $intDaysBack;
	$intRowCount = 0;

	while ($intRowCount < 6) {
		print('<tr>');
		for ($intDayOfWeek = 0; $intDayOfWeek <= 6; $intDayOfWeek++) {
			if ($intIndex < 1) {
				$intLabel = $intPreviousMonthDays + $intIndex;
				$intTimestampLabel = mktime(0,0,0, $intSelectedMonth - 1, $intLabel, $intSelectedYear);
				$strCssclass = "offMonth";
			} else if ($intIndex > $intMonthDays) {
				$intLabel = $intIndex - $intMonthDays;
				$intTimestampLabel = mktime(0,0,0, $intSelectedMonth + 1, $intLabel, $intSelectedYear);
				$strCssclass = "offMonth";
			} else {
				$intLabel = $intIndex;
				$intTimestampLabel = mktime(0,0,0, $intSelectedMonth, $intLabel, $intSelectedYear);
				$strCssclass = "onMonth";
				if ((date("w", $intTimestampLabel) == 0) || (date("w", $intTimestampLabel) == 6))
					$strCssclass = "onMonthWeekend";
				else
					$strCssclass = "onMonth";
			}

			if ($intTimestampLabel == $intTimestamp)
				$strCssclass = "selected";
			else if ($intTimestampLabel == $dttToday)
				$strCssclass = "today";

			// wpg - if the minimum date is set and the minimum date is greater then the date being displayed, then show as grayed out
			// else we have an allowed date to select from
			if ($dblMinimumDate != '' && $intTimestampLabel < $dblMinimumDate)
				printf('<td class="offMonth"><span class="offMonth" >%s</span></td>', $intLabel);
			else
				printf('<td class="%s"><a class="%s" href="#" onclick="selectDate(%s);">%s</a></td>', $strCssclass, $strCssclass, $intTimestampLabel, $intLabel);
			$intIndex++;
		}
		print('</tr>');
		$intRowCount++;
	}
?>
		<tr>
			<td colspan="7">Selected Day: <?php print(date("n/j/Y", $intTimestamp)); ?><br />&nbsp;</td>
		</tr>
	</table>
	<input type="button" class="button" name="Done" value="DONE" onclick="done()" /> &nbsp;
	<input type="button" class="button" name="Cancel" value="CANCEL" onclick="cancel()" />
</center></form></body></html>
<?php
	//printf("Month Starts On: %s<br>Month Days: %s<br>Prev Month Days: %s", $intMonthStartsOn, $intMonthDays, $intPreviousMonthDays);
?>