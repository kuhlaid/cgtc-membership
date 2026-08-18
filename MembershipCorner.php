<?php
/**
 * @abstract Membership corner list.
 * @author w. Patrick Gale
 *
 * Dec. 31, 2017 - wpg
 * - adding membership anniversary years to the newsletter output
 *
 * May 2, 2017 - wpg
 * - adding clarification to the birthday and anniversaries (five year anniversaries)
 *
 * April 26, 2017 - wpg
 * - adding dates to the datagrid titles and setting up milestones for anniversaries and birthdays
 *
 * April 25, 2017 - wpg
 * - setting up basic lists
 */

require('includes/prepend.inc.php');		/* if you DO NOT have "includes/" in your include_path */
require(__FORMBASE_CLASSES__ . '/MemberContactListFormBase.class.php');
QApplication::CheckRemoteAdmin();

// admin access
class acx1MembershipCornerForm extends MemberContactListFormBase {
	protected $dtg1NewMembers, $dtg2MemberAnniversaries, $dtg3MemberBirthdays,
	$col1LastName, $col1FirstName,
	$col2LastName, $col2FirstName, $col2Joined, $col2JoinedMilestone,
	$col3LastName, $col3FirstName,
	$lstMonth, $lstYear,
	$nextMonth, $nextYear, $monthArray,
	$lastMonth, $lastYear,
	$selDate, $txtCopy, $strCopy, $strBirthday, $strMembershipAnniversary;
	protected function Form_Create() {
		$this->strBirthday = "Graduating to a new age group";
		$this->strMembershipAnniversary = "Membership Anniversaries (five year anniversaries)";
		$this->strCopy='';
		$this->lstMonth_Create();
		$this->lstYear_Create();
		$this->nextMonthYear();
		$this->dtg1NewMembers_Create();
		$this->dtg2MemberAnniversaries_Create();
		$this->dtg3MemberBirthdays_Create();
		$this->showColumns();
		$this->headerChange();
		$this->txtCopy_Create();
		$this->bindTables();
	}

	protected function dtg1NewMembers_Create(){
		$this->col1LastName = new QDataGridColumn(QApplication::Translate('Last Name'), '<?= $_FORM->dtg1NewMembers_LastName_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName, false)));
		$this->col1FirstName = new QDataGridColumn(QApplication::Translate('First Name'), '<?= $_ITEM->FirstName; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName, false)));

		// Setup DataGrid
		$this->dtg1NewMembers = new QDataGrid($this);
		$this->dtg1NewMembers->CellSpacing = 0;
		$this->dtg1NewMembers->CellPadding = 4;
		$this->dtg1NewMembers->BorderStyle = QBorderStyle::Solid;
		$this->dtg1NewMembers->BorderWidth = 1;
		$this->dtg1NewMembers->GridLines = QGridLines::Both;
		$this->dtg1NewMembers->CssClass='table table-bordered';

		// Specify Whether or Not to Refresh using Ajax
		$this->dtg1NewMembers->UseAjax = false;

		$this->dtg1NewMembers->SortColumnIndex = 1;
		$this->dtg1NewMembers->SortDirection = 0;

		// Specify the local databind method this datagrid will use
		$this->dtg1NewMembers->SetDataBinder('dtg1NewMembers_Bind');
	}

	public function dtg1NewMembers_LastName_Render(MemberContact $objMemberContact) {
		$this->strCopy.=$objMemberContact->FirstName." ".$objMemberContact->LastName."\n\r";
		return $objMemberContact->LastName;
	}

	protected function dtg2MemberAnniversaries_Create(){
		$this->col2LastName = new QDataGridColumn(QApplication::Translate('Last Name'), '<?= $_FORM->dtg2MemberAnniversaries_LastName_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName, false)));
		$this->col2FirstName = new QDataGridColumn(QApplication::Translate('First Name'), '<?= $_ITEM->FirstName; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName, false)));
		$this->col2Joined = new QDataGridColumn(QApplication::Translate('Joined Club'), '<?= $_ITEM->JoinedClub->toString(); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->JoinedClub), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->JoinedClub, false)));
		$this->col2JoinedMilestone = new QDataGridColumn(QApplication::Translate('Membership Milestone'), '<?= $_FORM->dtg2MemberAnniversaries_Milestone_Render($_ITEM); ?>');


		// Setup DataGrid
		$this->dtg2MemberAnniversaries = new QDataGrid($this);
		$this->dtg2MemberAnniversaries->CellSpacing = 0;
		$this->dtg2MemberAnniversaries->CellPadding = 4;
		$this->dtg2MemberAnniversaries->BorderStyle = QBorderStyle::Solid;
		$this->dtg2MemberAnniversaries->BorderWidth = 1;
		$this->dtg2MemberAnniversaries->GridLines = QGridLines::Both;
		$this->dtg2MemberAnniversaries->CssClass='table table-bordered';

		// Specify Whether or Not to Refresh using Ajax
		$this->dtg2MemberAnniversaries->UseAjax = false;

// 		$this->dtg2MemberAnniversaries->SortColumnIndex = 1;
// 		$this->dtg2MemberAnniversaries->SortDirection = 0;

		// Specify the local databind method this datagrid will use
		$this->dtg2MemberAnniversaries->SetDataBinder('dtg2MemberAnniversaries_Bind');
	}

	public function dtg2MemberAnniversaries_LastName_Render(MemberContact $objMemberContact) {
		return $objMemberContact->LastName;
	}

	public function dtg2MemberAnniversaries_Milestone_Render(MemberContact $objMemberContact) {
		// get the number of years as a member
		$difference = $objMemberContact->JoinedClub->Difference($this->selDate);
		if (!is_null($difference) && -$difference->Years > 4) {
			$yearsInClub = -$difference->Years;
			$fiveYearInc = $yearsInClub % 5;	// we only care about 5 year anniversaries
			if ($fiveYearInc==0)
				return -$difference->Years." years";
		}
		// the years will be negative so that is why we added a negative sign before the output
	}

	protected function dtg3MemberBirthdays_Create(){
		$this->col3LastName = new QDataGridColumn(QApplication::Translate('Last Name'), '<?= $_FORM->dtg3MemberBirthdays_LastName_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName, false)));
		$this->col3FirstName = new QDataGridColumn(QApplication::Translate('First Name'), '<?= $_ITEM->FirstName; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName, false)));

		// Setup DataGrid
		$this->dtg3MemberBirthdays = new QDataGrid($this);
		$this->dtg3MemberBirthdays->CellSpacing = 0;
		$this->dtg3MemberBirthdays->CellPadding = 4;
		$this->dtg3MemberBirthdays->BorderStyle = QBorderStyle::Solid;
		$this->dtg3MemberBirthdays->BorderWidth = 1;
		$this->dtg3MemberBirthdays->GridLines = QGridLines::Both;
		$this->dtg3MemberBirthdays->CssClass='table table-bordered';

		// Specify Whether or Not to Refresh using Ajax
		$this->dtg3MemberBirthdays->UseAjax = false;

		$this->dtg3MemberBirthdays->SortColumnIndex = 1;
		$this->dtg3MemberBirthdays->SortDirection = 0;

		// Specify the local databind method this datagrid will use
		$this->dtg3MemberBirthdays->SetDataBinder('dtg3MemberBirthdays_Bind');
	}

	public function dtg3MemberBirthdays_LastName_Render(MemberContact $objMemberContact) {
		return $objMemberContact->LastName;
	}

	protected function txtCopy_Create() {
		$this->txtCopy = new QTextBox($this);
		$this->txtCopy->Name = QApplication::Translate('Copy: ');
		$this->txtCopy->Width = '100%';
		$this->txtCopy->Rows = 10;
		$this->txtCopy->TextMode = QTextMode::MultiLine;
	}

	protected function setCopyTxt() {
		$str='';
		if ($this->dtg1NewMembers->DataSource) {
			$str = 'New members
';
			foreach ($this->dtg1NewMembers->DataSource as $objMemberContact){
				$str.=$objMemberContact->FirstName." ".$objMemberContact->LastName.'
';
			}
		}
		if ($this->dtg2MemberAnniversaries->DataSource) {
			$str .= '
'.$this->strMembershipAnniversary.'
';
			$milestone='';
			foreach ($this->dtg2MemberAnniversaries->DataSource as $objMemberContact){
				if ($milestone!=$this->dtg2MemberAnniversaries_Milestone_Render($objMemberContact)){
					if ($milestone!='') $str.='
';
					$milestone=$this->dtg2MemberAnniversaries_Milestone_Render($objMemberContact);
					$str.=$milestone.'
';
				}
				$str.=$objMemberContact->FirstName." ".$objMemberContact->LastName.'
';
			}
		}

		if ($this->dtg3MemberBirthdays->DataSource) {
			$str .= '
'.$this->strBirthday.'
';
			foreach ($this->dtg3MemberBirthdays->DataSource as $objMemberContact){
				$str.=$objMemberContact->FirstName." ".$objMemberContact->LastName.'
';
			}
		}
		$this->txtCopy->Text=$str;
	}

	protected function nextMonthYear() {
		// if last month of year then set next month to 01 and increment year
		if ($this->lstMonth->SelectedValue == 12) {
			$this->nextMonth = 1;
			$this->nextYear = $this->lstYear->SelectedValue+1;
		}
		else {
			$this->nextMonth = $this->lstMonth->SelectedValue+1;
			$this->nextYear = $this->lstYear->SelectedValue;
		}

		if ($this->lstMonth->SelectedValue == 1) {
			$this->lastMonth = 12;
			$this->lastYear = $this->lstYear->SelectedValue-1;
		}
		else {
			$this->lastMonth = $this->lstMonth->SelectedValue-1;
			$this->lastYear = $this->lstYear->SelectedValue;
		}

		$this->selDate = new QDateTime($this->nextMonth."/01/".$this->nextYear);
	}

	protected function bindTables(){
		$this->strCopy='';
		$this->nextMonthYear();
		$this->dtg1NewMembers_Bind();
		$this->dtg2MemberAnniversaries_Bind();
		$this->dtg3MemberBirthdays_Bind();
		$this->setCopyTxt();
	}

	protected function lstMonth_Create() {
		$this->lstMonth = new QListBox($this);
		$this->lstMonth->Name = QApplication::Translate('Month: ');
		$this->lstMonth->AddAction(new QChangeEvent(), new QAjaxAction('bindTables'));
		$currentMonth = QDateTime::Now()->toString("MM");
		$this->monthArray = MemberContact::$monthArray;
		if ($this->monthArray) foreach ($this->monthArray as $key=>$value) {
			$objListItem = new QListItem($value, $key);
			if (intval($currentMonth) == intval($key)) {
				$objListItem->Selected = true;
			}
			$this->lstMonth->AddItem($objListItem);
		}
	}

	protected function lstYear_Create() {
		$this->lstYear = new QListBox($this);
		$this->lstYear->Name = QApplication::Translate('Year: ');
		$this->lstYear->AddAction(new QChangeEvent(), new QAjaxAction('bindTables'));
		//$dtTime = new QDateTime();
		$yearMax = QDateTime::Now()->toString("YYYY");
		for ($y=($yearMax+1); $y >= 1975; $y--) {
			$objListItem = new QListItem($y, $y);
			if ($yearMax == $y) {
				$objListItem->Selected = true;
			}
			$this->lstYear->AddItem($objListItem);
		}
	}

	protected function showColumns() {
		$this->dtg1NewMembers->AddColumn($this->col1FirstName);
		$this->dtg1NewMembers->AddColumn($this->col1LastName);

		$this->dtg2MemberAnniversaries->AddColumn($this->col2FirstName);
		$this->dtg2MemberAnniversaries->AddColumn($this->col2LastName);
		//$this->dtg2MemberAnniversaries->AddColumn($this->col2Joined);
		$this->dtg2MemberAnniversaries->AddColumn($this->col2JoinedMilestone);

		$this->dtg3MemberBirthdays->AddColumn($this->col3FirstName);
		$this->dtg3MemberBirthdays->AddColumn($this->col3LastName);
	}

	protected function dtg1NewMembers_Bind() {
		$strAndCondition = "";


		// get new members
		$strQuery = "SELECT Id FROM `MemberContact`
		WHERE Id IN (
		SELECT MemberId FROM MembershipAssoc WHERE MembershipLogId IN (
		SELECT Id FROM `MembershipLog` WHERE `StartDate` >= '".$this->lastYear."-".$this->lastMonth."-01' AND `StartDate` < '".$this->lastYear."-".($this->lastMonth+1)."-01' AND `NewMembership`=1))";

		$objDatabase = MemberContact::GetDatabase();
		$objDbResult = $objDatabase->Query($strQuery);
		$activeMembers = array();
		while ($objDbRow = $objDbResult->FetchArray()) {
			array_push($activeMembers, $objDbRow['Id']);
		}

		if ($activeMembers!='') {
			if ($strAndCondition != '') $strAndCondition .= ',';
			$strAndCondition .= "QQ::In(QQN::MemberContact()->Id, \$activeMembers)";
		}

		// Setup the $objClauses Array
		$objClauses = array();

		// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
		// the OrderByClause to the $objClauses array
		if ($objClause = $this->dtg1NewMembers->OrderByClause)
			array_push($objClauses, $objClause);

		// Add the LimitClause information, as well
		if ($objClause = $this->dtg1NewMembers->LimitClause)
			array_push($objClauses, $objClause);

		$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";
		$this->dtg1NewMembers->DataSource = MemberContact::QueryArray(eval("return $strAndCondition;"),$objClauses);
	}

	protected function dtg2MemberAnniversaries_Bind() {
		$strAndCondition = "";

		// get the number of existing members who do not have memberships expired before today
		$strQuery = "SELECT Id FROM `MemberContact`
		WHERE Id IN (
		SELECT MemberId FROM MembershipAssoc WHERE MembershipLogId IN (
		SELECT Id FROM `MembershipLog` WHERE `ExpireDate` > '".QDateTime::NowToString('YYYY-MM-DD')."')) AND JoinedClub LIKE '%-".sprintf('%02d', $this->lstMonth->SelectedValue)."-%'
				ORDER BY JoinedClub ASC";

		//print $strQuery;
		$objDatabase = MemberContact::GetDatabase();
		$objDbResult = $objDatabase->Query($strQuery);
		$activeMembers = array();
		while ($objDbRow = $objDbResult->FetchArray()) {
			array_push($activeMembers, $objDbRow['Id']);
		}

		if ($activeMembers!='') {
			if ($strAndCondition != '') $strAndCondition .= ',';
			$strAndCondition .= "QQ::In(QQN::MemberContact()->Id, \$activeMembers)";
		}

		// Setup the $objClauses Array
		$objClauses = array();

		// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
		// the OrderByClause to the $objClauses array
		if ($objClause = $this->dtg2MemberAnniversaries->OrderByClause)
			array_push($objClauses, $objClause);

		// Add the LimitClause information, as well
		if ($objClause = $this->dtg2MemberAnniversaries->LimitClause)
			array_push($objClauses, $objClause);

		$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";
		$objMemberContactArray = MemberContact::QueryArray(eval("return $strAndCondition;"),array(),array('Id'));
		$milestoneMembers = array();
		if ($objMemberContactArray) foreach($objMemberContactArray as $objMemberContact){
			// get the number of years as a member
			$difference = $objMemberContact->JoinedClub->Difference($this->selDate);
			if (!is_null($difference) && -$difference->Years > 4) {
				$yearsInClub = -$difference->Years;
				$fiveYearInc = $yearsInClub % 5;	// we only care about 5 year anniversaries
				if ($fiveYearInc==0)
					array_push($milestoneMembers, $objMemberContact->Id);
			}
		}

		if ($milestoneMembers!='') {
			$strAndCondition = "QQ::In(QQN::MemberContact()->Id, \$milestoneMembers)";
		}
		$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";
		$this->dtg2MemberAnniversaries->DataSource = MemberContact::QueryArray(eval("return $strAndCondition;"),$objClauses);
	}

	protected function headerChange() {
		$this->dtg1NewMembers->HtmlBefore = "<h2>New Members <!- for ".$this->monthArray[$this->lastMonth]." ".$this->lastYear."--></h2>";
		$this->dtg2MemberAnniversaries->HtmlBefore = "<h2>".$this->strMembershipAnniversary." <!- for ".$this->monthArray[$this->nextMonth]." ".$this->nextYear."--></h2>";
		$this->dtg3MemberBirthdays->HtmlBefore = "<h2>".$this->strBirthday." <!- for ".$this->monthArray[$this->nextMonth]." ".$this->nextYear."--></h2>";
	}


	protected function dtg3MemberBirthdays_Bind() {
		$strAndCondition = "";

		//$this->headerChange();

		// get the number of existing members who do not have memberships expired before today
		$strQuery = "SELECT Id FROM `MemberContact`
		WHERE Id IN (
		SELECT MemberId FROM MembershipAssoc WHERE MembershipLogId IN (
		SELECT Id FROM `MembershipLog` WHERE `ExpireDate` > '".QDateTime::NowToString('YYYY-MM-DD')."')) AND BirthMonth = '".$this->lstMonth->SelectedValue."'";

		$objDatabase = MemberContact::GetDatabase();
		$objDbResult = $objDatabase->Query($strQuery);
		$activeMembers = array();
		while ($objDbRow = $objDbResult->FetchArray()) {
			array_push($activeMembers, $objDbRow['Id']);
		}

		if ($activeMembers!='') {
			if ($strAndCondition != '') $strAndCondition .= ',';
			$strAndCondition .= "QQ::In(QQN::MemberContact()->Id, \$activeMembers)";
		}

		// Setup the $objClauses Array
		$objClauses = array();

		// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
		// the OrderByClause to the $objClauses array
		if ($objClause = $this->dtg3MemberBirthdays->OrderByClause)
			array_push($objClauses, $objClause);

		// Add the LimitClause information, as well
		if ($objClause = $this->dtg3MemberBirthdays->LimitClause)
			array_push($objClauses, $objClause);

		$objMemberContactArray = MemberContact::QueryArray(eval("return $strAndCondition;"),array(),array('Id'));
		$milestoneMembers = array();
		if ($objMemberContactArray) foreach($objMemberContactArray as $objMemberContact){
			// get the number of years as a member
			$dob = new QDateTime($objMemberContact->BirthMonth."/01/".$objMemberContact->BirthYear);
			$difference = $dob->Difference($this->selDate);
			if (!is_null($difference) && -$difference->Years > 4) {
				$yearsOld = -$difference->Years;
				$fiveYearInc = $yearsOld % 5;	// we only care about 5 year anniversaries
				if ($fiveYearInc==0)
					array_push($milestoneMembers, $objMemberContact->Id);
			}
		}

		if ($milestoneMembers!='') {
			$strAndCondition = "QQ::In(QQN::MemberContact()->Id, \$milestoneMembers)";
		}
		$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";
		$this->dtg3MemberBirthdays->DataSource = MemberContact::QueryArray(eval("return $strAndCondition;"),$objClauses);
	}
}

// news editor access
class acx3MembershipCornerForm extends acx1MembershipCornerForm {}


// go to the centralized form executing access control function to run the form and check access control
ACL_Run('MembershipCorner');
?>