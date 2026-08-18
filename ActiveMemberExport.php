<?php
/**
 * @abstract Current member export.
 * @author w. Patrick Gale
 *
 * Jan. 2, 2019 - wpg
 * - adding membership expiration column
 * 
 * Dec. 4, 2018 - wpg
 * - creating basic export page
 */

require('includes/prepend.inc.php');		/* if you DO NOT have "includes/" in your include_path */
require(__FORMBASE_CLASSES__ . '/MemberContactListFormBase.class.php');
QApplication::CheckRemoteAdmin();

// member emails
class acx1ActiveMemberExportListForm extends MemberContactListFormBase {
	protected $strOption, $btnExport, $colExpire;
	protected function Form_Create() {
		$this->btnExport_Create();

		$this->colLastName = new QDataGridColumn(QApplication::Translate('Last Name'), '<?= $_ITEM->LastName; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName, false)));
		$this->colFirstName = new QDataGridColumn(QApplication::Translate('First Name'), '<?= $_ITEM->FirstName; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName, false)));
		$this->colEmail = new QDataGridColumn(QApplication::Translate('Email'), '<?= $_ITEM->Email; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Email), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Email, false)));
		$this->colGender = new QDataGridColumn(QApplication::Translate('Gender'), '<?= QString::Truncate($_ITEM->Gender, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Gender), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Gender, false)));
		$this->colBirthDay = new QDataGridColumn(QApplication::Translate('Birth Day'), '<?= $_ITEM->BirthDay; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthDay), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthDay, false)));
		$this->colBirthMonth = new QDataGridColumn(QApplication::Translate('Birth Month'), '<?= $_ITEM->BirthMonth; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthMonth), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthMonth, false)));
		$this->colBirthYear = new QDataGridColumn(QApplication::Translate('Birth Year'), '<?= $_ITEM->BirthYear; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthYear), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthYear, false)));
		$this->colAddr1 = new QDataGridColumn(QApplication::Translate('Addr 1'), '<?= QString::Truncate($_ITEM->Addr1, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Addr1), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Addr1, false)));
		$this->colAddr2 = new QDataGridColumn(QApplication::Translate('Addr 2'), '<?= QString::Truncate($_ITEM->Addr2, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Addr2), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Addr2, false)));
		$this->colCity = new QDataGridColumn(QApplication::Translate('City'), '<?= QString::Truncate($_ITEM->City, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->City), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->City, false)));
		$this->colState = new QDataGridColumn(QApplication::Translate('State'), '<?= QString::Truncate($_ITEM->State, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->State), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->State, false)));
		$this->colZip = new QDataGridColumn(QApplication::Translate('Zip'), '<?= QString::Truncate($_ITEM->Zip, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Zip), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Zip, false)));
		$this->colExpire = new QDataGridColumn(QApplication::Translate('Membership Expires'), '<?= $_FORM->dtgMemberContactExpires_Column_Render($_ITEM) ?>');

		$this->colExpire->HtmlEntities = false;

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
	}


	protected function showColumns() {
		$this->dtgMemberContact->AddColumn($this->colFirstName);
		$this->dtgMemberContact->AddColumn($this->colLastName);
		$this->dtgMemberContact->AddColumn($this->colEmail);
		$this->dtgMemberContact->AddColumn($this->colGender);
		$this->dtgMemberContact->AddColumn($this->colBirthDay);
		$this->dtgMemberContact->AddColumn($this->colBirthMonth);
		$this->dtgMemberContact->AddColumn($this->colBirthYear);
		$this->dtgMemberContact->AddColumn($this->colAddr1);
		$this->dtgMemberContact->AddColumn($this->colAddr2);
		$this->dtgMemberContact->AddColumn($this->colCity);
		$this->dtgMemberContact->AddColumn($this->colState);
		$this->dtgMemberContact->AddColumn($this->colZip);
		$this->dtgMemberContact->AddColumn($this->colExpire);
	}

	public function dtgMemberContactExpires_Column_Render(MemberContact $objMemberContact) {
		$return='';
		// get membership logs for the member (showing only the latest)
		$objMembershipAssoc = MembershipAssoc::GetLatestMembershipForMember($objMemberContact->Id);

		// membership log found
		if ($objMembershipAssoc) {
			return MembershipAssoc::CurrentMembershipExpireString($objMembershipAssoc);
		}
		return "No membership";
	}

	protected function dtgMemberContact_Bind() {
		$strAndCondition = "";

		// get all memberships expired or not
		$strQuery = "SELECT Id FROM `MemberContact`
		WHERE Id IN (
		SELECT MemberId FROM MembershipAssoc WHERE MembershipLogId IN (
		SELECT Id FROM `MembershipLog`))";	// WHERE `ExpireDate` > '".QDateTime::NowToString('YYYY-MM-DD')."'
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
		$this->btnExport->CssClass = 'btn btn-primary';
		$this->btnExport->AddAction(new QClickEvent(), new QServerAction('btnExport_Click'));
	}


	protected function btnExport_Click($strFormId, $strControlId, $strParameter) {
		ob_end_clean();	// first silently get rid of any data we have in output
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename=cgtc-membership.csv');
		header("Pragma: no-cache");
		header("Expires: 0");
		$temp="FirstName	LastName	Email	Gender	BirthDay	BirthMonth	BirthYear	Addr1	Addr2	City	State	Zip	MembershipExpires\n";	// print iContact header
		$this->dtgMemberContact_Bind();
		if ($this->dtgMemberContact->DataSource) foreach($this->dtgMemberContact->DataSource as $objMemberContact){
			$temp.= $objMemberContact->FirstName."	".$objMemberContact->LastName."	".$objMemberContact->Email."	".$objMemberContact->Gender."	".$objMemberContact->BirthDay."	".$objMemberContact->BirthMonth."	".$objMemberContact->BirthYear."	".$objMemberContact->Addr1."	".$objMemberContact->Addr2."	".$objMemberContact->City."	".$objMemberContact->State."	".$objMemberContact->Zip."	".strip_tags($this->dtgMemberContactExpires_Column_Render($objMemberContact))."\n";
		}
		echo $temp;exit;
	}
}


// go to the centralized form executing access control function to run the form and check access control
ACL_Run('ActiveMemberExport');
?>


