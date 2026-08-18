<?php
/**
 * @abstract Current member emails.
 * @author w. Patrick Gale
 *
 * Nov 11, 2021 - wpg
 * - adding JoinedClub column
 * 
 * Jan. 9, 2019 - wpg
 * - changing the export header and adding the current date to simplify iContact updates
 * 
 * April 19, 2017 - wpg
 * - changing access controls
 *
 * April 14, 2017 - wpg
 * - creating basic list of current member emails
 * - adding export button
 */

require('includes/prepend.inc.php');		/* if you DO NOT have "includes/" in your include_path */
require(__FORMBASE_CLASSES__ . '/MemberContactListFormBase.class.php');
QApplication::CheckRemoteAdmin();

// member emails
class acx1CurrentMemberEmailsListForm extends MemberContactListFormBase {
	protected $strOption, $btnExport;
	protected function Form_Create() {
		$this->btnExport_Create();

		$this->colLastName = new QDataGridColumn(QApplication::Translate('Last Name'), '<?= $_ITEM->LastName; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName, false)));
		$this->colFirstName = new QDataGridColumn(QApplication::Translate('First Name'), '<?= $_ITEM->FirstName; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName, false)));
		$this->colEmail = new QDataGridColumn(QApplication::Translate('Email'), '<?= $_ITEM->Email; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Email), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Email, false)));
		$this->colJoinedClub = new QDataGridColumn(QApplication::Translate('Joined Club'), '<?= $_FORM->dtgMemberContact_JoinedClub_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->JoinedClub), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->JoinedClub, false)));

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

		$this->dtgMemberContact->SortColumnIndex = 3;
		$this->dtgMemberContact->SortDirection = 1;

		// Specify the local databind method this datagrid will use
		$this->dtgMemberContact->SetDataBinder('dtgMemberContact_Bind');

		$this->showColumns();
	}


	protected function showColumns() {
		$this->dtgMemberContact->AddColumn($this->colFirstName);
		$this->dtgMemberContact->AddColumn($this->colLastName);
		$this->dtgMemberContact->AddColumn($this->colEmail);
		$this->dtgMemberContact->AddColumn($this->colJoinedClub);
	}

	protected function dtgMemberContact_Bind() {
		$strAndCondition = "";

		// get the number of existing members who do not have memberships expired before today
		$strQuery = "SELECT Id FROM `MemberContact`
		WHERE Id IN (
		SELECT MemberId FROM MembershipAssoc WHERE MembershipLogId IN (
		SELECT Id FROM `MembershipLog` WHERE `ExpireDate` > '".QDateTime::NowToString('YYYY-MM-DD')."')) AND Email <> ''";
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
		header('Content-Disposition: attachment; filename=cgtc-emails.csv');
		header("Pragma: no-cache");
		header("Expires: 0");
		$temp="[fname]	[lname]	[email]	[lastupdated]\n";	// print iContact header
		$this->dtgMemberContact_Bind();
		if ($this->dtgMemberContact->DataSource) foreach($this->dtgMemberContact->DataSource as $objMemberContact){
			$temp.= $objMemberContact->FirstName."	".$objMemberContact->LastName."	".$objMemberContact->Email."	".QDateTime::NowToString('MM/DD/YYYY')."\n";
		}
		echo $temp;exit;
	}
}

class acx3CurrentMemberEmailsListForm extends acx1CurrentMemberEmailsListForm {

}

// go to the centralized form executing access control function to run the form and check access control
ACL_Run('CurrentMemberEmails');
?>