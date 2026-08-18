<?php
/**
 * @abstract Current member age. This form allows race directors to get the list of members and ages of those members on a select day (race day). This helps the race directors by skipping the step of determining age at registration.
 * @author w. Patrick Gale
 *
 * Feb. 1, 2026 - wpg
 * - changing the export to include those who have lapsed membership but have a birth year and email from past memberships (otherwise we would miss some regulars who simply need to renew their membership)
 * 
 * Jan. 31, 2026 - wpg
 * - Adding this script
 */

require('includes/prepend.inc.php');		/* if you DO NOT have "includes/" in your include_path */
require(__FORMBASE_CLASSES__ . '/MemberContactListFormBase.class.php');
QApplication::CheckRemoteAdmin();

// member age
class acx1CurrentMemberAgeListForm extends MemberContactListFormBase {
	protected $strOption, $btnExport, $colAge, $calStartDate;
	protected function Form_Create() {
		$this->btnExport_Create();

		$this->colLastName = new QDataGridColumn(QApplication::Translate('LastName'), '<?= $_ITEM->LastName; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName, false)));
		$this->colFirstName = new QDataGridColumn(QApplication::Translate('FirstName'), '<?= $_ITEM->FirstName; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName, false)));
		$this->colAge = new QDataGridColumn(QApplication::Translate('AgeOnSelectedDate'), '<?= $_FORM->dtgMemberContact_Age($_ITEM); ?>');
        $this->colGender = new QDataGridColumn(QApplication::Translate('Gender'), '<?= $_ITEM->Gender; ?>');

		// Setup DataGrid
		$this->dtgMemberContact = new QDataGrid($this);
		$this->dtgMemberContact->CellSpacing = 0;
		$this->dtgMemberContact->CellPadding = 4;
		$this->dtgMemberContact->BorderStyle = QBorderStyle::Solid;
		$this->dtgMemberContact->BorderWidth = 1;
		$this->dtgMemberContact->GridLines = QGridLines::Both;
		$this->dtgMemberContact->CssClass='table table-bordered';

		// Datagrid Paginator
		$this->dtgMemberContact->Paginator = new QPaginator($this->dtgMemberContact);
		$this->dtgMemberContact->ItemsPerPage = 5000;

		// Specify Whether or Not to Refresh using Ajax
		$this->dtgMemberContact->UseAjax = false;

		$this->dtgMemberContact->SortColumnIndex = 1;
		$this->dtgMemberContact->SortDirection = 0;

		// Specify the local databind method this datagrid will use
		$this->dtgMemberContact->SetDataBinder('dtgMemberContact_Bind');

		$this->showColumns();
		$this->calStartDate_Create();
	}
	
	
	public function dtgMemberContact_Age(MemberContact $objMemberContact) {
    	if ($objMemberContact->BirthDay && $objMemberContact->BirthMonth && $objMemberContact->BirthYear){
    		return $this->calculateAge($objMemberContact->BirthYear."-".$objMemberContact->BirthMonth."-".$objMemberContact->BirthDay); //__age($objMemberContact);
    	}
    	return "";
	}
	
	protected function calculateAge($dateOfBirth) {
        // Create DateTime objects from the input dates
        // The date format should be YYYY-MM-DD for reliable results, 
        // or you can use date_create_from_format() for other formats
        $dob = new DateTime($dateOfBirth);
        $target = new DateTime($this->calStartDate->Text);
    
        // Calculate the difference between the two dates
        $diff = $dob->diff($target);
    
        // Return the age in a descriptive format or just the years
        return $diff->y;
        // [
        //     'years' => $diff->y,
        //     'months' => $diff->m,
        //     'days' => $diff->d
        // ];
    }
	
	// return age of the member
	protected function __age($objMemberContact) {
		//get age from date of birthdate
	if (!$objMemberContact->BirthYear) return '?';	// return nothing if no birthday
	  $age = (date("md", date("U", mktime(0, 0, 0, $objMemberContact->BirthMonth, $objMemberContact->BirthDay, $objMemberContact->BirthYear))) > date("md")
	    ? ((date("Y") - $objMemberContact->BirthYear) - 1)
	    : (date("Y") - $objMemberContact->BirthYear));
	  return $age;
	}

	// Create and Setup calStartDate
	protected function calStartDate_Create() {
	    $today = QDateTime::Now(false);
		$this->calStartDate = new QTextBox($this);
		$this->calStartDate->Name = QApplication::Translate('Event Date (yyyy-mm-dd): ');
		$this->calStartDate->Text = $today->toString('YYYY-MM-DD');
		$this->calStartDate->AddAction(new QChangeEvent(), new QAjaxAction('dtgMemberContact_Bind'));
	}

	protected function showColumns() {
		$this->dtgMemberContact->AddColumn($this->colFirstName);
		$this->dtgMemberContact->AddColumn($this->colLastName);
		$this->dtgMemberContact->AddColumn($this->colAge);
		$this->dtgMemberContact->AddColumn($this->colGender);
	}

	protected function dtgMemberContact_Bind() {
		$strAndCondition = "";

		// get the number of existing members who do not have memberships expired before today
		$strQuery = "SELECT Id FROM `MemberContact`
		WHERE Id IN (
		SELECT MemberId FROM MembershipAssoc WHERE MembershipLogId IN (
		SELECT Id FROM `MembershipLog`)) AND Email <> '' AND BirthYear <> ''"; // WHERE `ExpireDate` > '".QDateTime::NowToString('YYYY-MM-DD')."')) AND Email <> ''";
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
		if ($objClause = $this->dtgMemberContact->OrderByClause)
			array_push($objClauses, $objClause);

		// Add the LimitClause information, as well
		if ($objClause = $this->dtgMemberContact->LimitClause)
			array_push($objClauses, $objClause);

		$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";
		$this->dtgMemberContact->DataSource = MemberContact::QueryArray(eval("return $strAndCondition;"),$objClauses);
	}

	protected function btnExport_Create(){
		$this->btnExport = new QButton($this);
		$this->btnExport->Text = QApplication::Translate('Export to CSV');
		$this->btnExport->CssClass = "btn btn-primary";
		$this->btnExport->AddAction(new QClickEvent(), new QServerAction('btnExport_Click'));
	}


	protected function btnExport_Click($strFormId, $strControlId, $strParameter) {
		ob_end_clean();	// first silently get rid of any data we have in output
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename=CgtcMemberAgeOn.'.$this->calStartDate->Text.'.csv');
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$temp='FirstName, LastName, AgeAtEvent, Gender'."\n"; // '"FirstName", "LastName", "AgeAtEvent"'."\n";
		$this->dtgMemberContact_Bind();
		$objItems = $this->dtgMemberContact->DataSource;
		foreach ($objItems as $objItem) {
			$temp.= $objItem->FirstName.', '.$objItem->LastName.', '.$this->dtgMemberContact_Age($objItem).', '.$objItem->Gender."\n";
		}
		echo $temp;
		exit;
	}
}

class acx3CurrentMemberAgeListForm extends acx1CurrentMemberAgeListForm {

}

// go to the centralized form executing access control function to run the form and check access control
ACL_Run('CurrentMemberAges');
?>